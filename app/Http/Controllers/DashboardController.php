<?php

namespace App\Http\Controllers;

use App\Models\Workorder;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get recent activities
        $recentActivities = Workorder::latest()
            ->take(3)
            ->get()
            ->map(function ($workorder) {
                return [
                    'status' => $workorder->status,
                    'created_at' => Carbon::parse($workorder->created_at)->diffForHumans()
                ];
            });

        // Dashboard by role operator accounts
        if (auth()->user()->role == 'pelapor') {
            $countWorkOrdersByPending = Workorder::countWorkOrderByStatusAssigned('Menunggu', auth()->id());
            $countWorkOrdersByProgress = Workorder::countWorkOrderByStatusAssigned('Diproses', auth()->id());
            $countWorkOrdersByCompleted = Workorder::countWorkOrderByStatusAssigned('Dibatalkan', auth()->id());
            $countWorkOrdersByCanceled = Workorder::countWorkOrderByStatusAssigned('Selesai', auth()->id());

            return view('dashboard', compact(
                'countWorkOrdersByPending',
                'countWorkOrdersByProgress',
                'countWorkOrdersByCompleted',
                'countWorkOrdersByCanceled',
                'recentActivities'
            ));
        }

        $countWorkOrdersByPending = Workorder::countWorkOrderByStatus('Menunggu');
        $countWorkOrdersByProgress = Workorder::countWorkOrderByStatus('Diproses');
        $countWorkOrdersByCompleted = Workorder::countWorkOrderByStatus('Dibatalkan');
        $countWorkOrdersByCanceled = Workorder::countWorkOrderByStatus('Selesai');

        return view('dashboard', compact(
            'countWorkOrdersByPending',
            'countWorkOrdersByProgress',
            'countWorkOrdersByCompleted',
            'countWorkOrdersByCanceled',
            'recentActivities'
        ));
    }
}
