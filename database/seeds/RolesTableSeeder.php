<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'officer',
            'manager',
            'director',
            'board_chairman',
            'administrator',
        ];

        foreach($roles as $role){
            Role::create(['name' => $role]);
        }
    }
}
