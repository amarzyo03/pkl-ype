<?php

namespace App\Http\Controllers;

use App\Models\absensiModel;
use App\Models\dudiModel;
use App\Models\guruModel;
use App\Models\jurnalModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use App\Models\tugasStatusModel;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class dashboardController extends Controller
{
    public function index(): View
    {
        $pendaftaranStatusCounts = pendaftaranModel::query()
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->map(static fn (int|string $count): int => (int) $count);

        $totalPendaftaran = $pendaftaranStatusCounts->sum();
        $pendaftaranPending = $pendaftaranStatusCounts->get('pending', 0);
        $pendaftaranDisetujui = $pendaftaranStatusCounts->get('disetujui', 0);
        $pendaftaranDitolak = $pendaftaranStatusCounts->get('ditolak', 0);
        $siswaAktif = siswaModel::query()->where('status', 'active')->count();
        $jumlahTugas = tugasModel::query()->count();
        $tugasDikerjakanQuery = tugasStatusModel::query()
            ->where('status', 'dikerjakan')
            ->whereIn('id_siswa', siswaModel::query()->where('status', 'active')->select('id'))
            ->whereIn('id_tugas', tugasModel::query()->select('id'))
            ->select('id_siswa', 'id_tugas')
            ->distinct();
        $jumlahTugasDikerjakan = DB::query()
            ->fromSub($tugasDikerjakanQuery->toBase(), 'tugas_dikerjakan')
            ->count();
        $jurnalBulanIniQuery = jurnalModel::query()
            ->whereBetween('tanggal', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
            ->whereIn('id_siswa', siswaModel::query()->where('status', 'active')->select('id'));
        $jumlahJurnalBulanIni = (clone $jurnalBulanIniQuery)->count();
        $jumlahSiswaMengumpulkanJurnal = (clone $jurnalBulanIniQuery)
            ->distinct()
            ->count('id_siswa');

        return view('dashboard.index', [
            'totalSiswa' => siswaModel::query()->count(),
            'siswaAktif' => $siswaAktif,
            'jumlahGuru' => guruModel::query()->count(),
            'jumlahDudi' => dudiModel::query()->count(),
            'jumlahKelas' => kelasModel::query()->count(),
            'jumlahJurusan' => jurusanModel::query()->count(),
            'totalPendaftaran' => $totalPendaftaran,
            'pendaftaranPending' => $pendaftaranPending,
            'pendaftaranDisetujui' => $pendaftaranDisetujui,
            'pendaftaranDitolak' => $pendaftaranDitolak,
            'persentasePending' => $totalPendaftaran > 0 ? (int) round($pendaftaranPending / $totalPendaftaran * 100) : 0,
            'persentaseDisetujui' => $totalPendaftaran > 0 ? (int) round($pendaftaranDisetujui / $totalPendaftaran * 100) : 0,
            'persentaseDitolak' => $totalPendaftaran > 0 ? (int) round($pendaftaranDitolak / $totalPendaftaran * 100) : 0,
            'jumlahTugas' => $jumlahTugas,
            'jumlahTugasDikerjakan' => $jumlahTugasDikerjakan,
            'jumlahTugasBelumDikerjakan' => max(($jumlahTugas * $siswaAktif) - $jumlahTugasDikerjakan, 0),
            'jumlahJurnalBulanIni' => $jumlahJurnalBulanIni,
            'jumlahSiswaBelumMengumpulkanJurnal' => max($siswaAktif - $jumlahSiswaMengumpulkanJurnal, 0),
            'jumlahAbsensi' => absensiModel::query()->count(),
            'jumlahAbsensiHariIni' => absensiModel::query()->whereDate('tanggal', today())->count(),
            'jumlahHadirHariIni' => absensiModel::query()
                ->whereDate('tanggal', today())
                ->where('status', 'hadir')
                ->count(),
            'pendaftaranTerbaru' => pendaftaranModel::query()
                ->with(['siswa.kelas', 'dudi'])
                ->latest()
                ->limit(6)
                ->get(),
        ]);
    }
}
