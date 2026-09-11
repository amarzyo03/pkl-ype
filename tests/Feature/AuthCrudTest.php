<?php

use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

uses(RefreshDatabase::class);

it('can create a user', function () {
    $response = $this->post(route('auth.save'), [
        'nama' => 'Budi Santoso',
        'username' => 'budisantoso',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
        'role' => 'admin',
        'status' => 'active',
    ]);

    $response->assertRedirect(route('auth'));
    $this->assertDatabaseHas('tb_users', [
        'username' => 'budisantoso',
        'role' => 'admin',
    ]);
});

it('can update and delete a user', function () {
    $user = userModel::create([
        'nama' => 'Ani',
        'username' => 'ani',
        'password' => bcrypt('secret123'),
        'role' => 'siswa',
        'status' => 'active',
    ]);

    $this->put(route('auth.update', $user->id), [
        'nama' => 'Ani Updated',
        'username' => 'ani.updated',
        'role' => 'guru',
        'status' => 'inactive',
    ])->assertRedirect(route('auth'));

    $this->assertDatabaseHas('tb_users', [
        'id' => $user->id,
        'nama' => 'Ani Updated',
        'username' => 'ani.updated',
        'role' => 'guru',
        'status' => 'inactive',
    ]);

    $this->delete(route('auth.delete', $user->id))->assertRedirect(route('auth'));

    $this->assertSoftDeleted('tb_users', [
        'id' => $user->id,
    ]);
});

it('can filter users by role and status on the auth index', function () {
    userModel::create([
        'nama' => 'Admin Active',
        'username' => 'adminactive',
        'password' => bcrypt('secret123'),
        'role' => 'admin',
        'status' => 'active',
    ]);

    userModel::create([
        'nama' => 'Admin Inactive',
        'username' => 'admininactive',
        'password' => bcrypt('secret123'),
        'role' => 'admin',
        'status' => 'inactive',
    ]);

    userModel::create([
        'nama' => 'Student Active',
        'username' => 'studentactive',
        'password' => bcrypt('secret123'),
        'role' => 'siswa',
        'status' => 'active',
    ]);

    $response = $this->get(route('auth', ['role' => 'admin', 'status' => 'active']));

    $response->assertOk();
    $response->assertSee('Admin Active');
    $response->assertDontSee('Admin Inactive');
    $response->assertDontSee('Student Active');
});

it('can import users from an xlsx file', function () {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'TEMPLATE IMPORT DATA USER');
    $sheet->setCellValue('A2', 'Silakan isi data di bawah ini sesuai format yang tersedia.');
    $sheet->fromArray([
        ['nama', 'username', 'password', 'role', 'status'],
        ['Budi Santoso', 'budisantoso', 'secret123', 'admin', null],
        ['Siti Nurhaliza', 'sitinurhaliza', 'secret123', 'guru', null],
    ], null, 'A4');

    $sheet->setCellValueExplicit('E5', 1, DataType::TYPE_NUMERIC);
    $sheet->setCellValueExplicit('E6', 0, DataType::TYPE_NUMERIC);

    $writer = new Xlsx($spreadsheet);
    $tempFile = tempnam(sys_get_temp_dir(), 'users-import-');
    $xlsxPath = $tempFile . '.xlsx';
    unlink($tempFile);
    $writer->save($xlsxPath);

    $file = UploadedFile::fake()->createWithContent('users-import.xlsx', file_get_contents($xlsxPath));

    $this->post(route('auth.import.store'), [
        'file' => $file,
    ])->assertRedirect(route('auth'))
        ->assertSessionHas('success', 'Data user berhasil diimport.');

    $this->assertDatabaseHas('tb_users', [
        'username' => 'budisantoso',
        'role' => 'admin',
        'status' => 'active',
    ]);

    $this->assertDatabaseHas('tb_users', [
        'username' => 'sitinurhaliza',
        'role' => 'guru',
        'status' => 'inactive',
    ]);

    unlink($xlsxPath);
});
