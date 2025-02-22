<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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
            $valid = $this->passwordexpirecheck($request->username);
            $license    =   $this->getlicensecheck();
            // get the login validation
   $login = collect(DB::select('EXEC  spPostUserLogin ?', [$request->username]))->first();
            /*---------check login details----------------- */
   switch (trim($login->username)){
    case 'blocked':
        return  redirect()->route('login.signin') 
       ->with('error', 'user blocked');
    case 'notactive':
        return  redirect()->route('login.signin') 
       ->with('error', 'user not active');
    case 'notavailable':
        return  redirect()->route('login.signin') 
       ->with('error', 'user disabled');
    case 'incorrect':
        return  redirect()->route('login.signin') 
       ->with('error', 'incorrect username/password');
    case 'norole': 
        return  redirect()->route('login.signin') 
       ->with('error', 'no role assigned');
    default : 
    if(Hash::check($request->password,$login->password)){
        /* ------------check password valid period -----------*/
        switch ($valid){
            case 'ok':
            DB::table('systlogins')->insert(['username'=>$request->username,
            'attempts'=>0,'isvalid'=>'Y']); 
            $request->session()->put('alluser',$login->username);
            /* ------------check license -----------*/
            switch ($license){
                case 'failed':
                    $error = 'invalid license key';
                    return $this->userforcelogout($error);
                case 'notvalid':
                    $error = 'license expired';
                    return $this->userforcelogout($error);
                case 'valid':
                        return  redirect()->route('dash.main');
            }
            /*--------end license check ------ */
            case 'expired':
                $username = Crypt::encrypt($request->username);
                return  redirect()->route('login.expire',$username);
            default :
                 $error = 'invalid login';
                return $this->userforcelogout($error);
        }
        /* ------------end check password valid period -----------*/
    }else{ //wrong password
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
public function passwordexpired($id){
    try {
        $username = Crypt::decrypt($id);
        try {
        $arr['username'] = $id;
       return view('auth.password-expired')->with($arr);
    } catch (\Throwable $th) {
          $error = 'password expired invalid';
         return $this->userforcelogout($error);
    }
} catch (DecryptException $th) {
    return  redirect()->route('login.signin')
    ->with('error', 'failed to load');
}
}
public function changepasswordexpired($id,Request $request){
    try {
        $username = Crypt::decrypt($id);
           try {
            $user = DB::table('systusers')->select('*')->where('username',
         $username)->orderBy('id', 'desc')->first();
            $passwordexist = $this->oldpasswordcheck($request->password,$username);
            $license    =   $this->getlicensecheck();
            $login = collect(DB::select('EXEC  spPostUserLogin ?',
            [$username]))->first();
            //if the password match the last password then change 
            if(Hash::check($request->oldpassword,$login->password)){
                switch (trim($passwordexist)){
                    case 'ok':
                        //password don't exist
                        DB::table('systauth')->insert([
                             'userid' => $user->id,
                         'password' => Hash::make($request->password)
                         ]);
                         DB::table('systlogins')->insert(['username'=>$request->username,
                            'attempts'=>0,'isvalid'=>'Y']); 
                         $request->session()->put('alluser',$username);
                        /* ------------check license -----------*/
                            switch ($license){
                                case 'failed':
                                    $error = 'invalid license key';
                                    return $this->userforcelogout($error);
                                case 'notvalid':
                                    $error = 'license expired';
                                    return $this->userforcelogout($error);
                                case 'valid':
                                        return  redirect()->route('dash.main');
                            }
                            /*--------end license check ------ */
                    default:
                        //password exist
                    return  redirect()->route('login.expire',$id)
                        ->with('error', 'password exists');
                }
            }else{ // wrong current password will block account
                $attempts = DB::table('systlogins')->select('attempts')
                ->where('username',$username)->latest('id')->first();
                DB::table('systlogins')->insert(['username'=>$username,
                    'logoutdate'=>now(),'attempts'=>$attempts->attempts +=1,'isvalid'=>'N']);          
                return  redirect()->route('login.expire',$id) 
                ->with('error', 'incorrect password');
            }
    } catch (\Throwable $th) {
        return  redirect()->route('login.expire',$id)
        ->with('error', 'failed to load');
    } 
} catch (DecryptException $th) {
    return  redirect()->route('login.signin')
    ->with('error', 'failed to load');
}
}
}
