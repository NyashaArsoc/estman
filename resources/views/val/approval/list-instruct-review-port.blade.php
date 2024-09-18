@php
 $title = 'Portfolio Review'; 
$description = 'all portfolios pending review...'; 
@endphp
    @extends('layout.val-main-menu')
    @section('title', 'Portfolios')
    @section('content')
        <!-- Content Start-->
        <div class="container-fluid">
            <h4>{{$title}}</h4>
            <ol class="breadcrumb no-bg mb-1">
                <li class="breadcrumb-item"><a href="{{route('dash.val')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
            <div class="box box-block bg-white">
                <h5>{{$title}}</h5>
                <p class="font-90 text-muted mb-1"> {{$description}}</p>
                <div class="table-responsive">
                    <hr/><table  class="datatable table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Portfolio</th>
                                    <th>Expected Properties</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($portfolio as $abc)
                                   <tr>
                                    @php
                                    $status = trim(now())>=trim($abc->datedue) ? 
                                    '<span class="badge badge-pill bg-danger">overdue</span>'
                                    : '<span class="badge badge-pill bg-success">pending</span>';  
                                  @endphp
                                    <td>{{$count ++}}</td>
                                    <td>{{$abc->contactfullname ?? ''}} {{$abc->companyname ?? ''}} {{$abc->fullname ?? ''}}</td>
                                    <td>{{$abc->totalproperties}}</td>
                                    <td> {!! $status !!} </td>
                                    @php $id= Crypt::encrypt($abc->portfolioid);  @endphp
                                 <td><a class="btn btn-info btn-sm " id=""
                                     href="{{route('valapp.viewsinglportfoli',$id)}}"
                                     title="view"><i class="ti-eye mr-0-5"></i>view</a>
                                 </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Portfolio</th>
                                    <th>Expected Properties</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </tfoot>
                        </table>
                        @include('layout.arlet')
                </div>
            </div>
        </div>
        <!-- Content End-->
    @endsection
