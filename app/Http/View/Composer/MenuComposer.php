<?php

namespace app\Http\View\Composer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MenuComposer extends Controller
{
    public function compose(View $view)
    {
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
            $propmanmanage      =   'propmanmanage';
            /*------------------------set up menu--------------------------- */
            $setupintake      =   'setupintake';
            $setupmanage      =   'setupmanage';
            //human capital
            $hcintake      =   'hcintake';
            $hcapprove      =   'hcapprove';
            $hcdecline      =   'hcdecline';
            $hcmanage      =   'hcmanage';
            //administration 
            $adminintake      =   'adminintake';
            $adminapprove      =   'adminapprove';
            $admindecline      =   'admindecline';
            $adminmanage      =   'adminmanage';

            $arr['valintake'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $valintake]);
            $arr['valapprove'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $valapprove]);
            $arr['valdecline'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $valdecline]);
            $arr['valmanage'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $valmanage]);
            // property management  
            $arr['propmanintake'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $propmanintake]);
            $arr['propmanapprove'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $propmanapprove]);
            $arr['propmandecline'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $propmandecline]);
            $arr['propmanmanage'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $propmanmanage]);
            //setup menu
            $arr['setupintake'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $setupintake]);
            $arr['setupmanage'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $setupmanage]);
            // human capital 
            $arr['hcintake'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $hcintake]);
            $arr['hcapprove'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $hcapprove]);
            $arr['hcdecline'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $hcdecline]);
            $arr['hcmanage'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $hcmanage]);
            // admin 
            $arr['adminintake'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $adminintake]);
            $arr['adminapprove'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $adminapprove]);
            $arr['admindecline'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $admindecline]);
            $arr['adminmanage'] = DB::select('EXEC spGetMenuList ?,?', [$user->roleid, $adminmanage]);
            $view->with($arr);
        } catch (\Throwable $th) {
            $error = 'fail to load menu';
            return $this->userforcelogout($error);
        }
    }
}
