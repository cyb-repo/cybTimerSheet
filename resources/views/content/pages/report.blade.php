@extends('layouts/layoutMaster')

@section('title', 'Report')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/client-management.js')}}"></script>
@endsection

@section('content')



<div class="d-grid gap-3 col-lg-12 mx-auto">
    <button onclick="download('weekly')" class="btn btn-primary btn-lg  waves-effect waves-light" type="button"> <span class="ti-xs ti ti-cloud-download me-1"></span> Weekly Report</button>
    <button onclick="download('monthly')" class="btn btn-info btn-lg  waves-effect waves-light" type="button"> <span class="ti-xs ti ti-cloud-download me-1"></span>Weekly Report</button>
    <button onclick="download('yearly')" class="btn btn-dark  btn-lg  waves-effect waves-light" type="button"> <span class="ti-xs ti ti-cloud-download me-1"></span>Yearly Report</button>
</div>


<script>

    function download($d){
        const url  = '/download-report/'+$d;
        //ajax javascript
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.responseType = 'blob';
        xhr.onload = function(){
            if(this.status === 200){
                const fileURL = window.URL.createObjectURL(this.response);
                const fileLink = document.createElement('a');
                fileLink.href = fileURL;
                //file name report time .csv
                const filename = 'report-'+ $d + '-' + new Date().toLocaleDateString()+'.csv';
                fileLink.setAttribute('download', filename );
                document.body.appendChild(fileLink);
                fileLink.click();
            }
        }
        xhr.send();
        

    }

</script>
@endsection
