<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDefault extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'administrator',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'level' => 1,
            ],
            [
                'name' => 'kasir',
                'email' => 'kasir@kasir.com',
                'password' => bcrypt('kasir'),
                'level' => 2,
            ],
            [
                'name' => 'guru',
                'email' => 'guru@guru.com',
                'password' => bcrypt('guru'),
                'level' => 3,
            ],
            [
                'name' => 'siswa',
                'email' => 'siswa@siswa.com',
                'password' => bcrypt('siswa'),
                'level' => 4,
            ],
        ];
        foreach($user as $key => $value)[
            User::create($value)
        ];
    }
}
