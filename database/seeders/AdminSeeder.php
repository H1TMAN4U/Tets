<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create(
        //     Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password')-> bcrypt('adminpass');
        //     $table->rememberToken();
        //     $table->timestamps();
        //     }));
            User::create([

            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'email_verified_at'=> now(),
            'password'=> bcrypt('adminpass')

            ])->assignRole('Admin');
    }
}
