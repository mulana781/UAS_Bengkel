<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Vehicle;
use App\Http\Requests\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:view,service')->only(['show']);
        $this->middleware('can:create,App\Models\Service')->only(['create', 'store']);
        $this->middleware('can:update,service')->only(['edit', 'update']);
        $this->middleware('can:delete,service')->only(['destroy']);
    }

    public function index()
    {
        $services = Service::with(['vehicle.customer'])
            ->latest()
            ->paginate(10);
            
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $vehicles = Vehicle::with('customer')->get();
        return view('services.create', compact('vehicles'));
    }

    public function store(ServiceRequest $request)
    {
        try {
            Service::create($request->validated());
            return redirect()->route('services.index')
                ->with('success', 'Service berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan service: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Service $service)
    {
        $service->load(['vehicle.customer', 'serviceNotes']);
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $vehicles = Vehicle::with('customer')->get();
        return view('services.edit', compact('service', 'vehicles'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        try {
            $service->update($request->validated());
            return redirect()->route('services.index')
                ->with('success', 'Service berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui service: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Service $service)
    {
        try {
            $service->delete();
            return redirect()->route('services.index')
                ->with('success', 'Service berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus service: ' . $e->getMessage());
        }
    }
} 