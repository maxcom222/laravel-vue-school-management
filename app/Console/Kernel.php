<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Memcached;
use DB;
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
        //          ->hourly();
		
		/*$schedule->call(function () 
		{
			   DB::table('teest') -> where('id', 2) -> delete();
		})->everyMinute();
		*/
		
		//message: "SQLSTATE[42S22]: Column not found: 1054 Unknown column 'verify_link' in 'field list' (SQL: insert into `user` (`email`, `password`, `type`, `verify_code_school`, `verify_code`, `profile_photo`, `verify_link`, `profile_photo_custom`, `city`, `country`) values (grahamhdavies@gmail.com, working, teacher, 94285, 27418, , 605f3f62b1e0fb3c6f6a2c9936c56a728ff02b8d, 0, , ))"


//ReferenceError: image is not defined


		  $schedule->call(function () 
		  {
           
		    $memcache = new memcached;
			$memcache	->	addServer('localhost', 11211);
			
			
			$job_titles 	=  DB::table('job_titles') -> select('id','title')-> get() ;
			$school_profile =  DB::table('school_profile') -> select('id','name')-> get() ;
			$domain_email =  DB::table('school_profile') -> where ('domain_email', '!=', 'NULL' ) -> groupBy('domain_email') -> where ('domain_email', '!=', '' )  -> select( 'domain_email' ) -> orderBy('name', 'asc') -> get() ;
	
			
			$memcache->set('job_titles', $job_titles  );
			$memcache->set('schools', $school_profile  );
			$memcache->set('domain_email', $domain_email  );
			
			
          })->everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
