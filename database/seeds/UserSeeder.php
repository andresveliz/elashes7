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
        $user->password = Hash::make('andres0123');
        $user->save();

        $user = new User ();
        $user->name = 'Claudia';
        $user->apellidos = 'Veliz Miranda';
        $user->celular = '72263223';
        $user->email = 'velizmirandacj@gmail.com';
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('claudia223');
        $user->save();

        $user = new User ();
        $user->name = 'Miguel';
        $user->apellidos = 'Escalante Arias';
        $user->celular = '72337889';
        $user->email = 'mickeymotoclasic@gmail.com';
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('miguel723');
        $user->save();

    }
}
