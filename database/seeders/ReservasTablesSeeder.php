<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

use App\Models\Reservas;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ReservasTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Reservas::create([
            'numpedido' => 123456,
            'tipov' => 'trailer',
            'carga'   =>  1,
            'idusuario' =>  20,
            'cancelada' => 0,
            ]);
         
    }
}