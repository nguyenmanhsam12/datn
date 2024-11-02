<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name','admin')->first();
        $authorRole = Role::where('name','author')->first();
        $userRole = Role::where('name','user')->first();

        $admin = User::create([
            'name'=>'Nguyễn Mạnh Sâm',
            'email'=>'admin@gmail.com',
            'phone_number'=>'0123456789',
            'password'=>Hash::make('123456'),
        ]);

    
        $user = User::create([
            'name'=>'Nguyễn Mạnh Sâm',
            'email'=>'user@gmail.com',
            'phone_number'=>'0123456789',
            'password'=>Hash::make('123456'),
        ]);

        $admin->roles()->attach([$adminRole->id,$userRole->id]);
        $user->roles()->attach($userRole->id);
    }
}
