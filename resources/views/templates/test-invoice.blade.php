@extends('layout.no-menu-layout')
@section('title', 'Invoice')
@section('additional css')
    <!-- Additional css Start-->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- Additional css End-->
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script src="{{ asset('js/dropdown-get-data.js') }}"></script>
    <script>
        function generatePDF() {
          // Choose the element that our invoice is rendered in.
          const element = document.getElementById("printinvoice");
          // Choose the element and save the PDF for our user.
          html2pdf()
            .from(element)
            .save();
        }
      </script>
@endsection
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>Ila</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('invoice.listpre') }}">Pending</a></li>
            <li class="breadcrumb-item active">InvoicesList</li>
        </ol>
        <!--invoice start print-->
        <div class="card" id="printinvoice">
            <div class="card-header clearfix">
                <h5 class="float-xs-left mb-0">Invoice #29</h5>
                <div class="float-xs-right">January 24, 2024</div>
            </div>
            <div class="card-block" >
                <div class="row mb-2">
                    <div class="col-sm-8 col-xs-6">	
                        <img src="img/estman logo.png" >
                        <h5>Arsoc Digital,</h5>
                        <p>6th Floor GreenBridge<br>Eastgate Harare<br>Zimbabwe</p>
                        <p>Phone: 0867 771 347<br>Cell: 800-692-7753</p>
                    </div>
                    <div class="col-sm-4 col-xs-6">
                        <h5>Invoice To:</h5>
                        <p>Client Name,</p>
                        <p>VAT Number</p>
                        <p>Cell: 874774884</p>

                        <h5>Payment Details:</h5>
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-left">Grand Total: </span>
                            <span class="float-xs-right">$2254000</span>
                        </div>
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-left">Paid Total: </span>
                            <span class="float-xs-right">$2254000</span>
                        </div>
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-left">Total Due:</span>
                            <span class="float-xs-right">$0</span>
                        </div>
                        <hr class="hr">
                        <p>Invoice created by: johnny russell</p>  
                    </div>
                </div>
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr>
                            <th class="text-center">Item Information</th> 
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Rate</th>
                            <th class="text-center">Discount/item</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>MACBOOCK PRO M2</td>
                            <td>98 BAG</td>
                            <td>$23000</td>
                            <td>$0</td>
                            <td>$2254000</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Terms and Conditions</strong>
                        <p class="text-muted mb-0">Thank you for your business. 
                            We do expect payment within 21 days, so please process 
                            this invoice within that time. There will be a 1.5%
                             interest charge per month on late invoices.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="text-xs-right">
                            <div class="mb-0-5">Sub - Total Amount: $2254000</div>
                            <div class="mb-0-5">Total Discount: $0</div>
                            <div class="mb-0-5">Grand Total: <strong>$2254000</strong></div>
                            <div class="mb-0-5">Paid Total: $2254000</div>
                            <div class="mb-0-5">Total Due: $0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer clearfix">
                <button type="button" class="btn btn-danger label-left float-xs-right" onclick="generatePDF()">
                    <span class="btn-label"><i class="ti-download"></i></span>
                    Download
                </button>
            </div>
        </div>
        <!--invoice end print-->
    </div>
    <!-- Content End-->
@endsection
@section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script>
    <!-- Additional JS End-->
@endsection
