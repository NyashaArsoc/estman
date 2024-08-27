<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
            $user = $this->userdetail();
            $typeid =  DB::table('valinstructions')->join('valclientproperty', 
            'valinstructions.propertyid','=', 'valclientproperty.id')
            ->where('valinstructions.id', $instructionid)
                ->select('valclientproperty.propertytypeid') ->first();
            $minsexpected =  DB::table('valinstrexpectedmins')->where('propertytypeid', $typeid->propertytypeid)
            ->select('*') ->first();
        $datestamp =     DB::table('valinstrcompile')->where('allocatedto', $user->id)
        ->where('status','=','P')->select('*')->orderBy('id', 'desc')->first();
        $newdatestamp = is_null($datestamp) ? now() : $datestamp->datestamp;
        $datedue = Carbon::parse($newdatestamp)->addMinutes($minsexpected->minsexpectedtocompile);
        DB::table('valinstracknowledgement')->where('id', $acknowledgeid)
        ->update(['completedby' => session('alluser'),'status' => 'C','completedon' => now()]);
        DB::table('valinstrcompile') ->insert(['instructionid'=>$instructionid,'operatorid'=>
        session('alluser'),'allocatedto'=>$allocatedid,'datedue'=>$datedue]);
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
/*-----------instruction compilation--------------*/
public function listallinstructioncompile(){
    try {
        $user = $this->userdetail();
        $nom['normal'] = DB::select('EXEC spValGetInstCompileNormal ?',[$user->id]);
        $port['portfolio'] = DB::select('EXEC spValGetInstCompilePortfolio ?',[$user->id]);
        $arr['acknow'] = array_merge($nom['normal'], $port['portfolio']);  
        return view('val.approval.list-instruct-compile')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
}
public function viewsinglecompile($id,$instrid){
    try {
        $compileid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instrid);
        try {
            $arr['type']   = DB::table('clienttype')
                ->select('id','description')->get();
            $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
                ->select('*')->first();
            $arr['acknow']   = DB::table('valinstrcompile')->where('id',$compileid)
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
            return view('val.approval.view-single-instruct-compilation')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listcomp')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('valapp.listcomp')
        ->with('error', 'failed to load');
    }
}
public function submitcompilation(Request $request,$id,$instr_id,$propid){
    try{
        $compileid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        $propertyid = Crypt::decrypt($propid);
        try{
        $datestamp =     DB::table('valinstrqualitycheck')
        ->where('status','=','P')->select('*')->orderBy('id', 'desc')->first();
        $newdatestamp = is_null($datestamp) ? now() : $datestamp->datestamp;
        $datedue = Carbon::parse($newdatestamp)->addMinutes(60);
        DB::table('valinstrcompile')->where('id', $compileid)
        ->update(['completedby' => session('alluser'),'status' => 'C','completedon' => now(),
        'marketvalue'=>$request->marketvalue,'grc'=>$request->grc,'forcedsale'=>$request->forcedsalestimate,
        'depreciation' =>$request->depreciationvalue,'rentalvalue'=>$request->rentalvalue,'landvalue'
        =>$request->landvalue,'drc'=>$request->drc,'fairvalue'=>$request->fairvalue,'comments'=>
        $request->commentshighlights]);
        DB::table('valclientproperty')->where('id', $propertyid)
        ->update(['standnumber'=>$request->standnumber]);
       
        DB::table('valinstrqualitycheck') ->insert(['instructionid'=>$instructionid,'operatorid'=>
        session('alluser'),'datedue'=>$datedue]);
            return redirect()->route('valapp.listcomp')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listcomp')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listcomp')
        ->with('error', 'failed to load');
    }
}
/*quality check */
public function listallinstructionqualitycheck(){
    try{
        $nom['normal'] = DB::select('EXEC spValGetInstQualityNormal');
        $port['portfolio'] = DB::select('EXEC spValGetInstQualityPortfolio');
        $arr['acknow'] = array_merge($nom['normal'], $port['portfolio']); 
    return view('val.approval.list-instruct-quality-check')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
}
public function viewsinglequalitycheck($id,$instrid){
try {
    $qualityid = Crypt::decrypt($id);
    $instructionid = Crypt::decrypt($instrid);
    try {
        $arr['type']   = DB::table('clienttype')
            ->select('id','description')->get();
        $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
            ->select('*')->first();
        $arr['prevstage']   = DB::table('valinstrcompile')->where('instructionid',$instructionid)
            ->select('*')->orderBy('id', 'desc')->first();;
        $arr['currstage']   = DB::table('valinstrqualitycheck')->where('id',$qualityid)
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
        return view('val.approval.view-single-instruct-quality-check')->with($arr);
    } catch (\Throwable $th) {
        return redirect()->route('valapp.listquality')
    ->with('error', 'failed to load');
    }
} catch (DecryptException $th) {
return redirect()->route('valapp.listquality')
    ->with('error', 'failed to load');
}
}
public function submitqualitycheck(Request $request,$id,$instr_id,$propid){
    try{
        $qualityid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        try{
        $isprint = (is_null($request->isprintreport)) ? 'N' : 'Y' ;
           
        $approvaldatestamp =     DB::table('valinstrfinalapproval')
        ->where('status','=','P')->select('*')->orderBy('id', 'desc')->first();
        $invoicedatestamp =     DB::table('valinstrinvoicing')
        ->where('status','=','P')->select('*')->orderBy('id', 'desc')->first();

        $newapprovaldatestamp = is_null($approvaldatestamp) ? now() : $approvaldatestamp->datestamp;
        $newinvoicedatestamp  = is_null($invoicedatestamp) ? now() : $invoicedatestamp->datestamp;
        $approvaldatedue = Carbon::parse($newapprovaldatestamp)->addMinutes(60);
        $invoicedatedue  = Carbon::parse($newinvoicedatestamp)->addMinutes(60);

        DB::table('valinstrqualitycheck')->where('id', $qualityid)
        ->update(['completedby' => session('alluser'),'status' => 'C',
        'completedon' => now(),'comments'=>$request->commentshighlights]);
       
        DB::table('valinstrinvoicing') ->insert(['instructionid'=>$instructionid,'operatorid'=>
        session('alluser'),'datedue'=>$invoicedatedue]);
        DB::table('valinstrfinalapproval') ->insert(['instructionid'=>$instructionid,'operatorid'=>
        session('alluser'),'datedue'=>$approvaldatedue,'isprint'=>$isprint]);

            return redirect()->route('valapp.listquality')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listquality')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listquality')
        ->with('error', 'failed to load');
    }
}
/*-----------report approval ----------------- */
public function listallinstructionfinalapproval(){
    try{
        $nom['normal'] = DB::select('EXEC spValGetInstFinalApprovalNormal');
        $port['portfolio'] = DB::select('EXEC spValGetInstFinalApprovalPortfolio');
        $arr['stage'] = array_merge($nom['normal'], $port['portfolio']); 
    return view('val.approval.list-instruct-final-approval')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
}
public function viewsinglefinalapproval($id,$instrid){
    try {
        $approvalid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instrid);
        try {
            $arr['type']   = DB::table('clienttype')
                ->select('id','description')->get();
            $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
                ->select('*')->first();
            $arr['prevstage']   = DB::table('valinstrcompile')->where('instructionid',$instructionid)
                ->select('*')->orderBy('id', 'desc')->first();
            $arr['currstage']   = DB::table('valinstrfinalapproval')->where('id',$approvalid)
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
            return view('val.approval.view-single-instruct-final-approval')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listallappro')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('valapp.listallappro')
        ->with('error', 'failed to load');
    }
}
public function submitfinaleapproval(Request $request,$id,$instr_id){
    try{
        $approvalid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        try{
        $datestamp =     DB::table('valinstrprinting')
        ->where('status','=','P')->select('*')->orderBy('id', 'desc')->first();
        $compileid =     DB::table('valinstrcompile')
        ->where('instructionid',$instructionid)->select('id')->orderBy('id', 'desc')->first();
        $isprint     =     DB::table('valinstrfinalapproval')->where('id', $approvalid)
        ->select('*')->first();
        $newdatestamp = is_null($datestamp) ? now() : $datestamp->datestamp;
        $datedue = Carbon::parse($newdatestamp)->addMinutes(60);
        if (trim($isprint->isprint)=='Y'){
            DB::table('valinstrprinting') ->insert(['instructionid'=>$instructionid,'operatorid'=>
            session('alluser'),'datedue'=>$datedue]);
        }
        DB::table('valinstrcompile')->where('id', $compileid->id)
        ->update(['marketvalue'=>$request->marketvalue,'grc'=>$request->grc,'forcedsale'=>
        $request->forcedsalestimate,'depreciation' =>$request->depreciationvalue,'rentalvalue'=>
        $request->rentalvalue,'landvalue' =>$request->landvalue,'drc'=>$request->drc,'fairvalue'=>
        $request->fairvalue]);
       
        DB::table('valinstrfinalapproval')->where('id', $approvalid)
        ->update(['completedby' => session('alluser'),'status' => 'C',
        'completedon' => now()]);

        return redirect()->route('valapp.listcomp')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listcomp')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listcomp')
        ->with('error', 'failed to load');
    }
}
/*------------printing reports-----------------------------*/ 
public function listallinstructionprint(){
    try{
        $nom['normal'] = DB::select('EXEC spValGetInstPrintNormal');
        $port['portfolio'] = DB::select('EXEC spValGetInstPrintPortfolio');
        $arr['stage'] = array_merge($nom['normal'], $port['portfolio']); 
    return view('val.approval.list-instruct-printing')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
}
public function viewsingleprint($id,$instrid){
    try {
        $printid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instrid);
        try {
            $arr['type']   = DB::table('clienttype')
                ->select('id','description')->get();
            $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
                ->select('*')->first();
            $arr['prevstage']   = DB::table('valinstrcompile')->where('instructionid',$instructionid)
                ->select('*')->orderBy('id', 'desc')->first();
            $arr['currstage']   = DB::table('valinstrprinting')->where('id',$printid)
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
            return view('val.approval.view-single-printing')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listallappro')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('valapp.listallappro')
        ->with('error', 'failed to load');
    }
}
public function submitprinting(Request $request,$id,$instr_id){
    try{
        $printid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        try{
        $datestamp =     DB::table('valinstrdispatch')
        ->where('status','=','P')->select('*')->orderBy('id', 'desc')->first();
       
        $newdatestamp = is_null($datestamp) ? now() : $datestamp->datestamp;
        $datedue = Carbon::parse($newdatestamp)->addMinutes(60);
        DB::table('valinstrprinting')->where('id', $printid)
        ->update(['completedby' => session('alluser'),'status' => 'C',
        'completedon' => now()]);
        DB::table('valinstrdispatch') ->insert(['instructionid'=>$instructionid,'operatorid'=>
        session('alluser'),'datedue'=>$datedue]);
        return redirect()->route('valapp.listprint')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listprint')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listprint')
        ->with('error', 'failed to load');
    }
}
/*------------- report invoicing ----------------- */
public function listallinstructioninvoice(){
    try{
        $nom['normal'] = DB::select('EXEC spValGetInstInvoicingNormal');
        $port['portfolio'] = DB::select('EXEC spValGetInstInvoicingPortfolio');
        $arr['stage'] = array_merge($nom['normal'], $port['portfolio']); 
    return view('val.approval.list-instruct-invoicing')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
}
public function viewsingleinvoicing($id,$instrid){
    try {
        $printid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instrid);
        try {
            $arr['type']   = DB::table('clienttype')
                ->select('id','description')->get();
            $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
                ->select('*')->first();
            $arr['prevstage']   = DB::table('valinstrcompile')->where('instructionid',$instructionid)
                ->select('*')->orderBy('id', 'desc')->first();
            $arr['currstage']   = DB::table('valinstrprinting')->where('id',$printid)
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
            $arr['currency']   = DB::table('currency')
            ->select('id','code')->get();
            return view('val.approval.view-single-invoicing')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listinvoice')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('valapp.listinvoice')
        ->with('error', 'failed to load');
    }
}
public function submitinvoicing(Request $request,$id){
    try{
        $invoiceid = Crypt::decrypt($id);
        try{
        DB::table('valinstrinvoicing')->where('id', $invoiceid)
        ->update(['completedby' => session('alluser'),'status' => 'C', 'completedon' 
        => now(),'currencycode'=>$request->currencycode,'amountinvoiced'=>$request->invoicedamount]);

        return redirect()->route('valapp.listinvoice')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listinvoice')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listinvoice')
        ->with('error', 'failed to load');
    }
}
/*--------------------dispatch ----------------*/
public function listallinstructiondispatch(){
    try{
        $nom['normal'] = DB::select('EXEC spValGetInstDispatchNormal');
        $port['portfolio'] = DB::select('EXEC spValGetInstDispatchPortfolio');
        $arr['stage'] = array_merge($nom['normal'], $port['portfolio']); 
    return view('val.approval.list-instruct-dispatch')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
}
public function viewsingledispatch($id,$instr_id){
    try {
        $printid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        try {
            $arr['type']   = DB::table('clienttype')
                ->select('id','description')->get();
            $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
                ->select('*')->first();
            $arr['currstage']   = DB::table('valinstrdispatch')->where('id',$printid)
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
            return view('val.approval.view-single-dispatch')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listinvoice')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('valapp.listinvoice')
        ->with('error', 'failed to load');
    }
}
public function submitdispatch($id){
    try{
        $printid = Crypt::decrypt($id);
        try{
       
        DB::table('valinstrdispatch')->where('id', $printid)
        ->update(['completedby' => session('alluser'),'status' => 'C',
        'completedon' => now()]);
        return redirect()->route('valapp.listdispatch')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listdispatch')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listdispatch')
        ->with('error', 'failed to load');
    }
}
}
