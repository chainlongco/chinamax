<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FirstCommand extends Command
{
    /* Schedule a command:
        1. Create a command: php artisan make:command FirstCommand
        2. Register in Kernel: 
            add this link into Kernel.php under $commands: Commands\FirstCommand::class,
        3. Add schedule under schedule function: $schedule->command('first:command')->everyMinute();
        4. We can schedule this work in commandline: php artisan schedule:work
        5. Or direct run it in commandline: php  artisan first:command
        6. In Test, we can call this command using this line: Artisan::call('first:command');
    */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'first:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //return 0;
        // $this->info('This is my first command run successfully');
        echo 'This is my first command run successfully';
    }
}
