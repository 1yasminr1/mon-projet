<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@elearning.com',
            'password' => Hash::make('admin1234'),
            'role'     => 'admin',
            'statut'   => 'actif',
        ]);
    }
}