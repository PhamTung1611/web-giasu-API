@extends('template.layout')
@section('content')
<style>

   
</style>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
      <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
          <li class="breadcrumb-item">
            <a href="#">
              <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
              </svg>
            </a>
          </li>
        </ol>
      </nav>
      <h2 class="h4">{{$title}}</h2>
    </div>

  </div>
</div>
<div class="row mt-4">
  <form action="{{ route('acceptcertificate',['id'=>$user->id]) }}" enctype="multipart/form-data" method="post">
      @csrf
      <div>
        <div class="d-flex flex-row gap-4">
            @foreach ($certificate as $key => $c )
                <div class="d-flex flex-column align-content-center gap-2">
                    <img src="{{ $c }}" class="d-block img-certificate" alt="Slide {{ $key + 1 }}">
                    <input type="checkbox"  name="Certificate_public[]" value="{{$c}}"/>
                </div>
          @endforeach
        </div>
      </div>

      <div class="col-md-3 mt-4">
        <!-- Bỏ dropdown và nút "Thao tác" -->
        
        <!-- Nút "Phê duyệt" và form từ chối được đặt trực tiếp sau container của col-md-3 -->
        <button class="btn btn-success mb-3" name="action" value="dongy">
            <span class="fas fa-check me-2"></span>Phê duyệt
        </button>
        <div class="mb-3">
            <input type="text" class="form-control" name="reason" id="rejectReason" placeholder="Nhập lý do từ chối">
            <div id="rejectReasonError" class="text-danger"></div>
        </div>
        <button type="submit" class="btn btn-danger" name="action" value="tuchoi">Từ chối</button>
        
        <!-- Nút "Quay lại" được đặt trên cùng một hàng -->
        <button class="btn btn-danger m-3" onclick="window.location.href='{{ route('allcertificate') }}'">
            <span class="fas fa-times me-2"></span>Quay lại
@endsection
