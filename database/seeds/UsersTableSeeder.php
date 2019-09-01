<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'fname' => 'Vin',
            'lname' => 'Mukiibi',
            'email' => 'admin@youthalive.com',
            'password' => '$2y$10$nJbQ4tGJ8/JOzzHbz4aaJe9VSZwYVUcfVcpNS/hxYxc1k45/Rgu.S',
            'mobile_contact' => '0753847633',
            'department_id' => '4',
            'profile_picture' => 'user.jpg',
            'activity_status' => 1,
            'email_verified_status' => 1,
        ];

        $user = User::create($user);

        $user->roles()->attach(2);
        $user->roles()->attach(4);

    }
}
