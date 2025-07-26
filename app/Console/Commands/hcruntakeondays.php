<?php

namespace App\Console\Commands;

use Carbon\Carbon;
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
            $today = Carbon::today()->toDateString();

            //take on days 
            DB::statement('EXEC spPostHCmoveTakeonDays');
            $this->info('Stored procedure executed successfully.');
            Log::info('spPostHCmoveTakeonDays ran successfully.');
            //activate and deactivate staff
            $startday = DB::table('hcleaveapplication')->where('status', 'A')->whereDate('datefrom', '<=', $today)
                ->whereDate('dateto', '>=', $today)->pluck('staffid')->map(function ($id) {
                    return trim($id);
                });
            $endday = DB::table('hcleaveapplication')->whereDate('datefrom', $today)->pluck('staffid');
            if ($startday->isNotEmpty()) {
                $arr =    DB::table('systusers')->whereIn('id', $startday)->update(['isavailable' => 'N']);
                $this->info('Staff deactivated successfully.');
                Log::info('Staff deactivated successfully for today.' . $arr . ' for ' . $startday->implode(', '));
            }
            if ($endday->isNotEmpty()) {
                DB::table('systusers')->whereIn('id', $endday)->update(['isavailable' => 'Y']);
                $this->info('Staff activated successfully.');
                Log::info('Staff activated successfully for today.');
            }
        } catch (\Exception $e) {
            $this->error('Stored procedure failed: ' . $e->getMessage());
            Log::error('spPostHCmoveTakeonDays failed: ' . $e->getMessage());
        }
    }
}
