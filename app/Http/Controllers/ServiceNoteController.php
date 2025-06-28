<?php

namespace App\Http\Controllers;

use App\Models\ServiceNote;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ServiceNoteController extends Controller
{
    public function index()
    {
        $serviceNotes = ServiceNote::with(['service.vehicle'])->latest()->paginate(10);
        
        // Get profit data for charts
        $dailyProfit = $this->getDailyProfit();
        $weeklyProfit = $this->getWeeklyProfit();
        $monthlyProfit = $this->getMonthlyProfit();
        $yearlyProfit = $this->getYearlyProfit();

        return view('service_notes.index', compact('serviceNotes', 'dailyProfit', 'weeklyProfit', 'monthlyProfit', 'yearlyProfit'));
    }

    private function getDailyProfit()
    {
        return ServiceNote::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(cost) as total')
        )
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getWeeklyProfit()
    {
        return ServiceNote::select(
            DB::raw('YEARWEEK(created_at) as week'),
            DB::raw('SUM(cost) as total')
        )
            ->whereBetween('created_at', [Carbon::now()->subWeeks(12), Carbon::now()])
            ->groupBy('week')
            ->orderBy('week')
            ->get();
    }

    private function getMonthlyProfit()
    {
        return ServiceNote::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(cost) as total')
        )
            ->whereBetween('created_at', [Carbon::now()->subMonths(12), Carbon::now()])
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    private function getYearlyProfit()
    {
        return ServiceNote::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(cost) as total')
        )
            ->whereBetween('created_at', [Carbon::now()->subYears(5), Carbon::now()])
            ->groupBy('year')
            ->orderBy('year')
            ->get();
    }

    public function create()
    {
        $services = Service::with('vehicle')->get();
        return view('service_notes.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'note' => 'required|string',
            'cost' => 'required|integer|min:0'
        ]);

        ServiceNote::create($request->all());

        return redirect()->route('services.show', $request->service_id)
            ->with('success', 'Catatan servis berhasil ditambahkan.');
    }

    public function show(ServiceNote $serviceNote)
    {
        $serviceNote->load('service.vehicle');
        return view('service_notes.show', compact('serviceNote'));
    }

    public function edit(ServiceNote $serviceNote)
    {
        $services = Service::with('vehicle')->get();
        return view('service_notes.edit', compact('serviceNote', 'services'));
    }

    public function update(Request $request, ServiceNote $serviceNote)
    {
        $request->validate([
            'note' => 'required|string',
            'cost' => 'required|integer|min:0'
        ]);

        $serviceNote->update($request->all());

        return redirect()->route('services.show', $serviceNote->service_id)
            ->with('success', 'Catatan servis berhasil diperbarui.');
    }

    public function destroy(ServiceNote $serviceNote)
    {
        $service_id = $serviceNote->service_id;
        $serviceNote->delete();

        return redirect()->route('services.show', $service_id)
            ->with('success', 'Catatan servis berhasil dihapus.');
    }
} 