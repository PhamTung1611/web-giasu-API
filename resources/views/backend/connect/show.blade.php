@extends('template.layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
  <div class="d-block mb-4 mb-md-0">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
      <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
        <li class="breadcrumb-item">
          <a href="http://127.0.0.1:8000/">
            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
              </path>
            </svg>
          </a>
        </li>
      </ol>
    </nav>
    <h2 class="h4">{{$title}}</h2>
  </div>
  <div class="btn-toolbar mb-2 mb-md-0">
  </div>
</div>

<div class="card card-body border-0 shadow table-wrapper table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>ID JOB</th>
        <th>Username</th>
        <th>TeacherName</th>
        <th>Subject</th>
        <th>Class</th>
        <th>Note User</th>
        <th>Note Teacher</th>
        <th>Confirm User</th>
        <th>Confirm Teacher</th>
        <th>Status</th>
        <th>Ngày tạo</th>
      </tr>
    </thead>
    <tbody>
      <!-- Item -->
      @foreach($connect as $item)
      <tr>
        <td>
          <span class="fw-normal">{{$item->id_job}}</span>
        </td>
        <td>
          <span class="fw-normal"><a href="">{{$item->userName}}</a></span>
        </td>
        <td>
          <span class="fw-normal"><a href="">{{$item->teacherName}}</a></span>
        </td>
        <td>
          <span class="fw-normal">{{$item->subjectName}}</span>
        </td>
        <td>
          <span class="fw-normal">{{$item->className}}</span>
        </td>
        <td>
          <span class="fw-normal">{{$item->note_user}}</span>
        </td>
        <td>
          <span class="fw-normal">{{$item->note_teacher }}</span>
        </td>
        <td>
        <span class="fw-normal" style="color: {{ $item->confirm_user === 1 ? 'green' : 'brown' }}">{{$item->confirm_user == "1" ? 'Xác nhận kết nối' : 'Chưa xác nhận kết nối'}}</span>
        </td>
        <td>
          <span class="fw-normal" style="color: {{ $item->confirm_teacher === 1 ? 'green' : 'brown' }}">{{$item->confirm_teacher == "1" ? 'Xác nhận kết nối' : 'Chưa xác nhận kết nối'}}</span>
        </td>
        <td>
          <span class="fw-normal" style="color: {{ $item->status === 1 ? 'green' : ($item->status == "2" ? 'red' : 'brown') }}">{{$item->status == "1" ? 'Thành công' : ($item->status == "2" ? 'Thất bại' : 'Chờ xác nhận') }}</span>
        </td>
        <td>
          <span class="fw-normal">{{$item->created_at}}</span>
        </td>
        <!-- <td>
          <div class="btn-group">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="icon icon-sm">
                <span class="fas fa-ellipsis-h icon-dark"></span>
              </span>
              <span>
                views
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.005 11.995v.01m0-4.01v.01m0 7.99v.01" />
                </svg>
              </span>
            </button>
            <div class="dropdown-menu py-0">
              <a class="dropdown-item" href="{{ route('connect_show', ['id' => $item->id])}}"><span class="fas fa-edit me-2"></span>Xem chi tiết</a>
              <a class="dropdown-item text-danger rounded-bottom" href="{{ route('delete_connect', ['id' => $item->id])}}" onclick="return confirm('Are you sure you want to delete?');"><span class="fas fa-trash-alt me-2"></span>Remove</a>
            </div>
          </div>
        </td> -->

      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
  </div>
</div>
@endsection