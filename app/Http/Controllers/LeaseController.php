<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $arr['type']   = DB::table('clienttype')
            ->select('id','description')->get();
            $arr['currency']   = DB::table('currency')
            ->select('id','code')->get();
            $arr['province']   = DB::table('province')
            ->select('id','description')->get();
            $arr['propertytype']   = DB::table('propertytype')
            ->select('id','description')->get();
          return view('lease/add-lease')
          ->with($arr);
            
        } catch (QueryException $e) {
            return  redirect()->route('tenant.create') 
            ->with('error', 'failed to load lease');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lease $lease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lease $lease)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lease $lease)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lease $lease)
    {
        //
    }
    
    public function  pendingapproval(){
        return view('lease/pending-approval');
    }
    public function  rejected(){
        return view('lease/rejected');
    }
    public function  listlandlords(){
        return view('lease/list');
    }
}
