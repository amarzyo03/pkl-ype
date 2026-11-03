<?php

use App\Models\absensiModel;
use App\Models\dudiModel;
use App\Models\guruModel;
use App\Models\jurnalModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use App\Models\tugasStatusModel;
use App\Models\userModel;
use Database\Seeders\FinalDemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('seeds complete repeatable final demo data for each role', function () {
    $seeder = app(FinalDemoSeeder::class);

    $seeder->run();
    $seeder->run();

    expect(guruModel::query()->count())->toBe(3)
        ->and(dudiModel::query()->count())->toBe(5)
        ->and(siswaModel::query()->count())->toBe(7)
        ->and(pendaftaranModel::query()->count())->toBe(7)
        ->and(absensiModel::query()->count())->toBe(5)
        ->and(jurnalModel::query()->count())->toBe(14)
        ->and(tugasModel::query()->count())->toBe(6)
        ->and(tugasStatusModel::query()->count())->toBe(10)
        ->and(userModel::query()->count())->toBe(11);

    $guruPertama = guruModel::query()->where('nama', 'Guru Demo Andi')->firstOrFail();
    expect(dudiModel::query()->where('id_guru', $guruPertama->id)->count())->toBe(2);

    $guruAkun = userModel::query()->where('username', 'final.guru1')->firstOrFail();
    expect($guruAkun->role)->toBe('guru')
        ->and($guruAkun->id_user)->toBe((string) $guruPertama->id)
        ->and(Hash::check('password', $guruAkun->password))->toBeTrue();

    $siswaAkun = userModel::query()->where('username', 'final.siswa01')->firstOrFail();
    expect($siswaAkun->role)->toBe('siswa')
        ->and(Hash::check('password', $siswaAkun->password))->toBeTrue();
});
