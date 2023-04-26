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
<script src="{{asset('js/task-management.js')}}"></script>
@endsection

@section('content')

<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Clients</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$totalTask}}</h3>
              <small class="text-success">(100%)</small>
            </div>
            <small>Total Tasks</small>
          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Users List Table -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title mb-0">Search Filter</h5>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead class="border-top">
        <tr>
          <th></th>
          <th>Id</th>
          <th>Client</th>
          <th>Title</th>
          <th>Remark</th>
          <th>Cost Center</th>
          <th>Billable</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Offcanvas to add new user -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
      <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add Task</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
      <form class="add-new-user pt-0" id="addNewUserForm">
        <input type="hidden" name="id" id="user_id">
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
        {{-- <div class="mb-3">
          <label class="form-label" for="add-task-color">Color</label>
          <input type="color" class="form-control" id="add-task-color" placeholder="task color" name="color" aria-label="color" />
        </div> --}}
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
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection
