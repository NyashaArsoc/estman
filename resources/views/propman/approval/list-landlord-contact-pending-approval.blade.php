@php $title = 'Contact Approval'; 
      $description = 'landlord contact pending approval...'; @endphp
    @extends('layout.propman-main-menu')
    @section('title', 'Contact Approval')
    @section('additional css')
    <!-- Additional css Start-->
    <!-- Additional css End-->
    @endsection
    @section('content')
        <!-- Content Start-->
        <div class="container-fluid">
            <h4>{{$title}}</h4>
            <ol class="breadcrumb no-bg mb-1">
                <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
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
                                    <th>Landlord</th>
                                    <th>Name</th>
                                    <th>Cell</th>
                                    <th>Email</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($contact as $abc)
                            <tr>
                                    <td>{{$count ++}}</td>
                                    <td>{{ $abc->fullname}}  {{ $abc->companyname}}</td>
                                    <td>{{ $abc->lastname }} {{ $abc->firstname ?? ''}}</td>
                                    <td>{{ $abc->cell }}</td>
                                    <td>{{ $abc->email }}</td>
                                    <td>@php $id= Crypt::encrypt($abc->id); @endphp
                                        @if (in_array(5,$arraycontrolids))
                                        <a onclick = "approveentry(this); return false;" class="btn btn-success btn-sm" 
                                        href="{{route('propapp.landcont', $id)}}"title="approve">
                                        <i class="ti-check mr-0-5"></i>approve</a> @endif
                            </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Landlord</th>
                                    <th>Name</th>
                                    <th>Cell</th>
                                    <th>Email</th>
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
    @section('additional js')
    <!-- Additional JS Start-->
        <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <!-- Additional JS End-->
    @endsection