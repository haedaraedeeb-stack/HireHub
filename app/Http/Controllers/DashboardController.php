<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
// use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stats = $this->dashboardService->getAdminStats();
        return $this->success($stats, 'Dashboard data loaded.');
    }
}
