<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class propmanruninvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:propmanruninvoice';

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
        // Execute the stored procedure
        $result = DB::select('EXEC spPostPropManPreInvoice');
        $status = $result[0]->ReturnValue;
        // Prepare email data
        $toemail = 'systemreports@arsoc.co.zw';
        $subject = $status == 0 ? 'Success: Pre Invoice Processed' : 'Failure: Pre Invoice Processing Failed';
        $message = $status == 0 ? 'The pre-invoice process completed successfully.' : 'The pre-invoice process encountered a failure.';
        // Send the email
        Mail::raw($message, function ($message) use ($toemail, $subject) {
            $message->to($toemail)
                ->subject($subject);
        });
        $this->info('email sent.');
    }
}
