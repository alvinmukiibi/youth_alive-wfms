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
            'email' => 'admin@youthaliveuganda.org',
            'password' => '$2y$10$epk.1TdSHELenZ8lQNMtRucGxafU5gBkCqfWKuE5/TZ3dVV1SZ9pu',
            'mobile_contact' => '0753847633',
            'department_id' => '4',
            'profile_picture' => null,
            'activity_status' => 1,
            'availability_status' => 1,
            'email_verified_status' => 1,
        ];

        $user = User::create($user);

        $user->roles()->attach(2);
        $user->roles()->attach(4);

    }
}
