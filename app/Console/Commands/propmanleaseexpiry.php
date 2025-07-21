<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class propmanleaseexpiry extends Command
{
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'app:propmanleaseexpiry';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Terminate lease expired';

        /**
         * Execute the console command.
         */
        public function handle()
        {
                DB::table('propmanlease')->where('available', '=', 'Y')->where('validto', '<', now())
                        ->update(['expiry' => 'Y', 'available' => 'N']);
                $propertyids = DB::table('propmanlease')->where('expiry', 'Y')->pluck('propertyid');
                DB::table('propmanproperty')->whereIn('id', $propertyids)->update(['occupation' => 'P']);
                //add days to owing balances
                DB::table('propmanleasearrearsdetails')->update(['baldays' => DB::raw('baldays + 1')]);
        }
}
