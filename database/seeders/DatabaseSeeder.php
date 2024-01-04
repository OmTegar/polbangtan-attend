<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Kelas;
use App\Models\Role;
use App\Models\User;
use App\Models\prodi;
use App\Models\blokRuangan;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\KelasSeeder;

use Database\Seeders\ProdiSeeder;
use Database\Seeders\BlokRuanganSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(BlokRuanganSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(ProdiSeeder::class);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'nim' => '1234567890123',
            'blok_ruangan_id' => blokRuangan::where('name', 'A')->first('id'),
            'kelas_id' => Kelas::where('nama_kelas', 'PPB 1-A')->first('id'),
            'no_kamar' => '11',
            'prodi_id' => prodi::where('prodi', 'Informatika')->first('id'),
            'asal_daerah' => 'Malang',
            'no_hp' => '081233219130',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'admin')->first('id'),
        ]);

        User::factory()->create([
            'name' => 'operator',
            'email' => 'operator@gmail.com',
            'nim' => '1234567890234',
            'blok_ruangan_id' => blokRuangan::where('name', 'B')->first('id'),
            'kelas_id' => Kelas::where('nama_kelas', 'PPB 1-B')->first('id'),
            'no_kamar' => '26',
            'prodi_id' => prodi::where('prodi', 'Pertanian')->first('id'),
            'asal_daerah' => 'Malang',
            'no_hp' => '081233217240',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'operator')->first('id'),
        ]);

        User::factory()->create([
            'name' => 'User Account Template (user)',
            'email' => 'user@gmail.com',
            'nim' => '1234567890345',
            'blok_ruangan_id' => blokRuangan::where('name', 'A')->first('id'),
            'kelas_id' => kelas::where('nama_kelas', 'PPB 1-C')->first('id'),
            'no_kamar' => '10',
            'prodi_id' => prodi::where('prodi', 'Informatika')->first('id'),
            'asal_daerah' => 'Malang',
            'no_hp' => '081233217230',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'user')->first('id'),
        ]);

        User::factory()->create([
            'name' => 'User Account Aisyatul (user)',
            'email' => 'useraisya@gmail.com',
            'nim' => '1234567890346',
            'blok_ruangan_id' => blokRuangan::where('name', 'A')->first('id'),
            'kelas_id' => kelas::where('nama_kelas', 'PPB 1-A')->first('id'),
            'no_kamar' => '11',
            'prodi_id' => prodi::where('prodi', 'Informatika')->first('id'),
            'asal_daerah' => 'Malang',
            'no_hp' => '081233217233',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'user')->first('id'),
        ]);

        User::factory()->create([
            'name' => 'Aisyatul Huriyah (operator)',
            'email' => 'operatoraisya@gmail.com',
            'nim' => '1234567890237',
            'blok_ruangan_id' => blokRuangan::where('name', 'A')->first('id'),
            'kelas_id' => Kelas::where('nama_kelas', 'PPB 1-A')->first('id'),
            'no_kamar' => '9',
            'prodi_id' => prodi::where('prodi', 'Pertanian')->first('id'),
            'asal_daerah' => 'Malang',
            'no_hp' => '081233217243',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'operator')->first('id'),
        ]);

        User::factory()->create([
            'name' => 'User Account Meera (user)',
            'email' => 'usermeera@gmail.com',
            'nim' => '123456789789',
            'blok_ruangan_id' => blokRuangan::where('name', 'A')->first('id'),
            'kelas_id' => kelas::where('nama_kelas', 'PPB 1-A')->first('id'),
            'no_kamar' => '11',
            'prodi_id' => prodi::where('prodi', 'Informatika')->first('id'),
            'asal_daerah' => 'Malang',
            'no_hp' => '081233217266',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'user')->first('id'),
        ]);

        User::factory()->create([
            'name' => 'meera (operator)',
            'email' => 'operatormeera@gmail.com',
            'nim' => '123456789678',
            'blok_ruangan_id' => blokRuangan::where('name', 'A')->first('id'),
            'kelas_id' => Kelas::where('nama_kelas', 'PPB 1-A')->first('id'),
            'no_kamar' => '9',
            'prodi_id' => prodi::where('prodi', 'Pertanian')->first('id'),
            'asal_daerah' => 'Malang',
            'no_hp' => '081233217277',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'operator')->first('id'),
        ]);

        // User::factory(400)->create();
             
    }
}
