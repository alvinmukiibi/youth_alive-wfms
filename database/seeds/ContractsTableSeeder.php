<?php

use App\Contract;
use Illuminate\Database\Seeder;

class ContractsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Permanent',
            'Contract',
            'Internship',
            'Volunteer',
            'Other',
        ];

        foreach($names as $name){
            Contract::create(['name' => $name]);
        }
    }
}
