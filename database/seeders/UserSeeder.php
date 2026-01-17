<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
        User::create([
            "tipo" => "ADMINISTRADOR",
            "name" => 'Cesar Raul Baca',
            "dni" => '73888312',
            "telefono" => '902517849',
            "email" => 'antonioxd365@gmail.com',
            "password" => bcrypt('bacaxd365'),
            "estado" => 'ACTIVO'
        ]);
        date_default_timezone_set('America/Lima');
        
    }
}
