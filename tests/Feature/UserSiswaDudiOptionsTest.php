<?php

test('groups DUDI options by jurusan on the registration form', function () {
    $dudi = collect([
        (object) [
            'id' => 1,
            'nama' => 'PT Contoh',
            'id_jurusan' => 10,
            'jurusan' => (object) ['nama' => 'RPL'],
        ],
        (object) [
            'id' => 2,
            'nama' => 'CV Contoh',
            'id_jurusan' => 20,
            'jurusan' => (object) ['nama' => 'TKJ'],
        ],
    ]);
    $siswa = (object) ['id' => 1, 'nama' => 'Siswa Contoh'];

    $this->withViewErrors([])->view('userSiswa.pendaftaran.pendaftaran', compact('dudi', 'siswa'))
        ->assertSee('<optgroup label="RPL">', false)
        ->assertSee('<optgroup label="TKJ">', false)
        ->assertSee('value="1"', false)
        ->assertSee('value="2"', false);
});

test('groups DUDI options by jurusan on the edit form and preserves the current choice', function () {
    $dudi = collect([
        (object) [
            'id' => 1,
            'nama' => 'PT Contoh',
            'id_jurusan' => 10,
            'jurusan' => (object) ['nama' => 'RPL'],
        ],
        (object) [
            'id' => 2,
            'nama' => 'CV Contoh',
            'id_jurusan' => 20,
            'jurusan' => (object) ['nama' => 'TKJ'],
        ],
    ]);
    $siswa = (object) ['id' => 1, 'nama' => 'Siswa Contoh'];
    $pendaftaran = (object) [
        'id' => 1,
        'dudi' => (object) ['id' => 2],
    ];

    $this->withViewErrors([])->view('userSiswa.pendaftaran.edit', compact('dudi', 'pendaftaran', 'siswa'))
        ->assertSee('<optgroup label="RPL">', false)
        ->assertSee('<optgroup label="TKJ">', false)
        ->assertSee('value="2" selected', false);
});
