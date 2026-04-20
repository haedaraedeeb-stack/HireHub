<?php
namespace App\Http\Services;

use App\Models\Freelancer;
use App\Models\User;
use Illuminate\Http\UploadedFile;
class FreelancerService
    {
        public function getAvailableFreelancers($filters) {
        $query = Freelancer::query()
            ->with(['user', 'skills'])
            ->withAvg('reviews', 'rating');

        if (!empty($filters['skills'])) {
            $skillsArray = is_array($filters['skills']) ? $filters['skills'] : explode(',', $filters['skills']);
            $query->whereHas('skills', function($q) use ($skillsArray) {
                $q->whereIn('name', $skillsArray);
            });
        }

        $sortBy = $filters['sort_by'] ?? 'newest';
        switch($sortBy) {
            case 'highest_rating':
                $query->orderByDesc('reviews_avg_rating');
                break;
            case 'price_low':
                $query->orderBy('price_per_hour', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        return $query->paginate(15);
    }
        public function getFreelancerDetailes(Freelancer $freelancer)
        {
            return $freelancer->load([
                'user',
                'reviews.user',
                'skills',
            ])->loadAvg('reviews', 'rating')
            ->loadCount(['offers as completed_projects_count' => function($q) {
            $q->where('status', 'accepted');
        }]);
        }

        public function createProfile(User $user, array $data)
        {
            return \DB::transaction(function () use ($user, $data) {
            $skills = $data['skills'] ?? [];
            unset($data['skills']);
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('images', 'public');            }
            $freelancer = $user->freelancer()->create($data);
            foreach ($skills as $skill) {
                $freelancer->skills()->attach($skill['id'], [
                    'experience_years' => $skill['experience'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return $freelancer->load(['user', 'skills']);
            });
        }

        public function updateProfile(Freelancer $freelancer, array $data)
        {
            return \DB::transaction(function () use ($freelancer, $data) {
            if (isset($data['skills'])) {
                $syncSkills = [];
                foreach ($data['skills'] as $skill) {
                    $syncSkills[$skill['id']] = [
                        'experience_years' => $skill['experience'],
                        'updated_at' => now(),
                    ];
                }
                $freelancer->skills()->sync($syncSkills);
                unset($data['skills']);
            }
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $data['image'] = $data['image']->store('images', 'public');
            }
            $freelancer->update($data);
            return $freelancer->load(['user', 'skills']);
        });
    }

}
