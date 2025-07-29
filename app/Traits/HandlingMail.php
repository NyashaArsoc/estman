<?php



namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait HandlingMail
{
    function getmails($module, $action)
    {
        try {
            $mails = DB::table('systmails')->where('module', $module)->where('action', $action)->select('mailing')->latest('id')->first();
            if ($mails) {
                return $mails->mailing;
            }
            return 'failed';
        } catch (\Throwable $th) {
            return 'failed';
        }
    }
}
