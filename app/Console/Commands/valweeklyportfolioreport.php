<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class valweeklyportfolioreport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:valweeklyportfolioreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Valuations Weekly Portfolio Instructions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = DB::select("SELECT DATEADD(WEEK, DATEDIFF(WEEK, 0, GETDATE()) -1, 0) AS StartOfWeek");
        $arr['mondayfirstday']  = $start[0]->StartOfWeek;
        $end = DB::select("SELECT DATEADD(DAY, 6, ?) AS EndOfWeek", [$arr['mondayfirstday']]);
        $arr['sundaylastday']  = $end[0]->EndOfWeek;
        $arr['portfolioids']   = DB::table('valinstructions')->where('isportfolio', '=', 'Y')
            ->pluck('id')->toArray();
        $arr['normalindividual'] = DB::select('EXEC spGetValWeekPortfolioReportIndividual');
        //portfolio pending 
        $arr['portfoliocompilation'] = DB::select('EXEC spGetValPortfolioCompilation');
        //portfolio pending  review
        $arr['portfolioreview'] = DB::select('EXEC spGetValPortfolioCompilation');
        try {
            // Send email
            Mail::send('tomail.val-weekly-portfolio-report', $arr, function ($message) {
                $message->to('valuations@intpro.co.zw') // Replace with the recipient's email
                    ->subject('Weekly Status Report (Portfolios)');
            });

            $this->info('Weekly report email sent successfully!');
        } catch (\Exception $e) {
            $errormessage = 'Error: ' . $e->getMessage();
            Mail::send([], [], function ($message) use ($errormessage) {
                $message->to('systemreports@arsoc.co.zw')
                    ->subject('Weekly Status Report (Normal)')
                    ->setBody($errormessage, 'text/plain');
            });
        }
    }
}
