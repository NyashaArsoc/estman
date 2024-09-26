<?php

namespace app\Http\View\Composer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MenuComposer extends Controller{
public function compose(View $view){
    try {
        $user = $this->userdetail();
         /*------------------------valuation menu--------------------------- */
        $valintake          =   'valintake';
        $valapprove         =   'valapprove';
        $valdecline         =   'valdecline';
        $valmanage          =   'valmanage';
        //property management
        $propmanintake      =   'propmanintake';
        $propmanapprove      =   'propmanapprove';
        $propmandecline      =   'propmandecline';
         /*------------------------set up menu--------------------------- */
         $setupintake      =   'setupintake';
        
        $arr['valintake']= DB::select ('EXEC spGetMenuList ?,?',[$user->roleid,$valintake]);
        $arr['valapprove']= DB::select ('EXEC spGetMenuList ?,?',[$user->roleid,$valapprove]);
        $arr['valdecline']= DB::select ('EXEC spGetMenuList ?,?',[$user->roleid,$valdecline]);
        $arr['valmanage']= DB::select ('EXEC spGetMenuList ?,?',[$user->roleid,$valmanage]);
        // property management  
        $arr['propmanintake']= DB::select ('EXEC spGetMenuList ?,?',[$user->roleid,$propmanintake]);
        $arr['propmanapprove']= DB::select ('EXEC spGetMenuList ?,?',[$user->roleid,$propmanapprove]);
        $arr['propmandecline']= DB::select ('EXEC spGetMenuList ?,?',[$user->roleid,$propmandecline]);
        //setup menu
        $arr['setupintake']= DB::select ('EXEC spGetMenuList ?,?',[$user->roleid,$setupintake]);
        $view->with($arr);
    } catch (\Throwable $th) {
        $error = 'fail to load menu';
        return $this->userforcelogout($error);
    }
}
}