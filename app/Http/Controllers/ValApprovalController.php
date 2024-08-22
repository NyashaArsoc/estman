<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ValApprovalController extends Controller
{
public function __construct(){
     $this->middleware(['loginauth']);
}

public function listallinstructionacknowledgement(){
    try {
        $user = $this->userdetail();
        $nom['normal'] = DB::select('EXEC spValGetInstAcknowledgeNormal ?',[$user->id]);
        $port['portfolio'] = DB::select('EXEC spValGetInstAcknowledgePortfolio ?',[$user->id]);
        $arr['acknow'] = array_merge($nom['normal'], $port['portfolio']);  
        return view('val.approval.list-instruct-acknowledge')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
    
}
public function viewsingleacknowledge($id,$instrid){
    try {
        $acknowledgeid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instrid);
        try {
            $arr['type']   = DB::table('clienttype')
                ->select('id','description')->get();
            $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
                ->select('*')->first();
            $arr['acknow']   = DB::table('valinstracknowledgement')->where('id',$acknowledgeid)
                ->select('*')->first();
            $arr['properties']   = collect(DB::select('EXEC spValGetInstrSingleProperty ?'
            ,[$arr['instr']->propertyid]))->first();
        
            $arr['purpose'] = match (trim($arr['instr']->isportfolio)) {
                'N' => DB::table('valinstructions') ->where('id', $instructionid)
                    ->select('*') ->first(),
                default => DB::table('valinstrportfolio')
                    ->where('id', $arr['instr']->portfolioid)
                    ->select('*')->first(),
            };
            $arr['client'] = match (trim($arr['instr']->isportfolio)) {
                'N' => DB::table('valclientcontactperson')->join('valclientdetail', 
                'valclientcontactperson.clientid','=', 'valclientdetail.id')
                ->where('valclientcontactperson.id', $arr['instr']->contactid)
                    ->select('valclientdetail.companyname','valclientdetail.lastname',
                    'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                    ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                    'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
                default => DB::table('valclientcontactperson')->join('valclientdetail', 
                'valclientcontactperson.clientid','=', 'valclientdetail.id')
                ->where('valclientcontactperson.id', $arr['purpose']->clientcontactid)
                    ->select('valclientdetail.companyname','valclientdetail.lastname',
                    'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                    ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                    'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
            };
           // return $arr;
             return view('val.approval.view-single-instruct-acknowledge-port')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listackn')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('valapp.listackn')
        ->with('error', 'failed to load');
    }
    
}
public function declineacknowledgement(Request $request,$id,$instr_id){
    try{
        $acknowledgeid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        try{
            DB::table('valinstracknowledgement')->where('id', $acknowledgeid)
            ->update(['comments' => $request->reasonsfordecline,'status' => 'D']);
            DB::table('valinstructions')->where('id', $instructionid)
            ->update(['status' => 'declined','completedon' => now()]);
            return redirect()->route('valapp.listackn')
            ->with('success', 'instruction declined');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listackn')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listackn')
        ->with('error', 'failed to load');
    }
}
public function acceptacknowledgement($id,$instr_id,$to_id){
    try{
        $acknowledgeid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        $allocatedid = Crypt::decrypt($to_id);
        try{
            DB::table('valinstracknowledgement')->where('id', $acknowledgeid)
            ->update(['completedby' => session('alluser'),'status' => 'C',
            'completedon' => now()]);
            DB::table('valinstrcompile')
            ->insert(['instructionid'=>$instructionid,'operatorid'=>session('alluser'),
            'allocatedto'=>$allocatedid]);
            return redirect()->route('valapp.listackn')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listackn')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listackn')
        ->with('error', 'failed to load');
    }
}
public function listallinstructioncompile(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.list-instruct-compile')->with($arr);
}
public function viewsinglecompile($proid,$instrid){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.view-single-instruct-compilation')->with($arr);
//return view('val.approval.view-single-instruct-acknowledge-norm')->with($arr);
}
public function listallinstructionqualitycheck(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.list-instruct-quality-check')->with($arr);
}
public function viewsinglequalitycheck($proid,$instrid){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.view-single-instruct-quality-check')->with($arr);
//return view('val.approval.view-single-instruct-acknowledge-norm')->with($arr);
}
public function listallinstructionfinalapproval(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.list-instruct-final-approval')->with($arr);
}
public function viewsinglefinalapproval($proid,$instrid){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.view-single-instruct-final-approval')->with($arr);
}
public function listallinstructionprint(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.list-instruct-printing')->with($arr);
}
public function viewsingleprint($proid,$instrid){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.view-single-printing')->with($arr);
}
public function listallinstructioninvoice(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.list-instruct-invoicing')->with($arr);
}
public function viewsingleinvoicing($proid,$instrid){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
    $arr['currency']   = DB::table('currency')
            ->select('id','code')->get();
return view('val.approval.view-single-invoicing')->with($arr);
}
}
