@extends('template.layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
      <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
          <li class="breadcrumb-item">
            <a href="http://127.0.0.1:8000/">
              <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
              </svg>
            </a>
          </li>
          {{-- <li class="breadcrumb-item"><a href="#">Tables</a></li> --}}
        </ol>
      </nav>
      <h2 class="h4">{{$title}}</h2>
    </div>
  </div>

<div class="card card-body border-0 shadow table-wrapper table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Số tiền</th>
                <th>Lý do</th>
                <th>Ngày</th>
            </tr>
        </thead>
        <tbody>
        <!-- Item -->
        @foreach($history as $item)
            <tr>
                <td>
                    <a href="" class="fw-bold">{{$item->coin}}</a>
                </td>
                <td>
                    <span class="fw-normal">{{$item->type}}</span>
                </td>
                <td>
                    <span class="fw-normal">{{$item->created_at}}</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
        <div class="alert alert-success" role="alert">
          @if(Session::has('success'))
          {{Session::get('success')}}
          @endif
          @if(Session::has('error'))
          {{Session::get('error')}}
          @endif
        </div>
    </div>
</div>
@endsection
