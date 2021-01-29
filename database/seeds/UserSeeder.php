<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dato para usuario prueba
        $user = new User ();
        $user->name = 'Admin';
        $user->apellidos = 'AdminApellido';
        $user->celular = '72450622';
        $user->email = 'admin@gmail.com';
        $user->email_verified_at = Carbon::now();
        $user->password = '12345678';
        $user->save();

    }
}
