<?php

namespace app\Http\View\Composer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MenuComposer extends Controller{
public function compose(View $view){
    try {
        $user = $this->userdetail();
        $valintake      =   'valintake';
        $valapprove     =   'valapprove';
        $valdecline     =   'valdecline';
        $valmanage      =   'valmanage';
         /*------------------------valuation menu--------------------------- */
        
        $arr['valintake']= DB::select ('EXEC spGetMenuList ?,?',[$user->roleid,$valintake]);
        $arr['valapprove']= DB::select ('EXEC spGetMenuList ?,?',[$user->roleid,$valapprove]);
        $arr['valdecline']= DB::select ('EXEC spGetMenuList ?,?',[$user->roleid,$valdecline]);
        $arr['valmanage']= DB::select ('EXEC spGetMenuList ?,?',[$user->roleid,$valmanage]);
       
        $view->with($arr);
    } catch (\Throwable $th) {
        $error = 'fail to load menu';
        return $this->userforcelogout($error);
    }
}
}