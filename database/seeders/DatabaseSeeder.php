<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = \App\Models\User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $dosen = \App\Models\User::create([
            'name' => 'Dosen Budi',
            'email' => 'dosen@dosen.com',
            'password' => bcrypt('password'),
            'role' => 'dosen',
        ]);

        $mhs = \App\Models\User::create([
            'name' => 'Mahasiswa Andi',
            'email' => 'mhs@mhs.com',
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
        ]);

        // Buat dummy course
        $course = \App\Models\Course::create([
            'name' => 'Pemrograman Web',
            'code' => 'TI101',
            'dosen_id' => $dosen->id,
        ]);

        // Daftarkan mahasiswa ke course
        $course->students()->attach($mhs->id);
    }
}
