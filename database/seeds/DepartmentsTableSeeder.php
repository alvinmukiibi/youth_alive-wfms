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
            'Project Management',
            'Business Development',
            'Training and Development',
            'Human Resource',
            'Finance and Operations',
            'Monitoring, Evaluation, Research and Learning',
            'Communications',
        ];
        $departments_acronyms = [
            'PM',
            'BD',
            'T & D',
            'HR',
            'FIN',
            'MLE',
            'COMM',
        ];

        for($i = 0; $i < count($department_names); $i++){
            Department::create(['name' => $department_names[$i], 'acronym' => $departments_acronyms[$i]]);
        }
    }
}
