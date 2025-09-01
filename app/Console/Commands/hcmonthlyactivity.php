<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class hcmonthlyactivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hcmonthlyactivity';

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
        try {
            //accumulate days
            DB::statement('EXEC spPostHCAccumulateLeaveDays');
            $this->info('Stored procedure executed successfully.');
            Log::info('spPostHCAccumulateLeaveDays ran successfully.');
        } catch (\Exception $e) {
            $this->error('Stored procedure failed: ' . $e->getMessage());
            Log::error('spPostHCAccumulateLeaveDays failed: ' . $e->getMessage());
        }
    }
}
