@extends('layouts/layoutMaster')

@section('title', 'Task Management')

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
    <h5 class="card-title mb-0">Add Task To a User</h5>
  </div>
  <div class="card-datatable table-responsive p-2">
     <!-- Offcanvas to add new user -->
     <div class="offcanvas-header pb-4">
      <h5 id="offcanvasAddUserLabel" class="offcanvas-title"></h5>
      <a href="/event-add/{{$userId}}/admin" type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Add Events to a User</a>
    </div>
  
    
    <div class="offcanvas-body mx-0 flex-grow-0">
      @if(session('created'))
          <div class="alert alert-success">
            Task Created successfully
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
      <form method="POST" action="{{route('tasks.storetaskadmin')}}" class="add-new-user pt-0" id="addNewUserForm">
        @csrf
        <input type="hidden" name="id" id="user_id">
        <div class="mb-3">
          <label class="form-label" for="add-task-user">User</label>
          <select id="add-task-user" class=" form-select" name="user">
            @foreach ($users as $user)
            <option {{$userId == $user->id ? 'selected' : ''}} value="{{$user->id}}">{{$user->email}} - {{$user->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-task-title">Title</label>
          <input type="text" class="form-control" id="add-task-title" placeholder="task title" name="title" aria-label="title" />
        </div>
      
        <div class="mb-3">
          <label class="form-label" for="add-task-client">Client</label>
          <select id="add-task-client" class="select2 form-select" name="client">
            <option value="" selected>Select</option>
            @foreach ($clients as $client)
            <option value="{{$client->id}}">{{$client->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-task-cost-center">Remark</label>
          <textarea  class="form-control" id="add-task-remark" placeholder="task remark" name="remark" aria-label="remark" ></textarea>

        </div>
        {{-- <div class="mb-3">
          <label class="form-label" for="add-task-description">Description</label>
          <textarea name="" id="add-task-description" class="form-control" cols="30" rows="10" name="description"  placeholder="task description..." aria-label="description"></textarea>
        </div> --}}
        <div class="mb-3">
          <label class="form-label" for="add-task-color">Color</label>
          <input type="color" class="form-control" id="add-task-color" placeholder="task color" name="color" aria-label="color" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-task-cost-center">Cost Center</label>
          <input type="text" class="form-control" id="add-task-cost-center" placeholder="task cost center" name="costcenter" aria-label="cost center" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-task-cost-center">Billable</label>
          <label class="switch switch-square">
            <input type="checkbox" class="switch-input" id="add-task-billable" name="billable" />
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
          </label>
        </div>
       
        
    
        
        
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
        <a href="/" type="reset" class="btn btn-label-secondary" >Cancel</a>
      </form>
    </div>
   
  </div>
 
</div>
@endsection
