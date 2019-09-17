<?php

use App\Directorate;
use Illuminate\Database\Seeder;

class DirectorateTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $directorates = [
            'Strategic Information',
            'Finance & Operations',
            'Programs & Business Development',
        ];
        foreach($directorates as $dir){
            Directorate::create(['name' => $dir]);
        }

    }
}
