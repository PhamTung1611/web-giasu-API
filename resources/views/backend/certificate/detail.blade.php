@extends('template.layout')
@section('content')
<style>

    #carouselExampleControls .carousel-inner img {
        width: 300px;
        max-height: 300px; /* Đặt chiều cao tối đa mong muốn */
        object-fit: cover;
    }

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
          {{-- <li class="breadcrumb-item"><a href="#">Bảng</a></li> --}}
        </ol>
      </nav>
      <h2 class="h4">{{$title}}</h2>
    </div>
    
  </div>
</div>
<div class="row mt-4">
    <div id="carouselExampleControls" class="carousel slide col-md-9" data-ride="carousel">
        <div class="carousel-inner">
            @foreach ($certificate as $key => $c )
            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                <img src="{{ $c }}" class="d-block w-100" alt="Slide {{ $key + 1 }}">
          </div>
          @endforeach
        </div>
        <div id="carouselButtons">
            <!-- Nút chuyển Slide trước và sau -->
            <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
                <span aria-hidden="true" class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
                <span aria-hidden="true" class="carousel-control-next-icon"></span>
            </button>
        </div>
      </div>
    <div class="col-md-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Thao tác
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <button class="btn btn-success m-3" onclick="window.location.href='{{ route('acceptcertificate',['id'=>$user->id]) }}'">
                    <span class="fas fa-check me-2"></span>Phê duyệt
                </button>
                <p style="color: red">
                    @if(Session::has('success'))
                    {{Session::get('success')}}
                    @endif
                    @if(Session::has('error'))
                    {{Session::get('error')}}
                    @endif
                </p>
                <form id="rejectForm" class="dropdown-item me-10" action="{{ route('refusecertificate') }}" method="get">
                    <div class="mb-3">
                        <input type="hidden" value="{{ $user->id }}" name="id">
                        <input type="text" class="form-control" name="reason" id="rejectReason" placeholder="Nhập lý do từ chối">
                        <div id="rejectReasonError" class="text-danger"></div>
                    </div>
                    <button type="submit" class="btn btn-danger" onclick="submitForm()">Từ chối</button>
                </form>

                <button class="btn btn-danger m-3" onclick="window.location.href='{{ route('allcertificate') }}'">
                    <span class="fas fa-times me-2"></span>Quay lại
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
