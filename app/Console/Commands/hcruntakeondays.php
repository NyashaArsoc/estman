<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        try {
            DB::select('EXEC spPostHCmoveTakeonDays');
            $this->info('Stored procedure executed successfully.');
            Log::info('spPostHCmoveTakeonDays ran successfully.');
        } catch (\Exception $e) {
            $this->error('Stored procedure failed: ' . $e->getMessage());
            Log::error('spPostHCmoveTakeonDays failed: ' . $e->getMessage());
        }
    }
}
