@extends('template.layout')
@section('content')
    <div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="{{ $data['avatar'] }}" style="width: 100px;" alt="" />

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
                                    aria-controls="history" aria-selected="true">Lịch sử thuê (3)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="trutien-tab" data-toggle="tab" href="#trutien" role="tab"
                                    aria-controls="trutien" aria-selected="false">Lịch sử trừ tiền</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="feedback-tab" data-toggle="tab" href="#feedback" role="tab"
                                    aria-controls="feedback" aria-selected="false">Đánh giá</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                    aria-controls="contact" aria-selected="false">Kết nối (3)</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    
                        <a class="dropdown-item text-danger rounded-bottom"
                            href="{{ route('delete.teacher', ['id' => $data['id']]) }}"
                                    onclick="return confirm('Are you sure you want to deactivate?');">
                                <span class="fas fa-trash-alt me-2"></span>Tắt kích hoạt
                        </a>
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
                                    <p>{{ $data['gender'] }}</p>
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
                                    <label>Địa chỉ</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $data['address'] }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Mô tả về gia sư</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $data['description'] }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Bằng cấp</label>
                                </div>
                                <div class="col-md-6">
                                    @foreach ($data['Certificate'] as $cert)
                                        <img src="{{$cert}}" alt="" width="100">
                                    @endforeach
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
                                        <p>
                                          <a href="{{ route('detail_user', ['id' => $item->id_user])}}"> {{ $item->userName }}</a> 
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Người Dạy</label>
                                    </div>
                                    {{-- @foreach ($result as $item) --}}
                                    <div class="col-md-6">
                                        <p><a href="{{ route('detail_teacher', ['id' => $item->id_teacher])}}"> {{ $item->teacherName }}</a> </p>
                                    </div>
                                    {{-- @endforeach --}}
                                    <div class="col-md-6">
                                        <label>Môn học</label>
                                    </div>
                                    {{-- @foreach ($result as $item) --}}
                                    <div class="col-md-6">
                                        <p>{{ $item->subject }}</p>
                                    </div>
                                    {{-- @endforeach --}}
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
                                </div>
                                <hr>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="trutien" role="tabpanel" aria-labelledby="trutien-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Số tiền</label>
                                </div>
                                @foreach ($history as $item)
                                    <div class="col-md-6">
                                        <p>{{ $item->coin }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Lý do</label>
                                </div>
                                @foreach ($history as $item)
                                    <div class="col-md-6">
                                        <p>{{ $item->type }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Ngày</label>
                                </div>
                                @foreach ($history as $item)
                                    <div class="col-md-6">
                                        <p>{{ $item->created_at }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="feedback" role="tabpanel" aria-labelledby="feedback-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Người gửi</label>
                                </div>
                                @foreach ($dataFeedback as $item)
                                    <div class="col-md-6">
                                        <p>{{ $item->idSender }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Giáo viên</label>
                                </div>
                                @foreach ($dataFeedback as $item)
                                    <div class="col-md-6">
                                        <p>{{ $item->idTeacher }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Điểm</label>
                                </div>
                                @foreach ($dataFeedback as $item)
                                    <div class="col-md-6">
                                        <p>{{ $item->point }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nhận xét</label>
                                </div>
                                @foreach ($dataFeedback as $item)
                                    <div class="col-md-6">
                                        <p>{{ $item->description }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            @foreach ($connect as $item)
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Người thuê</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->id_user }}</p>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Người dạy</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->id_teacher}}</p>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Trạng thái</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>{{ $item->status}}</p>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Xem chi tiết</label>
                                </div>
                                    <div class="col-md-6">
                                        <p>Chi tiết</p>
                                    </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
