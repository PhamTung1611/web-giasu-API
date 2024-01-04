@extends('template.layout')
@section('content')
<div class="col-md-2">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Thao tác
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <button class="btn btn-success m-3" onclick="window.location.href='{{ route('waiting_teacher',['id'=>$data['id']])}}'"><span class="fas fa-check me-2"></span>Phê duyệt</button>
            <p style="color: red">
                @if(Session::has('success'))
                {{Session::get('success')}}
                @endif
                @if(Session::has('error'))
                {{Session::get('error')}}
                @endif</p>
            <form id="rejectForm" class="dropdown-item me-10" action="{{ route('delete_teacher', ['id' => $data['id'],'view' => '2']) }}" method="get">
                <div class="mb-3">
                    <input type="text" class="form-control" name="reason" id="rejectReason" placeholder="Nhập lý do từ chối">
                    <div id="rejectReasonError" class="text-danger"></div>
                </div>
                <button type="button" class="btn btn-danger" onclick="submitForm()">Từ chối</button>
            </form>

            <button class="btn btn-danger m-3" onclick="window.location.href='{{ route('waiting')}}'"><span class="fas fa-times me-2"></span>Quay lại</button>
        </div>
    </div>
</div>
<div class="carousel slide carousel-fade col-md-10" id="carouselBasicExample" data-mdb-ride="carousel">
    <!-- Indicators -->
    <div class="carousel-indicators">
        @foreach ($certificate as $key => $c )
            <button type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}" aria-current="{{ $key === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
        @endforeach
    </div>
    <!-- Inner -->
    <div class="carousel-inner">
        <!-- Single item -->
        @foreach ($certificate as $key => $c )
            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                <img src="{{ $c }}" class="d-block w-100" style="max-width: 1000px;" alt="Certificate Image">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Slide {{ $key + 1 }} Label</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Inner -->
    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
@endsection
