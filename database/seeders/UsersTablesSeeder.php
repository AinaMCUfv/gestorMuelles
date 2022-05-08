<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         User::create([
            'name' => 'Aina',
            'email' => '7836112@alumnos.ufv.es',
            'password'   =>  Hash::make('1234'),
            'remember_token' =>  Str::random(10),
            'rol' => 'Admin',
            ]);
         User::create([
            'name' => 'Julia',
            'email' => '123@alumnos.ufv.es',
            'password'   =>  Hash::make('1234'),
            'remember_token' =>  Str::random(10),
            'rol' => 'Admin',
            ]);
          User::create([
            'name' => 'UserA',
            'email' => 'usera@alumnos.ufv.es',
            'password'   =>  Hash::make('1234'),
            'remember_token' =>  Str::random(10),
            'rol' => 'Conductor',
            ]);
          User::create([
            'name' => 'UserB',
            'email' => 'userb@alumnos.ufv.es',
            'password'   =>  Hash::make('1234'),
            'remember_token' =>  Str::random(10),
            'rol' => 'Trabajador',
            ]);
    }
}
