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
        // get the base currency 
        $basecurrency           =       $this->getbasecurrency();
        $license                =       $this->getlicensecheck();
        $attempts               =       DB::table('systlogins')->select('attempts')
                ->where('username',$request->username)->latest('id')->first();
        return match (true) {
            $login->username == 'blocked' => redirect()->route('login.signin')
                ->with('error', 'user blocked'),
            $login->username == 'notactive' => redirect()->route('login.signin')
                ->with('error', 'user not active'),
            $login->username == 'notavailable' => redirect()->route('login.signin')
                ->with('error', 'user disabled'),
            $login->username == 'incorrect' => redirect()->route('login.signin')
                ->with('error', 'incorrect username/password'),
            $login->username == 'norole' => redirect()->route('login.signin')
                ->with('error', 'no role assigned'),
                // default when username is correct and all details are active
            default => (function () use($login,$request,$basecurrency,$license,$attempts){
                /*------------when username and password are correct------------------- */
                if(Hash::check($request->password,$login->password)){
                    //insert a successful login 
                    DB::table('systlogins')->insert(['username'=>$request->username,
                    'attempts'=>0,'isvalid'=>'Y']);
                    //place a session
                    $request->session()->put('alluser',$login->username);
                    // check if basecurrency is set
                    switch(true){
                        case($basecurrency == 'failed'):
                            $error = 'no base currency set';
                            return $this->userforcelogout($error);
                        default:
                        /*------------check licence validity----------------------- */
                        switch ($license){
                            case 'failed':
                                $error = 'invalid license key';
                                return $this->userforcelogout($error);
                            case 'notvalid':
                                $error = 'license expired';
                                return $this->userforcelogout($error);
                            case 'valid':
                                return  redirect()->route('dash.main');
                            default:
                                $error = 'invalid login';
                                return $this->userforcelogout($error);
                        }
                    }
                }else{/* passwords mismatch */
                    DB::table('systlogins')->insert(['username'=>$request->username,
                    'logoutdate'=>now(),'attempts'=>$attempts->attempts +=1,'isvalid'=>'N']); 
                    return  redirect()->route('login.signin') 
                    ->with('error', 'incorrect username/password');
                }
            })()
            };
        } catch (\Throwable $th) {
            return  redirect()->route('login.signin') 
                ->with('error', 'failed to load ');
        }
}   

public function userlogout(){
    if(session()->has('alluser')){
        try {
            $logouttime = date("Y-m-d H:i:s", strtotime('+2 hours',
             strtotime(now())));
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
