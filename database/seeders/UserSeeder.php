<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        date_default_timezone_set('America/Lima');
        User::create([
            "tipo" => "ADMINISTRADOR",
            "name" => 'Cesar Raul Baca',
            "dni" => '73888312',
            "telefono" => '902517849',
            "email" => 'antonioxd365@gmail.com',
            "password" => bcrypt('bacaxd365'),
            "estado" => 'ACTIVO'
        ]);

        User::create([
            "tipo" => "ADMINISTRADOR",
            "name" => 'Gabriella Cassan',
            "dni" => '00000000',
            "telefono" => '0000000000',
            "email" => 'gabriella@semmar-manufacturing.com',
            "password" => bcrypt('12345678'),
            "estado" => 'ACTIVO'
        ]);


        $users = [
            ['name' => 'ARTURO BALTA', 'dni' => '32819283'],
            ['name' => 'JIMMY LOPEZ AGURTO', 'dni' => '41568303'],
            ['name' => 'JAIME LOPEZ AGURTO', 'dni' => '42482155'],
            ['name' => 'ALAN JARA RODRIGUEZ', 'dni' => '43973291'],
            ['name' => 'SAMUEL CASAMAYOR', 'dni' => '71386526', 'tipo' => 'ALMACENERO'],
            ['name' => 'ERICK HERNANDEZ', 'dni' => '75118348'],
            ['name' => 'ANTONIO LA TORRE', 'dni' => '41725600'],
            ['name' => 'JUAN ALBA', 'dni' => '32848010'],
            ['name' => 'JOSE', 'dni' => '75697481'],
        ];

        foreach ($users as $user) {
            User::create([
                'tipo' => $user['tipo'] ?? 'OPERADOR',
                'name' => $user['name'],
                'dni' => $user['dni'],
                'telefono' => 00000000,
                'email' => $user['dni'] . '@semmar-manufacturing.com',
                'password' => Hash::make($user['dni']),
                'estado' => 'ACTIVO',
            ]);
        }
    }
}
