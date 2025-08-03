<?php

namespace App\Console\Commands;

use App\Traits\HandlingMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class propmanrunremit extends Command
{
    use HandlingMail;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:propmanrunremit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run rent roll';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $period = DB::table('setupperiodrun')->where('isinvoicerun', '=', 1)
                ->where('isremitlistrun', '=', 0)->select('*')->latest('id')->first();
            if ($period) {
                // Execute the stored procedure
                $periodValue = $period->period; // e.g. '2025-07-31'
                $sql = "EXEC spPostPropManPreRemit @myPeriod = ?";
                $result = DB::select($sql, [$periodValue]);

                //$result = DB::select('EXEC spPostPropManPreRemit?', [$period->period]);
                $status = $result[0]->ReturnValue;
            } else {
                $status = 1;
            }
            // Prepare email data

            $systmail = $this->getmails('prop', 'to');
            if ($systmail == 'failed') {
                $systmail = "systemreports@arsoc.co.zw";
            }
            $subject = $status == 0 ? 'Success: Pre Remittance Processed' : 'Failure: Pre Remittance Processing Failed';
            $message = $status == 0 ? 'The pre-remittance process completed successfully.' : 'The pre-remittance process cannot run twice in the same period';
            // Send the email
            Mail::raw($message, function ($message) use ($subject, $systmail) {
                $message->to($systmail)
                    ->subject($subject);
            });
            $this->info('email sent.');
            Log::info('success.');
        } catch (\Exception $e) {
            $mymessage = 'Error: ' . $e->getMessage();
            $mymailto = 'systemreports@arsoc.co.zw';
            Mail::html("<p>$mymessage</p>", function ($message) use ($mymailto) {
                $message->to($mymailto)
                    ->subject('Remmit Run Error');
            });
            Log::error('mail failed: ' . $e->getMessage());
        }
    }
}
