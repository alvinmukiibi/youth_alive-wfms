<?php

use App\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Better Outcomes',
            'YETA',
            'RHITES-EC',
            'RHISP',
            'MC',
            'EAYIP',
        ];

        foreach($names as $name){
            Project::create(['name' => $name]);
        }
    }
}
