<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    //current system date
    public function systemdate()
    {
        return date_format(now(), "Y-m-d");
    }
    public function userdetail()
    {
        if (session()->has('alluser')) {
            try {
                $user = DB::table('systusers')->select('*')
                    ->where('username', session('alluser'))
                    ->orderBy('id', 'desc')->first();
                return $user;
            } catch (\Throwable $th) {
                return 'failed';
            }
        }
    }
    public function getlicensecheck()
    {
        try {
            $licensecheck = DB::table('systmetacheck')
                ->select('*')->latest('id')->first();
            if (is_null($licensecheck)) {
                return 'failed';
            } else {
                try {
                    $license = Crypt::decrypt($licensecheck->checktil);
                    $systemdate = $this->systemdate();
                    $firstcheck = \Carbon\Carbon::parse($systemdate);
                    $secondcheck = \Carbon\Carbon::parse($license);
                    if ($secondcheck > $firstcheck) {
                        return 'valid';
                    } else {
                        return 'notvalid';
                    }
                } catch (DecryptException $th) {
                    return 'failed';
                }
            }
        } catch (\Throwable $th) {
            return 'failed';
        }
    }
    public function userforcelogout($error)
    {
        if (session()->has('alluser')) {
            try {
                $logouttime = date("Y-m-d H:i:s", strtotime('+2 hours', strtotime(now())));
                $lastlogin = DB::table('systlogins')->where('username', session('alluser'))
                    ->orderBy('id', 'desc')->first();
                DB::table('systlogins')->where('id', $lastlogin->id)
                    ->update(['logoutdate' => $logouttime]);
                session()->pull('alluser');
                return  redirect()->route('login.signin')
                    ->with('error', $error);
            } catch (\Throwable $th) {
                session()->pull('alluser');
                return  redirect()->route('login.signin')
                    ->with('error', $error);
            }
        }
    }
    public function passwordexpirecheck($username)
    {
        try {
            $today = now();
            $user = DB::table('systusers')->select('*')->where(
                'username',
                $username
            )->orderBy('id', 'desc')->first();
            $validto = DB::table('systauth')
                ->where('userid', $user->id)->orderBy('id', 'desc')->first();
            if ($validto->validto < $today) {
                return 'expired';
            } else {
                return 'ok';
            }
        } catch (\Throwable $th) {
            return 'error';
        }
    }
    public function oldpasswordcheck($oldpassword, $username)
    {
        $user = DB::table('systusers')->select('*')->where(
            'username',
            $username
        )->orderBy('id', 'desc')->first();
        $passwords = DB::table('systauth')
            ->where('userid', $user->id)->pluck('password');
        foreach ($passwords as $abc) {
            if (Hash::check($oldpassword, $abc)) {
                return 'exist';
            }
        }
        return 'ok';
    }
    //find active base currency
    public function getbasecurrency()
    {
        try {
            return DB::table('setupcurrencybase')->where('active', 'Y')
                ->orderByDesc('id')->value('code') ?? 'failed';
        } catch (QueryException $th) {
            return 'failed';
        }
    }
    public function getcurrencycode()
    {
        try {
            $currency   = DB::table('setupcurrency')->select('id', 'code')->get();
            if (is_null($currency)) {
                return  redirect()->route('dash.main')->with('error', 'no currency set');
            }
            return $currency;
        } catch (\Throwable $th) {
            return  redirect()->route('dash.main')->with('error', 'no currency set');
        }
    }
    public function getclienttype()
    {
        try {
            $description   = DB::table('setupclienttype')->select('id', 'description')->get();
            if (is_null($description)) {
                return  redirect()->route('dash.main')->with('error', 'no client type');
            }
            return $description;
        } catch (\Throwable $th) {
            return  redirect()->route('dash.main')->with('error', 'no client type');
        }
    }
    /*--------get the last transaction id */
    public function gettransationid()
    {
        try {
            $trxid = collect(DB::select('EXEC spGETSetupTriggerTrxID'))->first();
            $trxid = ($trxid !== null) ? $trxid->trxid : 'failed';
            return $trxid;
        } catch (\Throwable $th) {
            return 'failed' . $th;
        }
    }
    /*--------get valuations client detail by instruction-----------*/
    function getvaluationclient($isportfolio, $contactid, $instructionid, $portid)
    {
        try {
            $purpose = match (trim($isportfolio)) {
                'N' => DB::table('valinstructions')->where('id', $instructionid)
                    ->select('*')->first(),
                default => DB::table('valinstrportfolio')
                    ->where('id', $portid)
                    ->select('*')->first(),
            };
            $client = match (trim($isportfolio)) {
                'N' => DB::table('valclientcontactperson')->join(
                    'valclientdetail',
                    'valclientcontactperson.clientid',
                    '=',
                    'valclientdetail.id'
                )
                    ->where('valclientcontactperson.id', $contactid)
                    ->select(
                        'valclientdetail.companyname',
                        'valclientdetail.lastname',
                        'valclientdetail.firstname',
                        'valclientcontactperson.firstname As contactfirstname',
                        'valclientcontactperson.lastname As contactlastname',
                        'valclientcontactperson.cell',
                        'valclientcontactperson.email',
                        'valclientdetail.contactaddress'
                    )->first(),
                default => DB::table('valclientcontactperson')->join(
                    'valclientdetail',
                    'valclientcontactperson.clientid',
                    '=',
                    'valclientdetail.id'
                )
                    ->where('valclientcontactperson.id', $purpose->clientcontactid)
                    ->select(
                        'valclientdetail.companyname',
                        'valclientdetail.lastname',
                        'valclientdetail.firstname',
                        'valclientcontactperson.firstname As contactfirstname',
                        'valclientcontactperson.lastname As contactlastname',
                        'valclientcontactperson.cell',
                        'valclientcontactperson.email',
                        'valclientdetail.contactaddress'
                    )->first(),
            };
            return $client;
        } catch (\Throwable $th) {
            return 'failed' . $th;
        }
    }
}
