@extends('template.layout')
@section('content')
<main class="">
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <a href="http://127.0.0.1:8000/teacher">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                    <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="h5">Gia Sư</h2>
                                    <h3 class="fw-extrabold mb-1">345,678</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h6 text-gray-400 mb-0">Gia sư</h2>
                                    <h3 class="fw-extrabold mb-2">{{$countTeacher}} người</h3>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <a href="http://127.0.0.1:8000/teacher/waiting">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                    <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                        </path>
                                    </svg>
                                </div>

                                <div class="d-sm-none">
                                    <h2 class="fw-extrabold h5"> Bounce Rate</h2>
                                    <h3 class="mb-1">50.88%</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h6 text-gray-400 mb-0">Số gia sư chờ phê duyệt</h2>
                                    <h3 class="fw-extrabold mb-2">{{$countTeacherWait}} người</h3>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <a href="http://127.0.0.1:8000/ctv">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                    <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 0a5 5 0 0 0-5 5v6a5 5 0 0 0 10 0V5a5 5 0 0 0-5-5zm0 18h4v2h-4v-2zM4 11a2 2 0 0 1-2-2V6a2 2 0 1 1 4 0v3a2 2 0 0 1-2 2zm12 0a2 2 0 0 1-2-2V6a2 2 0 1 1 4 0v3a2 2 0 0 1-2 2z" />
                                    </svg>

                                </div>
                                <div class="d-sm-none">
                                    <h2 class="h5">Gia Sư</h2>
                                    <h3 class="fw-extrabold mb-1">345,678</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h6 text-gray-400 mb-0">Cộng tác viên</h2>
                                    <h3 class="fw-extrabold mb-2">{{$countCollaborators}} người</h3>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <a href="http://127.0.0.1:8000/user">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                    <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="fw-extrabold h5">Revenue</h2>
                                    <h3 class="mb-1">$43,594</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h6 text-gray-400 mb-0">Phụ Huynh</h2>
                                    <h3 class="fw-extrabold mb-2">{{$countUser}} người</h3>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <a href="http://127.0.0.1:8000/history-admin">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                    <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="18" height="18" rx="2" ry="2" transform="translate(1 1)" stroke="#000" stroke-width="2" fill="none"></rect>
                                        <line x1="2" y1="6" x2="18" y2="6" stroke="#000" stroke-width="2"></line>
                                        <line x1="2" y1="12" x2="18" y2="12" stroke="#000" stroke-width="2"></line>
                                        <circle cx="6" cy="10" r="2" fill="#000"></circle>
                                        <circle cx="14" cy="10" r="2" fill="#000"></circle>
                                    </svg>
                                </div>

                                <div class="d-sm-none">
                                    <h2 class="fw-extrabold h5">Revenue</h2>
                                    <h3 class="mb-1">$43,594</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h6 text-gray-400 mb-0">Doanh thu hiện tại</h2>
                                    <h3 class="fw-extrabold mb-2">{{$money}} VNĐ</h3>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <a href="{{route('search_connect')}}">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                    <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 2C14.41 2 18 5.59 18 10s-3.59 8-8 8-8-3.59-8-8 3.59-8 8-8zm0-2C4.48 0 0 4.48 0 10s4.48 10 10 10 10-4.48 10-10S15.52 0 10 0z" />
                                        <circle cx="7" cy="10" r="2" fill="#000" />
                                        <circle cx="13" cy="10" r="2" fill="#000" />
                                    </svg>

                                </div>

                                <div class="d-sm-none">
                                    <h2 class="fw-extrabold h5">Revenue</h2>
                                    <h3 class="mb-1">$43,594</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h6 text-gray-400 mb-0">Kết nối thành công</h2>
                                    <h3 class="fw-extrabold mb-2">{{$countConnect}} trường hợp</h3>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="row">
                <div class="col-12 col-xxl-9 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                            <h2 class="fs-5 fw-bold mb-0">Top 4 gia sư được đánh giá cao hiện tại</h2>
                            <a href="http://127.0.0.1:8000/feedback" class="btn btn-sm btn-primary">Xem tất cả</a>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush list my--3">
                                @foreach($results as $item)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <a href="{{ route('detail_teacher', ['id' => $item->id])}}" class="avatar">
                                                <img class="rounded" alt="Image placeholder" src="{{$item->avatar?''.Storage::url($item->avatar):''}}">
                                            </a>
                                        </div>
                                        <div class="col-auto ms--2">
                                            <h4 class="h6 mb-0">
                                                <a href="{{ route('detail_teacher', ['id' => $item->id])}}">{{$item->name}}</a>
                                            </h4>
                                        </div>
                                        <div class="col text-end">
                                            <a href="#" class="btn btn-sm btn-secondary d-inline-flex align-items-center">
                                                {{$item->avg_point}}
                                                <svg class="icon icon-xxs me-2" fill="yellow" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M10 1l1.54 4.71h4.95l-3.82 2.97L15.46 14l-4.72-1.65L6 14l1.23-5.32-3.82-2.97h4.95L10 1zm0 2.57L8.41 7.2H3.64l3 2.32-1.15 4.98L10 11.65l4.5 2.86-1.15-4.98 3-2.32H11.6L10 3.57z" clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xxl-9 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                            <h2 class="fs-5 fw-bold mb-0">Top 4 gia sư được thuê nhiều hiện tại</h2>
                            <a href="{{route('rent')}}" class="btn btn-sm btn-primary">Xem tất cả</a>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush list my--3">
                                @foreach($topTeachersInfo as $item)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <a href="{{ route('detail_teacher', ['id' => $item->user_id])}}" class="avatar">
                                                <img class="rounded" alt="Image placeholder" src="{{$item->user_avatar ? '' .Storage::url($item->user_avatar):''}}">
                                            </a>
                                        </div>
                                        <div class="col-auto ms--2">
                                            <h4 class="h6 mb-0">
                                                <a href="{{ route('detail_teacher', ['id' => $item->user_id])}}">{{$item->user_name}}</a>
                                            </h4>
                                        </div>
                                        <div class="col text-end">
                                            <a href="#" class="btn btn-sm btn-secondary d-inline-flex align-items-center">
                                                {{$item->teacher_count}} lượt thuê
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xxl-9 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                            <h2 class="fs-5 fw-bold mb-0">Tỉ lệ kết nối người dùng với gia sư</h2>
                            <a href="{{ route('search_connect') }}" class="btn btn-sm btn-primary">Xem tất cả</a>
                        </div>
                        <div class="card-body">
                            <div id="myChart" data-data-from-php="{{ json_encode($statusData) }}" style="width:100%; max-width:600px; height:500px;"></div>


                            <script>
                                google.charts.load('current', {
                                    'packages': ['corechart']
                                });
                                google.charts.setOnLoadCallback(drawChart);

                                function drawChart() {
                                    // Lấy dữ liệu từ blade và chuyển thành định dạng mà Google Charts hiểu
                                    var dataFromPHP = document.getElementById('myChart').dataset.dataFromPhp;
                                    if (!dataFromPHP) {
                                        console.error('Không có dữ liệu từ PHP.');
                                        return;
                                    }

                                    // Chuyển đổi dữ liệu từ chuỗi JSON thành mảng JavaScript
                                    var parsedData;
                                    try {
                                        parsedData = JSON.parse(dataFromPHP);
                                    } catch (error) {
                                        console.error('Lỗi khi parse dữ liệu từ PHP:', error);
                                        return;
                                    }

                                    // Kiểm tra xem dữ liệu từ PHP có đúng định dạng không
                                    if (!Array.isArray(parsedData) || parsedData.length === 0 || !('status' in parsedData[0] && 'percentage' in parsedData[0])) {
                                        console.error('Dữ liệu từ PHP không đúng định dạng.');
                                        return;
                                    }

                                    // Set Data
                                    var data = new google.visualization.DataTable();
                                    data.addColumn('string', 'Status');
                                    data.addColumn('number', 'Percentage');
                                    parsedData.forEach(item => {
                                        data.addRow([String(item.status), item.percentage]);
                                    });

                                    // Set Options
                                    var options = {
                                        title: 'Tỉ lệ giới thiệu việc làm cho gia sư',
                                        is3D: true
                                    };

                                    // Draw
                                    var chart = new google.visualization.PieChart(document.getElementById('myChart'));
                                    chart.draw(data, options);
                                }
                            </script>

                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="col-12 px-0 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                        <div class="d-block ms-auto" id="myChartSubjects" style="width:100%; max-width:10000px; height:500px;"></div>
                        <div id="myElementSubjects" data-data-from-php="{{ json_encode($mostHiredSubjects) }}"></div>

                        <script>
                            google.charts.load('current', {
                                'packages': ['corechart']
                            });
                            google.charts.setOnLoadCallback(drawChartSubjects);

                            function drawChartSubjects() {
                                var dataFromPHP = document.getElementById('myElementSubjects').dataset.dataFromPhp;

                                // Kiểm tra xem dữ liệu từ PHP có tồn tại không
                                if (!dataFromPHP) {
                                    console.error('Không có dữ liệu từ PHP.');
                                    return;
                                }

                                // Chuyển đổi dữ liệu từ chuỗi JSON thành mảng JavaScript
                                var parsedData;
                                try {
                                    parsedData = JSON.parse(dataFromPHP);
                                } catch (error) {
                                    console.error('Lỗi khi parse dữ liệu từ PHP:', error);
                                    return;
                                }

                                // Kiểm tra xem dữ liệu từ PHP có đúng định dạng không
                                if (!Array.isArray(parsedData) || parsedData.length === 0 || !('name' in parsedData[0] && 'hire_count' in parsedData[0])) {
                                    console.error('Dữ liệu từ PHP không đúng định dạng.');
                                    return;
                                }

                                // Chuyển đổi dữ liệu thành định dạng phù hợp
                                var dataArray = [
                                    ['name', 'Số lần thuê']
                                ];
                                parsedData.forEach(item => {
                                    dataArray.push([item.name, item.hire_count]);
                                });

                                // Set Data
                                const data = google.visualization.arrayToDataTable(dataArray);

                                // Set Options
                                const options = {
                                    title: 'Số môn học được thuê nhiều hiện tại'
                                };

                                // Draw
                                const chart = new google.visualization.BarChart(document.getElementById('myChartSubjects'));
                                chart.draw(data, options);
                            }
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-12 px-0 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                        <div class="d-block ms-auto" id="myChartClasses" style="width:100%; max-width:10000px; height:500px;"></div>
                        <div id="myElementClasses" data-data-from-php="{{ json_encode($mostHiredClass) }}"></div>

                        <script>
                            google.charts.load('current', {
                                'packages': ['corechart']
                            });
                            google.charts.setOnLoadCallback(drawChartClasses);

                            function drawChartClasses() {
                                var dataFromPHP = document.getElementById('myElementClasses').dataset.dataFromPhp;
                                // Kiểm tra xem dữ liệu từ PHP có tồn tại không
                                if (!dataFromPHP) {
                                    console.error('Không có dữ liệu từ PHP.');
                                    return;
                                }

                                // Chuyển đổi dữ liệu từ chuỗi JSON thành mảng JavaScript
                                var parsedData;
                                try {
                                    parsedData = JSON.parse(dataFromPHP);
                                } catch (error) {
                                    console.error('Lỗi khi parse dữ liệu từ PHP:', error);
                                    return;
                                }

                                // Kiểm tra xem dữ liệu từ PHP có đúng định dạng không
                                if (!Array.isArray(parsedData) || parsedData.length === 0 || !('class' in parsedData[0] && 'hire_count' in parsedData[0])) {
                                    console.error('Dữ liệu từ PHP không đúng định dạng.');
                                    return;
                                }

                                // Chuyển đổi dữ liệu thành định dạng phù hợp
                                var dataArray = [
                                    ['class', 'Số lần thuê']
                                ];
                                parsedData.forEach(item => {
                                    dataArray.push([item.class, item.hire_count]);
                                });

                                // Set Data
                                const data = google.visualization.arrayToDataTable(dataArray);

                                // Set Options
                                const options = {
                                    title: 'Lớp học được thuê nhiều hiện tại'
                                };

                                // Draw
                                const chart = new google.visualization.BarChart(document.getElementById('myChartClasses'));
                                chart.draw(data, options);
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="theme-settings card bg-gray-800 pt-2 collapse" id="theme-settings">
        <div class="card-body bg-gray-800 text-white pt-4">
            <button type="button" class="btn-close theme-settings-close" aria-label="Close" data-bs-toggle="collapse" href="#theme-settings" role="button" aria-expanded="false" aria-controls="theme-settings"></button>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="m-0 mb-1 me-4 fs-7">Open source <span role="img" aria-label="gratitude">💛</span>
                </p>
                <a class="github-button" href="https://github.com/themesberg/volt-bootstrap-5-dashboard" data-color-scheme="no-preference: dark; light: light; dark: light;" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star themesberg/volt-bootstrap-5-dashboard on GitHub">Star</a>
            </div>
            <a href="https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard" target="_blank" class="btn btn-secondary d-inline-flex align-items-center justify-content-center mb-3 w-100">
                Download
                <svg class="icon icon-xs ms-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z" clip-rule="evenodd"></path>
                </svg>
            </a>
            <p class="fs-7 text-gray-300 text-center">Available in the following technologies:</p>
            <div class="d-flex justify-content-center">
                <a class="me-3" href="https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard" target="_blank">
                    <img src="../../assets/img/technologies/bootstrap-5-logo.svg" class="image image-xs">
                </a>
                <a href="https://demo.themesberg.com/volt-react-dashboard/#/" target="_blank">
                    <img src="../../assets/img/technologies/react-logo.svg" class="image image-xs">
                </a>
            </div>
        </div>
    </div>
</main>
@endsection