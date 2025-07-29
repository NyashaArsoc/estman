<?php

namespace App\Console\Commands;

use App\Traits\HandlingMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class hcmonthlyleavereport extends Command
{
    use HandlingMail;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hcmonthlyleavereport';

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
            $arr['dateat'] = Carbon::now()->format('F j, Y');
            $datefrom = Carbon::today()->subDays(35)->toDateString();

            $applications   = DB::table('hcleaveapplication as a')->join('hcleavetype as t', 'a.typeid', '=', 't.id')
                ->leftJoin('systusers as u', 'a.staffid', '=', 'u.id')->where('a.status', '=', 'A')
                ->where('a.datefrom', '>=', $datefrom)->select(
                    'a.*',
                    't.description as leavetype',
                    'u.firstname',
                    'u.lastname'
                )->get();
            $arr['leavetype'] = $applications->groupBy('leavetype');
            $arr['applications'] = $applications;
            $systmail = $this->getmails('hc', 'to');
            $systmailcc = $this->getmails('hc', 'cc');
            if ($systmail == 'failed' || $systmailcc == 'failed') {
                $systmail = 'systemreports@arsoc.co.zw';
                $systmailcc = 'systemreports@arsoc.co.zw';
            }
            // Send email
            Mail::send('tomail.hc-leave-application-report', $arr, function ($message) use ($systmailcc, $systmail) {
                $message->to($systmail)->cc($systmailcc)
                    ->subject('Monthly Leave Report');
            });

            $this->info('Weekly report email sent successfully!');
            Log::info('send.' . $systmail . ' and cc: ' . $systmailcc);
        } catch (\Exception $e) {
            $mymessage = 'Error: ' . $e->getMessage();
            $mymailto = 'systemreports@arsoc.co.zw';
            Mail::html("<p>$mymessage</p>", function ($message) use ($mymailto) {
                $message->to($mymailto)
                    ->subject('Leave Report Error');
            });
            Log::error('mail failed: ' . $e->getMessage());
        }
    }
}
