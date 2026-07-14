<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempatPkl;
use Illuminate\Support\Facades\Storage;

class TempatPklController extends Controller
{
    /**
     * Menampilkan daftar Tempat PKL beserta filter pencariannya.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jurusan = $request->input('jurusan'); // Filter tambahan berdasar jurusan
        
        $tempat_pkls = TempatPkl::when($search, function ($query, $search) {
            // Pencarian nama instansi atau alamat menggunakan 'like'
            $query->where(function($q) use ($search) {
                $q->where('nama_instansi', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        })
        ->when($jurusan, function ($query, $jurusan) {
            $query->where('jurusan', $jurusan);
        })
        ->latest()->paginate(10);
        
        return view('dashboard.admin.tempatpkl', compact('tempat_pkls'));
    }

    /**
     * Menampilkan halaman form untuk menambah Tempat PKL.
     */
    public function create()
    {
        return view('dashboard.admin.tempatpkl.create');
    }

    /**
     * Menyimpan Tempat PKL ke database dan mengunggah gambar.
     */
    public function store(Request $request)
    {
        // Validasi input form, termasuk tipe file gambar (jpg, png) dan maksimum ukuran (2 MB).
        $request->validate([
            'nama_instansi' => 'required|string|max:255|unique:tempat_pkls,nama_instansi',
            'jurusan' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'kuota' => 'required|integer|min:0',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Menyimpan file gambar:
        // Metode store('nama_folder', 'public') akan menyimpan file di 'storage/app/public/nama_folder'
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('tempat_pkl', 'public');
        }

        TempatPkl::create($data);

        return redirect()->route('admin.tempat-pkl.index')->with('success', 'Data Tempat PKL berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman edit tempat PKL.
     */
    public function edit(TempatPkl $tempat_pkl)
    {
        return view('dashboard.admin.tempatpkl.edit', compact('tempat_pkl'));
    }

    /**
     * Menyimpan pembaruan tempat PKL.
     */
    public function update(Request $request, TempatPkl $tempat_pkl)
    {
        $request->validate([
            'nama_instansi' => 'required|string|max:255|unique:tempat_pkls,nama_instansi,' . $tempat_pkl->id,
            'jurusan' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'kuota' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // gambar dibuat nullable (opsional diubah)
        ]);

        $data = $request->all();

        // Memeriksa jika ada file gambar yang diunggah saat mengedit
        if ($request->hasFile('gambar')) {
            // Hapus gambar fisik lama di storage agar tidak memenuhi ruang penyimpanan server.
            if ($tempat_pkl->gambar) {
                Storage::disk('public')->delete($tempat_pkl->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('tempat_pkl', 'public');
        }

        $tempat_pkl->update($data);

        return redirect()->route('admin.tempat-pkl.index')->with('success', 'Data Tempat PKL berhasil diperbarui.');
    }

    /**
     * Menghapus Tempat PKL beserta file gambarnya.
     */
    public function destroy(TempatPkl $tempat_pkl)
    {
        // Sebelum data dihapus dari database, pastikan file gambar di folder public juga dihapus secara fisik.
        if ($tempat_pkl->gambar) {
            Storage::disk('public')->delete($tempat_pkl->gambar);
        }
        $tempat_pkl->delete();
        
        return redirect()->route('admin.tempat-pkl.index')->with('success', 'Data Tempat PKL berhasil dihapus.');
    }
}
