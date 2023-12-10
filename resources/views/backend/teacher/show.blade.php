@extends('template.layout')
@section('content')
    <div class="container emp-profile">
{{--        <form method="get">--}}
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
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Thông tin chi tiết</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profileimg" role="tab" aria-controls="profileimg" aria-selected="false">Hình ảnh chứng chỉ</a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Thao tác
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="btn btn-success m-3" onclick="window.location.href='{{ route('waiting_teacher',['id'=>$data['id']])}}'"><span class="fas fa-check me-2"></span>Phê duyệt</button>
                            
                            <form class="dropdown-item me-10" action="{{ route('delete_teacher', ['id' => $data['id'],'view' => '2']) }}" method="get">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="reason" placeholder="Nhập lý do từ chối">
                                </div>
                                <button type="submit" class="btn btn-danger">Từ chối</button>
                            </form>
                            
                            <button class="btn btn-danger m-3" onclick="window.location.href='{{ route('waiting')}}'"><span class="fas fa-times me-2"></span>Back</button>
                        </div>
                    </div>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Certificate</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$data['Certificate']}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Địa chỉ</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$data['address']}}</p>
                                </div>
                            </div>
                            <div class="row">
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
                            </div>
                        </div>

                        <div class="tab-pane fade" id="profileimg" role="tabpanel" aria-labelledby="profileimg-tab">

                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner" >
                                    @if($data['Certificate'])
                                    @foreach($data['Certificate'] as $value)

                                    <div class="carousel-item active">
                                        <img class="d-block w-100" style="height: 500px;  width: 500px;" src="{{$value}}" alt="First slide">
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
{{--        </form>--}}
    </div>
@endsection
