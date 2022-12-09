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
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'level' => 1,
                'email' => 'admin@admin.com'
            ],
            [
                'name' => 'kasir',
                'username' => 'kasir',
                'password' => bcrypt('kasir'),
                'level' => 2,
                'email' => 'kasir@kasir.com'
            ],
            [
                'name' => 'guru',
                'username' => 'guru',
                'password' => bcrypt('guru'),
                'level' => 3,
                'email' => 'guru@guru.com'
            ],
            [
                'name' => 'siswa',
                'username' => 'siswa',
                'password' => bcrypt('siswa'),
                'level' => 4,
                'email' => 'siswa@siswa.com'
            ],
        ];
        foreach($user as $key => $value)[
            User::create($value)
        ];
    }
}
