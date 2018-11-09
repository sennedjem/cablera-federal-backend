<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        //
        User::Create(['name'=> "admin", 'email' => "cablerafederal@gmail.com", 'password' => 'admin123', 'id' => '1']);
    }
}
