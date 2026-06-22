<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanHarian;
use App\Models\LaporanAkhir;
use App\Models\PengajuanPkl;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class JurnalHarianController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        $pengajuan_disetujui = PengajuanPkl::where('siswa_id', $siswa->id)->where('status', 'disetujui')->first();
        $laporan_akhir_exists = LaporanAkhir::where('siswa_id', $siswa->id)->exists();

        $dates = [];
        $laporansGrouped = collect();
        $laporans = null; // For Riwayat Tab
        $tab = $request->query('tab', 'tracking');

        if ($pengajuan_disetujui) {
            $startDate = Carbon::parse($pengajuan_disetujui->updated_at)->startOfDay();
            $endDate = Carbon::today();
            $period = CarbonPeriod::create($startDate, $endDate);
            $dates = array_reverse($period->toArray());

            $allLogs = LaporanHarian::where('siswa_id', $siswa->id)->get();
            $laporansGrouped = $allLogs->groupBy(function ($log) {
                return Carbon::parse($log->tanggal)->format('Y-m-d');
            });

            if ($tab === 'riwayat') {
                $query = LaporanHarian::where('siswa_id', $siswa->id);
                if ($request->has('search')) {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('kegiatan', 'like', "%{$search}%")
                          ->orWhere('tanggal', 'like', "%{$search}%");
                    });
                }
                $laporans = $query->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->paginate(12);
            }
        }

        return view('dashboard.siswa.jurnal_harian', compact('dates', 'laporansGrouped', 'pengajuan_disetujui', 'laporan_akhir_exists', 'tab', 'laporans'));
    }

    public function create()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        $pengajuan_disetujui = PengajuanPkl::where('siswa_id', $siswa->id)->where('status', 'disetujui')->exists();
        if (!$pengajuan_disetujui) {
            return redirect()->route('siswa.jurnal-harian.index')->with('error', 'Anda belum memiliki tempat PKL yang disetujui.');
        }

        $laporan_akhir = LaporanAkhir::where('siswa_id', $siswa->id)->exists();
        if ($laporan_akhir) {
            return redirect()->route('siswa.jurnal-harian.index')->with('error', 'Anda tidak dapat menambahkan jurnal harian lagi karena Anda sudah mengunggah Laporan Akhir.');
        }

        return view('dashboard.siswa.jurnal_harian_create');
    }

    public function store(Request $request)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        $pengajuan_disetujui = PengajuanPkl::where('siswa_id', $siswa->id)->where('status', 'disetujui')->exists();
        if (!$pengajuan_disetujui) {
            return redirect()->back()->with('error', 'Anda belum memiliki tempat PKL yang disetujui.');
        }

        $laporan_akhir = LaporanAkhir::where('siswa_id', $siswa->id)->exists();
        if ($laporan_akhir) {
            return redirect()->back()->with('error', 'Anda tidak dapat menambahkan jurnal harian lagi karena Anda sudah mengunggah Laporan Akhir.');
        }

        $request->validate([
            'kegiatan' => 'required|string',
            'bukti_foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date',
        ]);

        $tanggal_input = Carbon::parse($request->tanggal)->toDateString();
        $hari_ini = Carbon::today()->toDateString();

        if ($tanggal_input !== $hari_ini) {
            return redirect()->back()->with('error', 'Anda hanya dapat mengisi laporan untuk hari ini. Hari sebelumnya sudah terlewat.');
        }

        $existing = LaporanHarian::where('siswa_id', $siswa->id)
            ->where('tanggal', $tanggal_input)
            ->where('kegiatan', $request->kegiatan)
            ->exists();

        if ($existing) {
            return redirect()->route('siswa.jurnal-harian.index')->with('error', 'Laporan untuk kegiatan yang sama persis sudah ditambahkan hari ini.');
        }

        $filePath = null;
        if ($request->hasFile('bukti_foto')) {
            $filePath = $request->file('bukti_foto')->store('bukti_kegiatan', 'public');
        }

        LaporanHarian::create([
            'siswa_id' => $siswa->id,
            'tanggal' => $tanggal_input,
            'kegiatan' => $request->kegiatan,
            'bukti_foto' => $filePath,
            'status' => 'disetujui',
        ]);

        if ($siswa->pembimbing && $siswa->pembimbing->user) {
            $siswa->pembimbing->user->notify(new \App\Notifications\PklNotification(
                'Jurnal Harian Baru',
                "{$siswa->user->name} telah mengisi jurnal harian untuk tanggal " . \Carbon\Carbon::parse($tanggal_input)->format('d M Y') . ".",
                route('pembimbing.laporan-harian.show', $siswa->id),
                'book-open'
            ));
        }

        return redirect()->route('siswa.jurnal-harian.index')->with('success', 'Jurnal harian berhasil dicatat.');
    }

    public function edit(LaporanHarian $jurnal_harian)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa || $jurnal_harian->siswa_id !== $siswa->id) {
            abort(403, 'Akses ditolak.');
        }

        $laporan_akhir = LaporanAkhir::where('siswa_id', $siswa->id)->exists();
        if ($laporan_akhir) {
            return redirect()->route('siswa.jurnal-harian.index')->with('error', 'Anda tidak dapat mengubah jurnal harian karena Anda sudah mengunggah Laporan Akhir.');
        }

        return view('dashboard.siswa.jurnal_harian_edit', compact('jurnal_harian'));
    }

    public function update(Request $request, LaporanHarian $jurnal_harian)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa || $jurnal_harian->siswa_id !== $siswa->id) {
            abort(403, 'Akses ditolak.');
        }

        $laporan_akhir = LaporanAkhir::where('siswa_id', $siswa->id)->exists();
        if ($laporan_akhir) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah jurnal harian karena Anda sudah mengunggah Laporan Akhir.');
        }

        $request->validate([
            'kegiatan' => 'required|string',
            'bukti_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $filePath = $jurnal_harian->bukti_foto;
        if ($request->hasFile('bukti_foto')) {
            $filePath = $request->file('bukti_foto')->store('bukti_kegiatan', 'public');
        }

        $jurnal_harian->update([
            'kegiatan' => $request->kegiatan,
            'bukti_foto' => $filePath,
        ]);

        return redirect()->route('siswa.jurnal-harian.index', ['tab' => 'riwayat'])->with('success', 'Jurnal harian berhasil diperbarui.');
    }

    public function destroy(LaporanHarian $jurnal_harian)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa || $jurnal_harian->siswa_id !== $siswa->id) {
            abort(403, 'Akses ditolak.');
        }

        $laporan_akhir = LaporanAkhir::where('siswa_id', $siswa->id)->exists();
        if ($laporan_akhir) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus jurnal harian karena Anda sudah mengunggah Laporan Akhir.');
        }

        $jurnal_harian->delete();

        return redirect()->route('siswa.jurnal-harian.index', ['tab' => 'riwayat'])->with('success', 'Jurnal harian berhasil dihapus.');
    }

    public function export()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            abort(403, 'Akses ditolak.');
        }

        $laporans = LaporanHarian::where('siswa_id', $siswa->id)->orderBy('tanggal', 'asc')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.siswa.jurnal_harian_pdf', compact('siswa', 'laporans'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Harian_' . str_replace(' ', '_', $siswa->user->name) . '.pdf');
    }
}
