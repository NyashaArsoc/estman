@php 
$title = 'Subledgers';
$description = 'lease subledgers...'; 
$id= Crypt::encrypt($lease->id);
$product= Crypt::encrypt('debtors');
if ($lease->clienttypeid == 1){
    $tname   =  $lease->fullname ;
   }else{
     $tname   =  $lease->companyname ;
 }  
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Lease Subledgers')
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('lease.list')}}">List</a></li>
            <li class="breadcrumb-item"><a href="{{route('lease.view',$id)}}">Lease</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="" method="POST"
                action="{{route('lease.createsub',['id'=>$id,'product'=>$product])}}">@csrf
             <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Tenant Name</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" value="{{ $tname }}" readonly>
                </div>
                <label for="" class="col-sm-2 form-control-label">Property</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" value="{{ $lease->propertydescription }}" readonly>
                </div> 
            </div>
                <div class="table-responsive">
                    <hr/><table  class="datatable table table-hover table-bordered">
                            <thead> 
                                <tr>
                                    <th>No</th>
                                    <th>Account Code</th>
                                    <th>Currency</th>
                                    <th>GL Code</th>
                                    <th>GL Name</th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($ledgers as $abc)
                            <tr>
                               
                                    <td>{{$count ++}}</td>
                                    <td>{{ $abc->accountcode }}</td>
                                    <td>{{ $abc->currencycode }}</td>
                                    <td>{{ $abc->code }}</td>
                                    <td>{{ $abc->description }}</td>  
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Account Code</th>
                                    <th>Currency</th>
                                    <th>GL Code</th>
                                    <th>GL Name</th>
                                </tr>
                            </tfoot>
                        </table>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-submit" >
                            create ledgers</button>
                    </div>
                </div>
                @include('layout.arlet')
            </form>
        </div>
    </div>
    <!-- Content End-->

@endsection

