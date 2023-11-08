@extends('layouts/layoutMaster')

@section('title', 'Task Management')


@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/fullcalendar/fullcalendar.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/editor.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-calendar.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/fullcalendar/fullcalendar.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
@endsection




@section('page-script')


<script src="{{asset('assets/js/app-calendar-events.js')}}"></script>
<script src="{{asset('assets/js/app-calendar.js')}}"></script>

<script>

$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2 = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#offcanvasAddUser');
  if (select2.length) {
    var $this = select2;
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select Country',
      dropdownParent: $this.parent()
    });
  }

});



</script>

@endsection




@section('content')


<!-- Users List Table -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title mb-0">Add Client To a User</h5>
  </div>
  <div class="card-datatable table-responsive p-2">
     <!-- Offcanvas to add new user -->
     <div class="offcanvas-header pb-4">
      {{-- <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add Event To a User</h5> --}}
    </div>
  
    
    <div class="offcanvas-body mx-0 flex-grow-0">
      @if(session('created'))
          <div class="alert alert-success">
            Client Created successfully
          </div>
      @endif
      @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
     @endif
     <form class="add-new-user pt-0" id="addNewUserForm"  method="POST" action="{{route('timesheet.addstoreadmin',$userId)}}">
       @csrf
      <input type="hidden" name="id" id="user_id">
      <div class="mb-3">
        <label class="form-label" for="add-user-company">Company</label>
        <input type="text" id="add-user-company" name="company" class="form-control" placeholder="Web Developer" aria-label="jdoe1" />
      </div>
      <div class="mb-3">
        <label class="form-label" for="add-user-fullname">Full Name</label>
        <input type="text" class="form-control" id="add-user-fullname" placeholder="John Doe" name="name" aria-label="John Doe" />
      </div>
      <div class="mb-3">
        <label class="form-label" for="add-user-email">Email</label>
        <input type="text" id="add-user-email" class="form-control" placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="email" />
      </div>
   
      <div class="mb-3">
          <label class="form-label" for="add-user-remark">Remark</label>
          <input type="text" id="add-user-remark" name="remark" class="form-control" placeholder="Add remark" aria-label="remark" />
        </div>
      
      {{-- <div class="mb-3">
        <label class="form-label" for="country">Country</label>
        <select id="country" class="select2 form-select">
          <option value="">Select</option>
          <option value="Australia">Australia</option>
          <option value="Bangladesh">Bangladesh</option>
          <option value="Belarus">Belarus</option>
          <option value="Brazil">Brazil</option>
          <option value="Canada">Canada</option>
          <option value="China">China</option>
          <option value="France">France</option>
          <option value="Germany">Germany</option>
          <option value="India">India</option>
          <option value="Indonesia">Indonesia</option>
          <option value="Israel">Israel</option>
          <option value="Italy">Italy</option>
          <option value="Japan">Japan</option>
          <option value="Korea">Korea, Republic of</option>
          <option value="Mexico">Mexico</option>
          <option value="Philippines">Philippines</option>
          <option value="Russia">Russian Federation</option>
          <option value="South Africa">South Africa</option>
          <option value="Thailand">Thailand</option>
          <option value="Turkey">Turkey</option>
          <option value="Ukraine">Ukraine</option>
          <option value="United Arab Emirates">United Arab Emirates</option>
          <option value="United Kingdom">United Kingdom</option>
          <option value="United States">United States</option>
        </select>
      </div> --}}
      
      
      <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
    </form>
  
   
  </div>
 
</div>
@endsection
