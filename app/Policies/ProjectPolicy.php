<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
// use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->role === 'client' && $user->id === $project->user_id;
    }
}
