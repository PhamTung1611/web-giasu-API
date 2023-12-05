@extends('template.layout')
@section('content')
    <div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="{{$data['avatar']}}" alt="" />

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5>
                           {{$data['name']}}
                        </h5>

                        <p class="profile-head"><span>{{$data['email']}}</span></p>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Thông tin cá nhân</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true">Lịch sử thuê</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="trutien-tab" data-toggle="tab" href="#trutien" role="tab" aria-controls="trutien" aria-selected="false">Lịch sử trừ tiền</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="feedback-tab" data-toggle="tab" href="#feedback" role="tab" aria-controls="feedback" aria-selected="false">Đánh giá</a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <a class="dropdown-item text-danger rounded-bottom" href="{{ route('delete_teacher', ['id' => $data['id'],'view'=>'2'])}}" onclick="return confirm('Are you sure you want to refuse?');"><span class="fas fa-trash-alt me-2"></span>Từ chối</a>
                    <a class="dropdown-item text-danger rounded-bottom" href="{{ route('waiting')}}" ><span class="fas fa-trash-alt me-2">Back</span></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">

                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Họ và tên</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$data['name']}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$data['email']}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Giới tính</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$data['gender']}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Phone</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$data['phone']}}</p>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Người gửi</label>
                                </div>
                                <div class="col-md-6">
                                    <p>demo</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Gia sư</label>
                                </div>
                                <div class="col-md-6">
                                    <p>gia sư 1</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Số sao</label>
                                </div>
                                <div class="col-md-6">
                                    <p>2</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nội dung</label>
                                </div>
                                <div class="col-md-6">
                                    {{-- <p>{{$data['phone']}}</p> --}}
                                    <p>jqk</p>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="trutien" role="tabpanel" aria-labelledby="trutien-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Số tiền</label>
                                </div>
                                <div class="col-md-6">
                                    <p>5000</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Lý do</label>
                                </div>
                                <div class="col-md-6">
                                    <p>Lý do</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Ngày</label>
                                </div>
                                <div class="col-md-6">
                                    <p>ngày</p>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <label>Trường đang học</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$data['school']}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Hiện tại đang là</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$data['current_role']}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nhận dạy</label>
                                </div>
                                <div class="col-md-6">

                                    @foreach($data['class_id'] as $value)
                                    <p>{{$value}}</p>
                                    @endforeach

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Dạy môn</label>
                                </div>
                                <div class="col-md-6">
                                    @foreach($data['subject'] as $value)
                                        <p>{{$value}}</p>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Mức lương mong muốn</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$data['salary_id']}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Kinh nghiệm</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$data['exp']}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Thời gian dạy</label>
                                </div>
                                <div class="col-md-6">
                                    @foreach($data['time_tutor_id'] as $value)
                                        <p>{{$value}}</p>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Khu vực dạy</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$data['DistrictID']}}</p>
                                </div>
                            </div> --}}
                        </div>

                        <div class="tab-pane fade" id="feedback" role="tabpanel" aria-labelledby="feedback-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Người gửi</label>
                                </div>
                                <div class="col-md-6">
                                    <p>Người gửi 1</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Giáo viên</label>
                                </div>
                                <div class="col-md-6">
                                    <p>Sơn</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Điểm</label>
                                </div>
                                <div class="col-md-6">
                                    <p>10</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nhận xét</label>
                                </div>
                                <div class="col-md-6">
                                    <p>hay</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
