<?php

use App\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department_names = [
            'Youth and Gender',
            'Human Resources',
            'Strategic Information',
            'Information and Communications Technology',
            'Monitoring, Learning and Evaluation',
            'Communications'
        ];
        $departments_acronyms = [
            'Y & G',
            'HR',
            'SI',
            'ICT',
            'MLE',
            'Comm',
        ];

        for($i = 0; $i < count($department_names); $i++){
            Department::create(['name' => $department_names[$i], 'acronym' => $departments_acronyms[$i]]);
        }
    }
}
