<?php

namespace App\Console\Commands;

use App\Jobs\UsersCountJob;
use Illuminate\Console\Command;

class CalcUsersCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc-users-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        UsersCountJob::dispatch();
    }
}
