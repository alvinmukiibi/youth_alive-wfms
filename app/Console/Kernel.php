<?php

namespace App\Console;
use App\User;
use App\Leave;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->everyMinute();
        $schedule->call(function(){
            User::find(1)->update(['activity_status' => false]);
            // Leave::all()->each(function($leave){
            //     if(date('d-M-Y', strtotime($leave->from)) == date('d-M-Y')){
            //         $update = [
            //             'availability_status' => false,
            //             'activity_status' => false,
            //         ];
            //         $leave->user()->update($update);
            //     }
            // });
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
