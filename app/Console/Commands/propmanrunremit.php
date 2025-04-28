<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class propmanrunremit extends Command
{
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
        $period = DB::table('setupperiodrun')->where('isinvoicerun','=',1)
                ->where('isremitlistrun','=',0)->select('*')->latest('id')->first();
        if ($period) {
         // Execute the stored procedure
         $result = DB::select('EXEC spPostPropManPreRemit?',[$period->period]);
         $status = $result[0]->ReturnValue;
        }else{ $status = 1;}
         // Prepare email data
         $toemail = 'kudzchitz@gmail.com';
         $subject = $status == 0 ? 'Success: Pre Remittance Processed' : 'Failure: Pre Remittance Processing Failed';
         $message = $status == 0 ? 'The pre-remittance process completed successfully.' : 'The pre-remittance process cannot run twice in the same period';
         // Send the email
         Mail::raw($message, function($message) use ($toemail, $subject) {
             $message->to($toemail)
                     ->subject($subject);
         });
         $this->info('email sent.');
    }
}
