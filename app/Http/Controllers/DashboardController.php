<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        return inertia('Dashboard', [
            'visits' => [
                'all' => visitors()->paths(auth()->user()->slug)->count(),
                'thisDay' => visitors()->range(now()->startOfDay(), now()->endOfDay())
                                    ->paths(auth()->user()->slug)->count(),
                'thisMonth' => $this->getMonthVisits(),
            ],
        ]);
    }
    private function getMonthVisits()
    {
        $visitCounts = [];
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        for ($date = $startOfMonth; $date <= $endOfMonth; $date->addDay()) {
            $visitCounts[] = [
                'name' => $date->toDateString(),
                'total' => visitors()
                    ->range($date->startOfDay() , $date->copy()->endOfDay())
                    ->paths(auth()->user()->slug)
                    ->count(),
            ];
        }

        return $visitCounts;
    }
}
