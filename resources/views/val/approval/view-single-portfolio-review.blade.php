@php
 $title = 'Portfolio Compilation'; 
$description = 'all portfolios properties pending...'; 
$portfolioid= Crypt::encrypt($portfolio->id);
@endphp
    @extends('layout.no-menu-layout')
    @section('title', 'Portfolios')
    @section('content')
        <!-- Content Start-->
        <div class="container-fluid">
            <h4>{{$title}}</h4>
            <ol class="breadcrumb no-bg mb-1">
                <li class="breadcrumb-item"><a href="{{route('dash.val')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('valapp.listportreview') }}">List</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
            <div class="box box-block bg-white">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5>Portfolio:{{$portfolio->companyname}}  {{$portfolio->fullname}}</h5>
                        <p class="font-90 text-muted mb-1">complete all sections below to close this portfolio</p>
                        
                    </div>
                </div>
                <form action="{{ route('valapp.sbtreviewport') }}" method="POST" id="defaultform">@csrf
                    <div>
                        <button type="submit" class="btn btn-primary" id="btn-portfolio-compile">compile
                            <span id="selected-items-info"></span>
                        </button>
                    </div>
                    <input type="text" class="form-control" name="portfolio" hidden
                value="{{$portfolioid}}" />
                <div class="table-responsive">
                    <hr/><table  class="datatable table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Valuer</th>
                                    <th>Street Address</th>
                                    <th>Stand Number</th>
                                    <th>Report</th>
                                    <th>Select <input type="checkbox" id="select-all"></th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($instruction as $abc)
                                   <tr>
                                    @php
                                    $instr_id= Crypt::encrypt($abc->instructionid);
                                    $status = trim(now())>=trim($abc->datedue) ? 
                                    '<span class="badge badge-pill bg-danger">overdue</span>'
                                    : '<span class="badge badge-pill bg-success">pending</span>';  
                                    $attachementdoc = ($abc !== null && !is_null($abc->reportdoc)) 
                                    ? 'download report' : '';
                                    $reportdoc = ($abc !== null && !is_null($abc->reportdoc)) 
                                    ? route('valapp.dwndoc',[$instr_id]) : '';
                                  @endphp
                                    <td>{{$count ++}}</td>
                                    <td>{{$abc->allocatedto ?? ''}}</td>
                                    <td>{{$abc->streetaddress}}</td>
                                    <td>{{$abc->standnumber}}</td>
                                    <td><a href="{{ $reportdoc }}">{{ $attachementdoc}}</a> </td>
                                    @php $id= Crypt::encrypt($abc->instructionid);  @endphp
                                 <td><input type="checkbox" name="selected_ids[]" value="{{ $id }}" class="select-item">
                                 </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Valuer</th>
                                    <th>Street Address</th>
                                    <th>Stand Number</th>
                                    <th>Report</th>
                                    <th>Select <input type="checkbox" id="select-all"></th>
                                </tr>
                            </tfoot>
                        </table>
                        
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <a onclick = "closeportfolioreview(this); return false;"
                        class="btn btn-success btn-sm" href="{{route('valapp.portclosereview', $portfolioid)}}"
                        title="close"><i class="ti-check mr-0-5"></i>close portfolio review</a>
                    </div>
                </div>
                @include('layout.arlet')
                </form>
            </div>
        </div>
        <!-- Content End-->
    @endsection
    @section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('js/button-select-multiple.js') }}"></script> 
    <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <!-- Additional JS End-->
    @endsection