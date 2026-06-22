<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempatPkl;
use Illuminate\Support\Facades\Storage;

class TempatPklController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tempat_pkls = TempatPkl::when($search, function ($query, $search) {
            $query->where('nama_instansi', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
        })->latest()->paginate(10);
        return view('dashboard.admin.tempatpkl', compact('tempat_pkls'));
    }

    public function create()
    {
        return view('dashboard.admin.tempatpkl.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_instansi' => 'required|string|max:255|unique:tempat_pkls,nama_instansi',
            'alamat' => 'required|string',
            'kuota' => 'required|integer|min:0',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('tempat_pkl', 'public');
        }

        TempatPkl::create($data);

        return redirect()->route('admin.tempat-pkl.index')->with('success', 'Data Tempat PKL berhasil ditambahkan.');
    }

    public function edit(TempatPkl $tempat_pkl)
    {
        return view('dashboard.admin.tempatpkl.edit', compact('tempat_pkl'));
    }

    public function update(Request $request, TempatPkl $tempat_pkl)
    {
        $request->validate([
            'nama_instansi' => 'required|string|max:255|unique:tempat_pkls,nama_instansi,' . $tempat_pkl->id,
            'alamat' => 'required|string',
            'kuota' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($tempat_pkl->gambar) {
                Storage::disk('public')->delete($tempat_pkl->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('tempat_pkl', 'public');
        }

        $tempat_pkl->update($data);

        return redirect()->route('admin.tempat-pkl.index')->with('success', 'Data Tempat PKL berhasil diperbarui.');
    }

    public function destroy(TempatPkl $tempat_pkl)
    {
        if ($tempat_pkl->gambar) {
            Storage::disk('public')->delete($tempat_pkl->gambar);
        }
        $tempat_pkl->delete();
        return redirect()->route('admin.tempat-pkl.index')->with('success', 'Data Tempat PKL berhasil dihapus.');
    }
}
