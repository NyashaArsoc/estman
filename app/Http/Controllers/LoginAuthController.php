<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginAuthController extends Controller
{
     public function __construct(){
        $this->middleware(['alreadyloggedin']);
    }
    public function signin(){
        return view('auth/login');
    }
public function userlogin(Request $request){
        try {
          // get the login validation
        $login = collect(DB::select('EXEC  spPostUserLogin ?',
        [$request->username]))->first();
        if($login->username == 'blocked'){
            return  redirect()->route('login.signin') 
                ->with('error', 'user blocked');
        }else if($login->username == 'notactive'){
            return  redirect()->route('login.signin') 
                ->with('error', 'user not active');
        }else if($login->username == 'notavailable'){
            return  redirect()->route('login.signin') 
                ->with('error', 'user disabled');
        }else if($login->username == 'incorrect'){
            return  redirect()->route('login.signin') 
                ->with('error', 'incorrect username/password');
        }else if($login->username == 'norole'){
            return  redirect()->route('login.signin') 
                ->with('error', 'no role assigned');
        }else{ //when all credentials are correct
            if(Hash::check($request->password,$login->password)){
                DB::table('systlogins')->insert(['username'=>$request->username,
                'attempts'=>0,'isvalid'=>'Y']); 
                //put session on
                $request->session()->put('alluser',$login->username);
                //check if system date is set
                $systemdate             =       $this->systemdate();
                if($systemdate == 'failed'){
                    $error = 'no system date set';
                   return $this->userforcelogout($error);
                }else{ 
                    // check if base currency is set
                    $basecurrency           =       $this->getbasecurrency();
                    if($basecurrency =='failed'){
                        $error = 'no base currency set';
                       return $this->userforcelogout($error);
                    }else{ 
                        //check license
                        $license    =   $this->getlicensecheck();
                        switch ($license){
                            case 'failed':
                                $error = 'invalid license key';
                                return $this->userforcelogout($error);
                            case 'notvalid':
                                $error = 'license expired';
                                return $this->userforcelogout($error);
                            case 'valid':
                                return  redirect()->route('dash.val');
                            default:
                            $error = 'invalid login';
                            return $this->userforcelogout($error);
                        }
                    }
                }   
            }else{//wrong pin
                $attempts = DB::table('systlogins')->select('attempts')
                ->where('username',$request->username)->latest('id')->first();
                DB::table('systlogins')->insert(['username'=>$request->username,
                    'logoutdate'=>now(),'attempts'=>$attempts->attempts +=1,'isvalid'=>'N']);          
                return  redirect()->route('login.signin') 
                ->with('error', 'incorrect username/password');
            }
        }
        } catch (\Throwable $th) {
            return  redirect()->route('login.signin') 
                ->with('error', 'failed to load ');
        }
        
}   

public function userlogout(){
    if(session()->has('alluser')){
        try {
            $logouttime = date("Y-m-d H:i:s", strtotime('+2 hours', strtotime(now())));
           $lastlogin = DB::table('systlogins')->where('username',session('alluser'))
            ->orderBy('id','desc')->first();
            DB::table('systlogins')->where('id',$lastlogin->id)
           ->update(['logoutdate' => $logouttime]);
            session()->pull('alluser');
            return  redirect()->route('login.signin');
        } catch (\Throwable $th) {
            session()->pull('alluser');
            return redirect()->route('login.signin')
            ->with('success', 'signout');
        }
    }
    session()->pull('alluser');
    return  redirect()->route('login.signin');
}
public function profileview(){
    try {
        $user = $this->userdetail();
        $arr['user'] = DB::table('systusers')->select('*')->where('username',session('alluser'))
        ->first();
        $arr['role'] = DB::table('systroles')->select('*')->where('id',$user->roleid)
        ->first();
        return view('auth/user-profile')
        ->with($arr);
    } catch (\Throwable $th) {
        session()->pull('alluser');
    return  redirect()->route('login.signin');
    }
}
public function profilepassword(Request $request){
    try {
         $user = $this->userdetail();
        DB::table('systauth')->insert([
            'userid' => $user->id,
            'password' => Hash::make($request->Password),
            'validto' => $this->passwordvalidto()
        ]);
        return  redirect()->route('login.profile') 
            ->with('success', 'password changed');  
    } catch (\Throwable $th) {
        return  redirect()->route('login.profile') 
        ->with('error', 'failed to load');
    }
    
}
public function defaultport(){
    return view('auth/login');
}
}
