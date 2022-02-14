<?php

namespace Tests\Feature\Console\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Artisan;
use App\Console\Kernel;

class CommandTest extends TestCase
{
    public function test_firstcommand()
    {
        $expected = '~This is my first command run successfully~';
        $this->expectOutputRegex($expected);
        Artisan::call('first:command'); // This is equals to -- php artisan first:command
    }

    public function test_schedule_firstcommand()
    {
        //Artisan::call('schedule:list');
        //Artisan::call('schedule:work');
        
        Artisan::shouldReceive('call')
        ->once()
        ->with('schedule:run');

        $this->get('/scheduler')->assertStatus(200); 
    }

    public function test_schedule_firstcommand_success()
    {
        // https://stackoverflow.com/questions/40161679/configure-and-test-laravel-task-scheduling
        /** @var \Illuminate\Console\Scheduling\Schedule $schedule */
        $schedule = app()->make(\Illuminate\Console\Scheduling\Schedule::class);

        $events = collect($schedule->events())->filter(function (\Illuminate\Console\Scheduling\Event $event) {
            return stripos($event->command, 'first:command');
        });

        if ($events->count() == 0) {
            $this->fail('No events found');
        }

        $events->each(function (\Illuminate\Console\Scheduling\Event $event) {
            // This example is for every minute commands.
            $this->assertEquals('* * * * *', $event->expression);
        });
    }
}
