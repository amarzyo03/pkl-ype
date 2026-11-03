<?php

use App\Models\dudiModel;
use App\Models\guruModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use App\Models\tugasStatusModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('paginates only the signed-in teachers tasks', function () {
    $guru = guruModel::query()->create(['nama' => 'Guru Penguji']);
    $otherGuru = guruModel::query()->create(['nama' => 'Guru Lain']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-penguji',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);

    for ($taskNumber = 1; $taskNumber <= 16; $taskNumber++) {
        tugasModel::query()->create([
            'id_guru' => $guru->id,
            'tanggal' => '2026-10-29',
            'judul' => sprintf('Tugas %02d', $taskNumber),
            'deskripsi' => 'Deskripsi tugas.',
        ]);
    }

    tugasModel::query()->create([
        'id_guru' => $otherGuru->id,
        'tanggal' => '2026-10-29',
        'judul' => 'Tugas guru lain',
        'deskripsi' => 'Tidak boleh muncul.',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('tugas', ['perPage' => 15, 'page' => 2]))
        ->assertOk()
        ->assertViewIs('userGuru.tugas.index')
        ->assertSee('Menampilkan 16–16 dari 16 tugas')
        ->assertSee('Tugas 01')
        ->assertSee(route('tugas.status', 1), false)
        ->assertDontSee('Tugas 16')
        ->assertDontSee('Tugas guru lain');
});

it('returns matching tasks as an ajax paginated fragment', function () {
    $guru = guruModel::query()->create(['nama' => 'Guru Pencari']);
    $otherGuru = guruModel::query()->create(['nama' => 'Guru Lain']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-pencari',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);

    for ($taskNumber = 1; $taskNumber <= 16; $taskNumber++) {
        tugasModel::query()->create([
            'id_guru' => $guru->id,
            'tanggal' => '2026-10-29',
            'judul' => sprintf('Rangkaian %02d', $taskNumber),
            'deskripsi' => 'Buat rangkaian sederhana.',
        ]);
    }

    tugasModel::query()->create([
        'id_guru' => $guru->id,
        'tanggal' => '2026-10-29',
        'judul' => 'Tugas tanpa kecocokan',
        'deskripsi' => 'Materi berbeda.',
    ]);
    tugasModel::query()->create([
        'id_guru' => $otherGuru->id,
        'tanggal' => '2026-10-29',
        'judul' => 'Rangkaian milik guru lain',
        'deskripsi' => 'Tidak boleh muncul.',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
        ->get(route('tugas', ['search' => 'rangkaian', 'perPage' => 15, 'page' => 2]))
        ->assertOk()
        ->assertViewIs('userGuru.tugas._results')
        ->assertSee('Menampilkan 16–16 dari 16 tugas')
        ->assertSee('Rangkaian 01')
        ->assertDontSee('Rangkaian 16')
        ->assertDontSee('Tugas tanpa kecocokan')
        ->assertDontSee('Rangkaian milik guru lain');
});

it('prevents a teacher from viewing or changing another teachers task', function () {
    Storage::fake('task_attachments');
    $guru = guruModel::query()->create(['nama' => 'Guru Login']);
    $otherGuru = guruModel::query()->create(['nama' => 'Pemilik Tugas']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-login',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);
    $tugas = tugasModel::query()->create([
        'id_guru' => $otherGuru->id,
        'tanggal' => '2026-10-29',
        'judul' => 'Tugas pribadi guru lain',
        'deskripsi' => 'Tidak boleh diubah.',
        'file' => 'tugas-guru-lain.pdf',
    ]);
    Storage::disk('task_attachments')->put('assets/static/tugas/tugas-guru-lain.pdf', 'Lampiran');

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('tugas.edit', $tugas->id))
        ->assertNotFound();
    $this->get(route('tugas.file', $tugas->id))->assertNotFound();
    $this->put(route('tugas.update', $tugas->id), [
        'tanggal' => '2026-10-30',
        'judul' => 'Perubahan tidak sah',
        'deskripsi' => 'Tidak boleh disimpan.',
    ])->assertNotFound();
    $this->delete(route('tugas.delete', $tugas->id))->assertNotFound();

    $this->assertModelExists($tugas);
    Storage::disk('task_attachments')->assertExists('assets/static/tugas/tugas-guru-lain.pdf');
});

it('shows completed and incomplete students for a teachers task', function () {
    $jurusan = jurusanModel::query()->create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);
    $kelas = kelasModel::query()->create([
        'nama' => 'XI RPL 1',
        'id_jurusan' => $jurusan->id,
    ]);
    $guru = guruModel::query()->create(['nama' => 'Guru Status']);
    $otherGuru = guruModel::query()->create(['nama' => 'Guru Lain']);
    $dudi = dudiModel::query()->create([
        'nama' => 'DUDI Bimbingan',
        'alamat' => 'Jl. Industri',
        'telp' => '021123456',
        'pic' => 'PIC',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);
    $otherDudi = dudiModel::query()->create([
        'nama' => 'DUDI Guru Lain',
        'alamat' => 'Jl. Lain',
        'telp' => '021654321',
        'pic' => 'PIC Lain',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $otherGuru->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-status',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);
    $tugas = tugasModel::query()->create([
        'id_guru' => $guru->id,
        'tanggal' => '2026-10-29',
        'judul' => 'Tugas status siswa',
        'deskripsi' => 'Uji status pengerjaan.',
    ]);
    $siswaSelesai = siswaModel::query()->create([
        'nis' => '10001',
        'nisn' => '20001',
        'nama' => 'Siswa Sudah Mengerjakan',
        'id_kelas' => $kelas->id,
    ]);
    $siswaBelum = siswaModel::query()->create([
        'nis' => '10002',
        'nisn' => '20002',
        'nama' => 'Siswa Belum Mengerjakan',
        'id_kelas' => $kelas->id,
    ]);
    $siswaBatal = siswaModel::query()->create([
        'nis' => '10004',
        'nisn' => '20004',
        'nama' => 'Siswa Membatalkan Pengerjaan',
        'id_kelas' => $kelas->id,
    ]);
    $siswaDudiLain = siswaModel::query()->create([
        'nis' => '10003',
        'nisn' => '20003',
        'nama' => 'Siswa DUDI Lain',
        'id_kelas' => $kelas->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswaSelesai->id,
        'id_dudi' => (string) $dudi->id,
        'status' => 'disetujui',
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswaBelum->id,
        'id_dudi' => (string) $dudi->id,
        'status' => 'disetujui',
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswaBatal->id,
        'id_dudi' => (string) $dudi->id,
        'status' => 'disetujui',
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswaDudiLain->id,
        'id_dudi' => (string) $otherDudi->id,
        'status' => 'disetujui',
    ]);
    tugasStatusModel::query()->create([
        'id_tugas' => $tugas->id,
        'id_siswa' => $siswaSelesai->id,
        'tanggal' => '2026-10-29',
        'status' => 'dikerjakan',
        'file' => 'jawaban.pdf',
    ]);
    tugasStatusModel::query()->create([
        'id_tugas' => $tugas->id,
        'id_siswa' => $siswaBatal->id,
        'tanggal' => '2026-10-29',
        'status' => null,
        'file' => null,
    ]);

    $response = $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('tugas.status', $tugas->id));

    $response
        ->assertOk()
        ->assertViewIs('userGuru.tugas.status')
        ->assertSee('Tugas status siswa')
        ->assertSee('Sudah mengerjakan: 1 siswa')
        ->assertSee('Belum mengerjakan: 2 siswa')
        ->assertSee('Siswa Sudah Mengerjakan')
        ->assertSee('Siswa Belum Mengerjakan')
        ->assertSee('Siswa Membatalkan Pengerjaan')
        ->assertSee('Sudah mengerjakan')
        ->assertSee('Belum mengerjakan')
        ->assertDontSee('Siswa DUDI Lain');

    expect(substr_count($response->getContent(), '<table'))->toBe(1);
});

it('does not show status for another teachers task', function () {
    $guru = guruModel::query()->create(['nama' => 'Guru Login']);
    $otherGuru = guruModel::query()->create(['nama' => 'Guru Pemilik']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-status-access',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);
    $tugas = tugasModel::query()->create([
        'id_guru' => $otherGuru->id,
        'tanggal' => '2026-10-29',
        'judul' => 'Tugas guru lain',
        'deskripsi' => 'Tidak boleh diakses.',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('tugas.status', $tugas->id))
        ->assertNotFound();
});
