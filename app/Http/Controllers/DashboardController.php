<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\ServiceNote;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic statistics
        $totalServices = Service::count();
        $totalVehicles = Vehicle::count();
        $totalCustomers = Customer::count();
        $activeServices = Service::where('status', 'in_progress')->count();
        
        // Calculate total revenue from service notes
        $totalRevenue = ServiceNote::sum('cost');

        // Recent services with vehicle information
        $recentServices = Service::with('vehicle')
            ->latest()
            ->take(10)
            ->get();

        // Monthly service data for charts
        $monthlyServices = Service::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months with 0
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthlyServices[$i])) {
                $monthlyServices[$i] = 0;
            }
        }
        ksort($monthlyServices);

        return view('dashboard', compact(
            'totalServices',
            'totalVehicles',
            'totalCustomers',
            'totalRevenue',
            'activeServices',
            'recentServices',
            'monthlyServices'
        ));
    }
} 