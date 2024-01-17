@extends('template.layout')
@section('content')
    <div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="{{ $data['avatar'] }}" alt="" />

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5>
                            {{ $data['name'] }}
                        </h5>

                        <p class="profile-head"><span>{{ $data['email'] }}</span></p>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">Thông tin cá nhân</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="history-tab" data-toggle="tab" href="#history" role="tab"
                                    aria-controls="history" aria-selected="true">Lịch sử thuê ({{$countJobs}})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="trutien-tab" data-toggle="tab" href="#trutien" role="tab"
                                    aria-controls="trutien" aria-selected="false">Biến động số dư </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="feedback-tab" data-toggle="tab" href="#feedback" role="tab"
                                    aria-controls="feedback" aria-selected="false">Đánh giá</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                    aria-controls="contact" aria-selected="false">Kết nối ({{$countConnect}})</a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-2">
                   
                    @if($data['status'] == 1)
                    <a class="dropdown-item text-danger rounded-bottom"
                            href="{{ route('delete.user', ['id' => $data['id']]) }}"
                                    onclick="return confirm('Are you sure you want to deactivate?');">
                                <span class="fas fa-trash-alt me-2"></span>Tắt kích hoạt
                        </a>
                    @else
                    <a class="dropdown-item text-sucess rounded-bottom"
                            href="{{ route('delete.user', ['id' => $data['id']]) }}"
                                    onclick="return confirm('Are you sure you want to activate?');">
                                <span class="fas fa-trash-alt me-2"></span> kích hoạt
                        </a>
                    @endif
                    
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Họ và tên</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $data['name'] }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Số dư</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $data['coin'] }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $data['email'] }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Giới tính</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $data['gender'] == 1 ? 'Nam' : 'Nữ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Phone</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $data['phone'] }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Address</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $data['address'] }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Description</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $data['description'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                            @foreach ($result as $item)
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Người Thuê</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p> {{ $item->userName}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Người Dạy</label>
                                    </div>

                                    <div class="col-md-6">
                                        <p><a href="{{route('detail_teacher', ['id' => $item->id_teacher])}}">{{ $item->teacherName }}</a></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Môn học</label>
                                    </div>

                                    <div class="col-md-6">
                                        <p>{{ $item->subject }}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Lớp học</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->class }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Mô tả</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->description }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Trạng thái</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="color: {{ $item->status === 1 ? 'green' : ($item->status == "2" ? 'red' : 'brown') }}">{{$item->status == "1" ? 'Thành công' : ($item->status == "2" ? 'Thất bại' : 'Chờ xác nhận') }}</p>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="trutien" role="tabpanel" aria-labelledby="trutien-tab">
                            @foreach ($history as $item)
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Số tiền</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->coin }}</p>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Lý do</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->type }}</p>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Ngày</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->created_at }}</p>
                                    </div>
                            </div>
                            <hr>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="feedback" role="tabpanel" aria-labelledby="feedback-tab">
                        @foreach ($dataFeedback as $item)
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Người gửi</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->sender_name }}</p>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Giáo viên</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->teacher_name }}</p>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Điểm</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->point }}</p>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nhận xét</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->description }}</p>
                                    </div>
                            </div>
                            <hr>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            @foreach ($connect as $item)
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Người thuê</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->userName }}</p>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Người dạy</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->teacherName}}</p>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Trạng thái</label>
                                </div>
                                    <div class="col-md-6">
                                        <p style="color: {{ $item->status === 1 ? 'green' : ($item->status == "2" ? 'red' : 'brown') }}">{{$item->status == "1" ? 'Thành công' : ($item->status == "2" ? 'Thất bại' : 'Chờ xác nhận') }}</p>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Xem chi tiết</label>
                                </div>
                                    <div class="col-md-6">
                                        <p><a href="{{ route('connect_show', ['id' => $item->id])}}">Chi tiết</a></p>
                                    </div>
                            </div>
                            <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
