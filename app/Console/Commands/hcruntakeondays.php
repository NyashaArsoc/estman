<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class hcruntakeondays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hcruntakeondays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run take days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Execute the stored procedure
        DB::select('EXEC spPostHCmoveTakeonDays');
    }
}
