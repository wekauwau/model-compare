<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['admin', 'Wahyu', 'wahyu', '1234'],
            ['user', 'Eka', 'eka', '1234'],
            ['user', 'Putra', 'putra', '1234'],
        ];

        foreach ($data as $record) {
            User::create([
                'type' => $record[0],
                'name' => $record[1],
                'username' => $record[2],
                'password' => Hash::make($record[3]),
            ]);
        }
    }
}
