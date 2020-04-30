<?php

use Illuminate\Database\Seeder;
use App\Program;

class ProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = [
            'Meeting',
            'Workshop',
            'Training',
            'Talkshow'
        ];

        foreach($programs as $program){
            Program::create(['text' => $program, 'value' => $program]);
        }
    }
}
