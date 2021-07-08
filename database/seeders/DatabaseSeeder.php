<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         \App\Models\User::factory(1)->create();
         $user= new User();
        $user->name= 'admin';
         $user->email= 'admin@gmail.com';
         $user->username= 'admin';
         $user->email_verified_at= now();
         $user->password= Hash::make('admin');
         $user->remember_token = Str::random(10);
         $user->save();


    }
}
