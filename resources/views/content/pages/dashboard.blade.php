@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

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
<script src="{{asset('js/user-management.js')}}"></script>
@endsection


@section('content')

<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-4">
    <a href="{{route('clients.index')}}">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Clients</span>
              <div class="d-flex align-items-end mt-2">
                <h3 class="mb-0 me-2">{{$totalClient}}</h3>
                <small class="text-success">(100%)</small>
              </div>
              <small>Total Clients</small>
            </div>
            <span class="badge bg-label-primary rounded p-2">
              <i class="ti ti-user ti-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-sm-6 col-xl-4">
  <a href="{{route('tasks.index')}}">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Tasks</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$totalTask}}</h3>
              <small class="text-success">(100%)</small>
            </div>
            <small>Total Tasks</small>
          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-checklist ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </a>
  </div>
  <div class="col-sm-6 col-xl-4">
    <a href="{{route('timesheet.index')}}">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Events</span>
              <div class="d-flex align-items-end mt-2">
                <h3 class="mb-0 me-2">{{$totalEvent}}</h3>
                <small class="text-success">(100%)</small>
              </div>
              <small>Total Event</small>
            </div>
            <span class="badge bg-label-primary rounded p-2">
              <i class="ti ti-calendar-event ti-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>


@if (auth()->user()->role === 'admin')

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
          <th>Name</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>

</div>
@endif
@endsection
