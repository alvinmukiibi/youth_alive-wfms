<?php

use Illuminate\Database\Seeder;
use App\Designation;

class DesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = [
            'Executive Director',
            'Director Strategic information',
            'Finance Manager',
            'Monitoring Evaluation & Learning Manager',
            'Project Accountant',
            'Project Manager',
            'Human Resource Manager',
            'Assistant',
            'Technical Field Officer',
            'Project Officer ',
            'Driver',
            'District Field Officer ',
            'Youth Specialist',
            'Youth and Gender Advisor',
            'Communications Officer',
            'Procurement Officer'
        ];

        foreach($designations as $des){
            Designation::create(['name' => $des]);
        }
    }
}
