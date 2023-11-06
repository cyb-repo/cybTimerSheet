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
    <h5 class="card-title mb-0">Add Event To a User</h5>
  </div>
  <div class="card-datatable table-responsive p-2">
     <!-- Offcanvas to add new user -->
     <div class="offcanvas-header pb-4">
      {{-- <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add Event To a User</h5> --}}
    </div>
  
    
    <div class="offcanvas-body mx-0 flex-grow-0">
      @if(session('created'))
          <div class="alert alert-success">
            Event Created successfully
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
     <form class="event-form pt-0" id="eventForm" method="POST" action="{{route('timesheet.addstoreadmin',$userId)}}">
        @csrf
        <div class="mb-3">
          <label class="form-label" for="add-task">Tasks</label>
          <select id="add-task" class="select2 form-select" name="task">
            <option value="" selected>Select</option>
            @foreach ($tasks as $task)
            <option value="{{$task->id}}">{{$task->title}}</option>
            @endforeach
          </select>
        </div>
       
        <div class="mb-3">
          <label class="form-label" for="eventStartDate">Start Date</label>
          <input type="datetime-local" class="form-control" id="eventStartDate" name="eventStartDate" placeholder="Start Date" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="eventEndDate">End Date</label>
          <input type="datetime-local" class="form-control" id="eventEndDate" name="eventEndDate" placeholder="End Date" />
        </div>
          <div class="mb-3 d-none">
            <label class="form-label" for="event-color">Color</label>
            <input type="color" class="form-control" id="event-color" placeholder="task color" name="color" aria-label="color" />
          </div>
        <div class="mb-3">
          <label class="switch">
            <input type="checkbox" class="switch-input allDay-switch" name="allDay" checked />
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label">All Day</span>
          </label>
        </div>
     
        <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
          <div>
            <button type="submit" class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
            <button type="reset" class="btn btn-label-secondary btn-cancel me-sm-0 me-1" data-bs-dismiss="offcanvas">Cancel</button>
          </div>
          <div><button class="btn btn-label-danger btn-delete-event d-none">Delete</button></div>
        </div>
      </form>
    </div>
   
  </div>
 
</div>
@endsection
