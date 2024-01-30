@extends('layout.layout')

@section('head')
<title>Dashboard</title>
<style>
  i.mdi.mdi-18 {
    font-size: 18px;
  }

  i.mdi.mdi-24 {
    font-size: 24px;
  }

  i.mdi.mdi-36 {
    font-size: 36px;
  }

  .mdi-48px.mdi-set,
  .mdi-48px.mdi:before {
    font-size: 80px;
  }

  .card-body {
    padding-bottom: 0px !important;
    padding-left: 32px !important;
    padding-right: 32px !important;
    padding-top: 15px !important;
  }

  .row {
    align-items: center;
  }

  .card-footer {
    padding-top: 0px !important;
  }

  p.card-category {
    font-size: 18px;
    color: #ABB2B9;
    font-weight: lighter !important;
    margin-bottom: 0px !important;
    display: flex;
    justify-content: end;
    padding-top: 15px !important;
  }

  p.card-title {
    font-size: 45px;
    font-weight: 600;
    margin-bottom: 0px !important;
    display: flex;
    justify-content: end;
  }

  .col-7.col-md-8 {
    display: flex;
    justify-content: end;
  }

  div.stats {
    font-weight: lighter;
  }

  .stats i {
    margin-right: 8px;
  }
</style>

@endsection


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center">
    <h4 class="fw-bold py-3 mb-4">Dashboard</h4>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="fa-solid fa-users fa-4x" style="color: #58D68D;"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category">Users</p>
                <p class="card-title">{{$userCount}}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats">
            <i class="fa fa-refresh"></i> Update Now
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="fa-solid fa-coins fa-4x" style="color: #F4D03F;"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category">Tithes</p>
                <p class="card-title">{{$tithes}}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats">
            <i class="fa fa-calendar-o"></i> Last day
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="fa-solid fa-heart-pulse fa-4x" style="color: #EC7063;"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category">New Members</p>
                <p class="card-title">23</p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats">
            <i class="fa fa-clock-o"></i> In the last hour
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-body ">
          <div class="row">
            <div class="col-5 col-md-4">
              <div class="icon-big text-center icon-warning">
                <i class="fa-regular fa-calendar-check fa-4x" style="color: #5DADE2;"></i>
              </div>
            </div>
            <div class="col-7 col-md-8">
              <div class="numbers">
                <p class="card-category">Events</p>
                <p class="card-title">{{ $events }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer ">
          <hr>
          <div class="stats">
            <i class="fa fa-refresh"></i> Update now
          </div>
        </div>
      </div>
    </div>
  </div>


</div>
@endsection