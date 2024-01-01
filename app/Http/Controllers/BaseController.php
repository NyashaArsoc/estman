<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
  
    public function sharelandlordid($id){
        $routes = '/landlord/'.$id.'/view-ledgers';
        view()->share('sharedroute',$routes);
    }
    public function sharepropertyid($id){
        $routes = '/property/'.$id.'/view-ledgers';
        view()->share('sharedroute',$routes);
    }
}
