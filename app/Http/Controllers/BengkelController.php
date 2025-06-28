<?php

namespace App\Http\Controllers;

use App\Models\Bengkel;
use Illuminate\Http\Request;

class BengkelController extends Controller
{
    public function index()
    {
        $bengkels = Bengkel::latest()->paginate(10);
        return view('bengkel.index', compact('bengkels'));
    }

    public function create()
    {
        return view('bengkel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bengkel' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'nullable|email',
            'jam_operasional' => 'required',
        ]);

        Bengkel::create($request->all());

        return redirect()->route('bengkel.index')
            ->with('success', 'Bengkel berhasil ditambahkan.');
    }

    public function show(Bengkel $bengkel)
    {
        return view('bengkel.show', compact('bengkel'));
    }

    public function edit(Bengkel $bengkel)
    {
        return view('bengkel.edit', compact('bengkel'));
    }

    public function update(Request $request, Bengkel $bengkel)
    {
        $request->validate([
            'nama_bengkel' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'nullable|email',
            'jam_operasional' => 'required',
        ]);

        $bengkel->update($request->all());

        return redirect()->route('bengkel.index')
            ->with('success', 'Bengkel berhasil diperbarui.');
    }

    public function destroy(Bengkel $bengkel)
    {
        $bengkel->delete();

        return redirect()->route('bengkel.index')
            ->with('success', 'Bengkel berhasil dihapus.');
    }
}
