<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PropManApprovalController extends Controller
{
    /*---------------approval new landlord-----------------*/
public function listlandlordapproval(){
    try {
        $arr['landlord']   = DB::table('propmanalllandlord')
        ->where('approval','=' ,'N')
        ->select('*')->get();
        return view('propman.approval.list-landlord-pending-approval')->with($arr);
    } catch (\Throwable $th) {
      return  redirect()->route('dash.property');
    }
}
public function viewlandlordapproval($id){
    try {
        $landlordid = Crypt::decrypt($id);
        try {
            $arr['landlord']   = DB::table('propmanalllandlord')
            ->where('id', $landlordid)->select('*')->first();  
            $arr['contact']   = DB::table('propmanlandlordcontact')
            ->where('landlordid', $landlordid)
            ->select('*')->latest('id')->first();
            $arr['bank']   = DB::table('propmanlandlordbank')->where('landlordid', $landlordid)
            ->select('*')->get();
            return view('propman.approval.view-single-landlord-approval')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propapp.listland')
                ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('propapp.listland')
        ->with('error', 'failed to load');
    }
}
public function approvenewsinglelandlordapproval($id){
    try{
        $landlordid = Crypt::decrypt($id);
        try {
            DB::table('propmanlandlord')
            ->where('id',$landlordid)
            ->update(['approval' => 'Y' , 'available'=> 'Y','approvedby'=>session('alluser'),
            'approvedon'=>now()]);
            DB::table('propmanlandlordcontact')
            ->where('landlordid',$landlordid)
            ->update(['approval' => 'Y' , 'available'=> 'Y','approvedby'=>session('alluser'),
            'approvedon'=>now()]);
            return  redirect()->route('propapp.listland') 
            ->with('success', 'record approved');
        } catch (\Throwable $th) {
            return redirect()->route('propapp.viewland',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propapp.viewland',$id)
        ->with('error', 'failed to load');
    }
}
public function listlandlordcontactapproval(){
    try {
        $arr['contact']   = DB::table('propmanlandlordcontact')
        ->select('propmanalllandlord.fullname','propmanalllandlord.companyname','propmanlandlordcontact.*')
        ->join('propmanalllandlord', 'propmanlandlordcontact.landlordid','=','propmanalllandlord.id')
        ->where('propmanlandlordcontact.approval','=' ,'N')->get();
        return view('propman.approval.list-landlord-contact-pending-approval')->with($arr);
    } catch (\Throwable $th) {
      return  redirect()->route('dash.property');
    } 
}
public function approvenewlandlordcontact($id){
    try{
        $contactid = Crypt::decrypt($id);
        try {
            DB::table('propmanlandlordcontact')->where('id',$contactid)
            ->update(['approval' => 'Y' , 'available'=> 'Y','approvedby'=>session('alluser'),
            'approvedon'=>now()]);
            return  redirect()->route('propapp.listlandcont') 
            ->with('success', 'record approved');
        } catch (\Throwable $th) {
            return redirect()->route('propapp.landcont',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propapp.landcont',$id)
        ->with('error', 'failed to load');
    }
}
/*---------------end approval new landlord-----------------*/
/*---------------approval new property-----------------*/
public function listpropertyapproval(){
    try {
        $arr['property']   = DB::table('propmanallproperty')
        ->where('approval','=' ,'N')
        ->select('*')->get();
        return view('propman.approval.list-property-pending-approval')->with($arr);
    } catch (\Throwable $th) {
      return  redirect()->route('dash.property');
    }
}
public function viewpropertyapproval($id){
    try {
        $propertyid = Crypt::decrypt($id);
        try {
            $arr['property']   = DB::table('propmanallproperty')
            ->where('id', $propertyid)->select('*')->first();  
            return view('propman.approval.view-single-property-approval')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propapp.listprop')
                ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('propapp.listprop')
        ->with('error', 'failed to load');
    }
}
public function downloadmandatepdf($path) {
    try {
        $filename = Crypt::decrypt($path);
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("documents/prop/mandate/{$filename}")) {
                return abort(404);
            }
            return response()->download(storage_path("app/public/documents/prop/mandate/{$filename}"));

    } catch (DecryptException $th) {
        return redirect()->route('dash.property');
    }
}
public function downloadotherpdf($path) {
    try {
        $filename = Crypt::decrypt($path);
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("documents/prop/other/{$filename}")) {
                return abort(404);
            }
            return response()->download(storage_path("public/documents/prop/other/{$filename}"));

    } catch (DecryptException $th) {
        return redirect()->route('dash.property');
    }
}
public function downloadleaseagreementpdf($path) {
    try {
        $filename = Crypt::decrypt($path);
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("documents/prop/lease/{$filename}")) {
                return abort(404);
            }
            return response()->download(storage_path("app/public/documents/prop/lease/{$filename}"));

    } catch (DecryptException $th) {
        return redirect()->route('dash.property');
    }
}
public function approvenewproperty($id){
    try{
        $propertyid = Crypt::decrypt($id);
            try {
                DB::table('propmanproperty')
                ->where('id',$propertyid)
                ->update(['approval' => 'Y' , 'available'=> 'Y','approvedby'=>session('alluser'),
            'dateapproved'=>now()]);
                return  redirect()->route('propapp.listprop') 
                ->with('success', 'record approved');
            } catch (\Throwable $th) {
                return redirect()->route('propapp.viewprop',$id)
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propapp.viewprop',$id)
            ->with('error', 'failed to load');
        }
}
/*---------------end approval new property-----------------*/
/*---------------approval new tenant-----------------*/
public function listtenantapproval(){
    try {
        $arr['tenant']   = DB::table('propmanalltenant')
        ->where('approval','=' ,'N')
        ->select('*')->get();
        return view('propman.approval.list-tenent-pending-approval')->with($arr);
    } catch (\Throwable $th) {
      return  redirect()->route('dash.property');
    }
}
public function viewtenantapproval($id){
    try {
        $tenantid = Crypt::decrypt($id);
        try {
            $arr['tenant']   = DB::table('propmanalltenant')
            ->where('id', $tenantid)->select('*')->first();  
            $arr['contact']   = DB::table('propmantenantcontact')
            ->where('tenantid', $tenantid)
            ->select('*')->latest('id')->first();
            $arr['keen']   = DB::table('propmantenantkeen')
            ->where('tenantid', $tenantid)
            ->select('*')->latest('id')->first();
            return view('propman.approval.view-single-tenant-approval')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propapp.listland')
                ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('propapp.listland')
        ->with('error', 'failed to load');
    }
}
public function approvenewtenant($id){
    try{
        $tenantid = Crypt::decrypt($id);
        try {
            DB::table('propmantenant')
            ->where('id',$tenantid)
            ->update(['approval' => 'Y' , 'available'=> 'Y','approvedby'=>session('alluser'),
            'dateapproved'=>now()]);
            return  redirect()->route('propapp.listten') 
            ->with('success', 'record approved');
        } catch (\Throwable $th) {
            return redirect()->route('propapp.viewten',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propapp.viewten',$id)
        ->with('error', 'failed to load');
    }
}
/*---------------end approval new tenant-----------------*/
/*---------------approval new lease-----------------*/
public function listleaseapproval(){
    try {
        $arr['lease']   = DB::table('propmanalllease')
        ->where('approval','=' ,'N')
        ->select('*')->get();
        return view('propman.approval.list-lease-pending-approval')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    }
}
public function viewleaseapproval($id){
    try {
        $leaseid = Crypt::decrypt($id);
        try {
            $arr['lease']   = DB::table('propmanalllease')
            ->where('id', $leaseid)->select('*')->first();  
            $arr['prepay']   = DB::table('propmanleaseprepayments')->where('leaseid', $leaseid)
            ->select('*')->first();
            $arr['balance']   = DB::table('propmanleasearrearsdetails')->where('leaseid', $leaseid)
            ->select('*')->first();
            $arr['rates']   = DB::table('propmanleasecurrentbillrates')->where('leaseid', $leaseid)
            ->select('*')->get();

            return view('propman.approval.view-single-lease-approval')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propapp.listland')
                ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('propapp.listland')
        ->with('error', 'failed to load');
    }
}
public function approvenewlease($id){
    try{
        $leaseid = Crypt::decrypt($id);
        try {
            DB::table('propmanlease')
            ->where('id',$leaseid)
            ->update(['approval' => 'Y' , 'available'=> 'Y','approvedby'=>session('alluser'),
            'dateapproved'=>now()]);
            return  redirect()->route('propapp.listlea') 
            ->with('success', 'record approved');
        } catch (\Throwable $th) {
            return redirect()->route('propapp.viewlease',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propapp.viewlease',$id)
        ->with('error', 'failed to load');
    }
}
/*---------------end approval new lease-----------------*/
}
