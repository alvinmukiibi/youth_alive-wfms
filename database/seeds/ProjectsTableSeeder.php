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
            'MSaS-EDC',
            'ISAWTEM-Misean Cara',
            'SHARE-Uganda Cares',
            'YETA',
            'RHITES-EC',
            'SRHR-U',
            'EAYIP',
        ];
        $descs = [
            'Measuring Skill at Scale- Work Readiness Assessment',
            'Integrating Sexual And Reproductive Health and Work Force Development for Teenage Mothers',
            'Scaling up HIV/AIDS Responses in Hard to reach Areas of Northern Uganda',
            'Youth Empowerment Through Agriculture',
            'Regional Health Integration To Enhance Service in East Central Uganda',
            'Sexual and Reproductive Health and Rights Umbrella Program',
            'East African Youth Inclusion Program',
        ];

        for($i = 0; $i < count($names); $i++){
            Project::create(['name' => $names[$i], 'description' => $descs[$i]]);
        }
    }
}
