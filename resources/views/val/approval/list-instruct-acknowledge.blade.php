@php
 $title = 'Acknowledgement'; 
$description = 'acknowledge instruction ...'; 
@endphp
    @extends('layout.val-main-menu')
    @section('title', 'Acknowledgement')
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
                                    <th>Client</th>
                                    <th>Contact</th>
                                    <th>Property Type</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($type as $abc)
                                   <tr>
                                    <td>{{$count ++}}</td>
                                    <td>{{$abc->id}}</td>
                                    <td>{{$abc->id}}</td>
                                    <td>{{$abc->id}}</td>
                                    <td>{{$abc->id}}</td>
                                    <td>{{$abc->id}}</td>
                                    @php $id= Crypt::encrypt($abc->id); @endphp
                                    <td><a class="btn btn-info btn-sm " id=""
                                        href=""
                                        title="view"><i class="ti-eye mr-0-5"></i>view</a>
                                        <a class="btn btn-success btn-sm " id=""
                                        href=""
                                        title="accept"><i class="ti-check mr-0-5"></i>accept</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Client</th>
                                    <th>Contact</th>
                                    <th>Property Type</th>
                                    <th>Address</th>
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
