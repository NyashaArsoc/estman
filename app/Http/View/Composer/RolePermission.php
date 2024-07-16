<?php

namespace app\Http\View\Composer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RolePermission extends Controller{
    public function compose(View $view){
        try {
            $user = $this->userdetail();
            $arr = DB::table('systeventcontrolpermission')
            ->where('roleid', $user->roleid)
            ->select('eventcontrolid')->get();
            $joinedcontrolsis   = $arr->implode('eventcontrolid', ',');
            $arraycontrolids  =   explode(',',$joinedcontrolsis);
            $view->with('arraycontrolids',$arraycontrolids);
            $view->with('user',$user);
        } catch (\Throwable $th) {
            $error = 'fail to load menu';
        return $this->userforcelogout($error);
        }
    }
}