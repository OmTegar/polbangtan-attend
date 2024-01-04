<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\JenisKelas;
use App\Models\LevelKelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seeder untuk Jenis Kelas
        JenisKelas::create(['nama_jenis_kelas' => 'PPB']);
        JenisKelas::create(['nama_jenis_kelas' => 'PPKH']);
        JenisKelas::create(['nama_jenis_kelas' => 'Agrinak']);

        // Seeder untuk Level Kelas
        LevelKelas::create(['nama_level_kelas' => 'A']);
        LevelKelas::create(['nama_level_kelas' => 'B']);
        LevelKelas::create(['nama_level_kelas' => 'C']);

        // Seeder untuk Kelas
        foreach (JenisKelas::all() as $jenisKelas) {
            foreach (LevelKelas::all() as $levelKelas) {
                for ($i = 1; $i <= 4; $i++) {
                    Kelas::create([
                        'kelas' =>  $i,
                        'nama_kelas' => $jenisKelas->nama_jenis_kelas . ' ' . $i . '-' . $levelKelas->nama_level_kelas,
                        'jenis_kelas_id' => $jenisKelas->id,
                        'level_kelas_id' => $levelKelas->id,
                    ]);
                }
            }
        }

        // Kelas::create([
        //     'kelas' =>  5,
        //     'nama_kelas' => 'PPKH 5-A',
        //     'jenis_kelas_id' => 2,
        //     'level_kelas_id' => 1,
        // ]);
        // Kelas::create([
        //     'kelas' =>  5,
        //     'nama_kelas' => 'PPKH 5-B',
        //     'jenis_kelas_id' => 2,
        //     'level_kelas_id' => 2,
        // ]);
        // Kelas::create([
        //     'kelas' =>  5,
        //     'nama_kelas' => 'PPKH 5-C',
        //     'jenis_kelas_id' => 2,
        //     'level_kelas_id' => 3,
        // ]);
        // Kelas::create([
        //     'kelas' =>  6,
        //     'nama_kelas' => 'PPKH 6-A',
        //     'jenis_kelas_id' => 2,
        //     'level_kelas_id' => 1,
        // ]);
        // Kelas::create([
        //     'kelas' =>  6,
        //     'nama_kelas' => 'PPKH 6-B',
        //     'jenis_kelas_id' => 2,
        //     'level_kelas_id' => 2,
        // ]);
        // Kelas::create([
        //     'kelas' =>  6,
        //     'nama_kelas' => 'PPKH 6-C',
        //     'jenis_kelas_id' => 2,
        //     'level_kelas_id' => 3,
        // ]);
        // Kelas::create([
        //     'kelas' =>  7,
        //     'nama_kelas' => 'PPKH 7-A',
        //     'jenis_kelas_id' => 2,
        //     'level_kelas_id' => 1,
        // ]);
        // Kelas::create([
        //     'kelas' =>  7,
        //     'nama_kelas' => 'PPKH 7-B',
        //     'jenis_kelas_id' => 2,
        //     'level_kelas_id' => 2,
        // ]);
        // Kelas::create([
        //     'kelas' =>  7,
        //     'nama_kelas' => 'PPKH 7-C',
        //     'jenis_kelas_id' => 2,
        //     'level_kelas_id' => 3,
        // ]);
    }
}
