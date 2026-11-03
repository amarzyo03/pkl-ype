<?php

namespace Database\Seeders;

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
use App\Models\userModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FinalDemoSeeder extends Seeder
{
    /**
     * Data akun uji coba (semua password: password; hanya untuk lingkungan lokal):
     *
     * | Role  | Username             | Nama / Keterangan                              |
     * |-------|----------------------|------------------------------------------------|
     * | Admin | final.admin          | Admin demo                                     |
     * | Guru  | final.guru1          | Guru Demo Andi; membimbing 2 DUDI              |
     * | Guru  | final.guru2          | Guru Demo Budi; membimbing 2 DUDI              |
     * | Guru  | final.guru3          | Guru Demo Citra; membimbing 1 DUDI             |
     * | Siswa | final.siswa01        | Siswa Demo Alya; pendaftaran disetujui         |
     * | Siswa | final.siswa02        | Siswa Demo Bagas; pendaftaran disetujui        |
     * | Siswa | final.siswa03        | Siswa Demo Caca; pendaftaran disetujui         |
     * | Siswa | final.siswa04        | Siswa Demo Dimas; pendaftaran disetujui        |
     * | Siswa | final.siswa05        | Siswa Demo Eka; pendaftaran disetujui          |
     * | Siswa | final.siswa06        | Siswa Demo Farah; pendaftaran pending          |
     * | Siswa | final.siswa07        | Siswa Demo Gilang; pendaftaran ditolak         |
     *
     * Seeder juga membuat 3 jurusan, 3 kelas, 5 DUDI, 5 absensi,
     * 14 jurnal, 6 tugas, dan 10 status pengumpulan. Aman dijalankan ulang.
     * Jangan gunakan akun/password demo di lingkungan produksi.
     */
    public function run(): void
    {
        $jurusans = collect([
            ['kode' => 'DEMO-RPL', 'nama' => 'Rekayasa Perangkat Lunak'],
            ['kode' => 'DEMO-TKJ', 'nama' => 'Teknik Komputer dan Jaringan'],
            ['kode' => 'DEMO-DKV', 'nama' => 'Desain Komunikasi Visual'],
        ])->map(fn (array $data): jurusanModel => $this->upsertDemoRecord(
            jurusanModel::class,
            ['kode' => $data['kode']],
            ['nama' => $data['nama']],
        ));

        $kelas = collect([
            ['nama' => 'XI RPL Demo', 'jurusan' => 0],
            ['nama' => 'XI TKJ Demo', 'jurusan' => 1],
            ['nama' => 'XI DKV Demo', 'jurusan' => 2],
        ])->map(fn (array $data): kelasModel => $this->upsertDemoRecord(
            kelasModel::class,
            ['nama' => $data['nama']],
            ['id_jurusan' => $jurusans[$data['jurusan']]->id],
        ));

        $gurus = collect([
            'guru1' => 'Guru Demo Andi',
            'guru2' => 'Guru Demo Budi',
            'guru3' => 'Guru Demo Citra',
        ])->map(fn (string $nama): guruModel => $this->upsertDemoRecord(
            guruModel::class,
            ['nama' => $nama],
            [],
        ))->values();

        foreach ($gurus as $index => $guru) {
            $this->upsertDemoRecord(userModel::class, [
                'username' => 'final.guru'.($index + 1),
            ], [
                'id_user' => (string) $guru->id,
                'password' => Hash::make('password'),
                'role' => 'guru',
                'status' => 'active',
            ]);
        }

        $this->upsertDemoRecord(userModel::class, ['username' => 'final.admin'], [
            'id_user' => '1',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $dudiData = [
            ['nama' => 'DUDI Demo Andi 1', 'guru' => 0, 'jurusan' => 0],
            ['nama' => 'DUDI Demo Andi 2', 'guru' => 0, 'jurusan' => 1],
            ['nama' => 'DUDI Demo Budi 1', 'guru' => 1, 'jurusan' => 1],
            ['nama' => 'DUDI Demo Budi 2', 'guru' => 1, 'jurusan' => 2],
            ['nama' => 'DUDI Demo Citra 1', 'guru' => 2, 'jurusan' => 0],
        ];
        $dudis = collect($dudiData)->map(fn (array $data): dudiModel => $this->upsertDemoRecord(
            dudiModel::class,
            ['nama' => $data['nama']],
            [
                'alamat' => 'Jl. Contoh Uji Coba No. '.($data['guru'] + 1),
                'telp' => '08000000000',
                'pic' => 'PIC '.$data['nama'],
                'id_jurusan' => $jurusans[$data['jurusan']]->id,
                'id_guru' => $gurus[$data['guru']]->id,
            ],
        ));

        $studentData = [
            ['nis' => 'DEMO001', 'nisn' => 'DEMONSN001', 'nama' => 'Siswa Demo Alya', 'kelas' => 0, 'dudi' => 0, 'status' => 'disetujui'],
            ['nis' => 'DEMO002', 'nisn' => 'DEMONSN002', 'nama' => 'Siswa Demo Bagas', 'kelas' => 0, 'dudi' => 1, 'status' => 'disetujui'],
            ['nis' => 'DEMO003', 'nisn' => 'DEMONSN003', 'nama' => 'Siswa Demo Caca', 'kelas' => 1, 'dudi' => 0, 'status' => 'disetujui'],
            ['nis' => 'DEMO004', 'nisn' => 'DEMONSN004', 'nama' => 'Siswa Demo Dimas', 'kelas' => 1, 'dudi' => 2, 'status' => 'disetujui'],
            ['nis' => 'DEMO005', 'nisn' => 'DEMONSN005', 'nama' => 'Siswa Demo Eka', 'kelas' => 2, 'dudi' => 3, 'status' => 'disetujui'],
            ['nis' => 'DEMO006', 'nisn' => 'DEMONSN006', 'nama' => 'Siswa Demo Farah', 'kelas' => 0, 'dudi' => 1, 'status' => 'pending'],
            ['nis' => 'DEMO007', 'nisn' => 'DEMONSN007', 'nama' => 'Siswa Demo Gilang', 'kelas' => 2, 'dudi' => 4, 'status' => 'ditolak'],
        ];

        $siswas = collect($studentData)->map(function (array $data, int $index) use ($kelas, $dudis): siswaModel {
            $siswa = $this->upsertDemoRecord(siswaModel::class, [
                'nis' => $data['nis'],
            ], [
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'id_kelas' => $kelas[$data['kelas']]->id,
                'status' => 'active',
            ]);

            $this->upsertDemoRecord(userModel::class, [
                'username' => 'final.siswa'.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
            ], [
                'id_user' => (string) $siswa->id,
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'status' => 'active',
            ]);
            $this->upsertDemoRecord(pendaftaranModel::class, [
                'id_siswa' => (string) $siswa->id,
            ], [
                'id_dudi' => (string) $dudis[$data['dudi']]->id,
                'status' => $data['status'],
            ]);

            return $siswa;
        });

        $today = now();
        $approvedStudentIndexesByGuru = [
            0 => [0, 1, 2],
            1 => [3, 4],
            2 => [],
        ];

        foreach ($siswas as $studentIndex => $siswa) {
            foreach ([0, 1] as $dayOffset) {
                $tanggal = $today->copy()->subDays($dayOffset)->toDateString();
                $this->upsertDemoRecord(jurnalModel::class, [
                    'id_siswa' => $siswa->id,
                    'tanggal' => $tanggal,
                ], [
                    'kegiatan' => 'Kegiatan demo '.($dayOffset + 1).' untuk '.$siswa->nama,
                ]);
            }

            if ($studentIndex < 5) {
                $this->upsertDemoRecord(absensiModel::class, [
                    'id_siswa' => $siswa->id,
                    'keterangan' => 'Absensi demo',
                ], [
                    'tanggal' => $today->copy()->subDay()->toDateString(),
                    'status' => $studentIndex === 2 ? 'izin' : 'hadir',
                    'foto' => null,
                ]);
            }
        }

        foreach ($gurus as $guruIndex => $guru) {
            $tasks = collect([0, 1])->map(fn (int $taskIndex): tugasModel => $this->upsertDemoRecord(
                tugasModel::class,
                ['id_guru' => $guru->id, 'judul' => 'Tugas Demo '.($guruIndex + 1).'.'.($taskIndex + 1)],
                [
                    'tanggal' => $today->copy()->subDays(7 - $taskIndex)->toDateString(),
                    'deskripsi' => 'Tugas contoh untuk uji coba akun guru dan siswa.',
                    'file' => null,
                ],
            ));

            foreach ($approvedStudentIndexesByGuru[$guruIndex] as $studentIndex) {
                foreach ($tasks as $taskIndex => $task) {
                    $this->upsertDemoRecord(tugasStatusModel::class, [
                        'id_tugas' => $task->id,
                        'id_siswa' => $siswas[$studentIndex]->id,
                    ], [
                        'tanggal' => $today->copy()->subDays(2 - $taskIndex)->toDateString(),
                        'status' => $taskIndex === 0 ? 'dikerjakan' : null,
                        'file' => null,
                    ]);
                }
            }
        }
    }

    /**
     * @param  class-string<Model>  $modelClass
     * @param  array<string, int|string>  $identity
     * @param  array<string, int|string|null>  $attributes
     */
    private function upsertDemoRecord(string $modelClass, array $identity, array $attributes): Model
    {
        $record = $modelClass::withTrashed()->updateOrCreate($identity, $attributes);

        if ($record->trashed()) {
            $record->restore();
        }

        return $record;
    }
}
