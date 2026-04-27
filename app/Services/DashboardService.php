<?php

namespace App\Services;

use App\Models\User;
use App\Models\Project;
use App\Models\Offer;

class DashboardService
{
    public function getAdminStats()
    {
        return [
            'total_users' => User::count(),
            'total_projects' => Project::withoutGlobalScopes()->count(),
            'total_offers' => Offer::count(),
            'total_market_value' => Offer::where('status', 'accepted')->sum('price'),

            'active_tasks' => Project::where('status', 'in_progress')->count(),
        ];
    }
}
