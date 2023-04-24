@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')

<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-4">
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
  </div>
  <div class="col-sm-6 col-xl-4">
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
  </div>
  <div class="col-sm-6 col-xl-4">
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
  </div>
</div>
@endsection
