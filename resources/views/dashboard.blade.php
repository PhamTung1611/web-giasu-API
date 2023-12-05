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
                                        <path d="M10 0a5 5 0 0 0-5 5v6a5 5 0 0 0 10 0V5a5 5 0 0 0-5-5zm0 18h4v2h-4v-2zM4 11a2 2 0 0 1-2-2V6a2 2 0 1 1 4 0v3a2 2 0 0 1-2 2zm12 0a2 2 0 0 1-2-2V6a2 2 0 1 1 4 0v3a2 2 0 0 1-2 2z" />
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
    </div>
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="row">
                <div class="col-12 col-xxl-9 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                            <h2 class="fs-5 fw-bold mb-0">Top 4 gia sư được đánh giá cao</h2>
                            <a href="http://127.0.0.1:8000/feedback" class="btn btn-sm btn-primary">Xem tất cả</a>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush list my--3">
                                @foreach($results as $item)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <a href="#" class="avatar">
                                                <img class="rounded" alt="Image placeholder" src="{{$item->avatar?''.Storage::url($item->avatar):''}}">
                                            </a>
                                        </div>
                                        <div class="col-auto ms--2">
                                            <h4 class="h6 mb-0">
                                                <a href="#">{{$item->name}}</a>
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
                <div class="col-12 col-xxl-6 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                            <h2 class="fs-5 fw-bold mb-0">Top 4 gia sư được thuê nhiều</h2>
                            <a href="{{route('rent')}}" class="btn btn-sm btn-primary">Xem tất cả</a>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush list my--3">
                                @foreach($topTeachersInfo as $item)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <a href="#" class="avatar">
                                                <img class="rounded" alt="Image placeholder" src="{{$item->user_avatar ? '' .Storage::url($item->user_avatar):''}}">
                                            </a>
                                        </div>
                                        <div class="col-auto ms--2">
                                            <h4 class="h6 mb-0">
                                                <a href="#">{{$item->user_name}}</a>
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
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="col-12 px-0 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                        <div class="d-block ms-auto" id="myChart" style="width:100%; max-width:10000px; height:500px;"></div>
                        <div id="myElement" data-data-from-php="{{ json_encode($mostHiredSubjects) }}"></div>

                        <script>
                            google.charts.load('current', {
                                'packages': ['corechart']
                            });
                            google.charts.setOnLoadCallback(drawChart);
                            // Trong JavaScript
                            var dataFromPHP = document.getElementById('myElement').dataset.dataFromPhp;
                            console.log(JSON.parse(dataFromPHP));

                            function drawChart() {
                                var dataFromPHP = document.getElementById('myElement').dataset.dataFromPhp;

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
                                    title: 'Số môn học được thuê nhiều'
                                };

                                // Draw
                                const chart = new google.visualization.BarChart(document.getElementById('myChart'));
                                chart.draw(data, options);

                            }
                        </script>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 px-0 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between border-bottom pb-3">
                            <div>
                                <div class="h6 mb-0 d-flex align-items-center">
                                    <svg class="icon icon-xs text-gray-500 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"></path>
                                    </svg>
                                    Global Rank
                                </div>
                            </div>
                            <div>
                                <a href="#" class="d-flex align-items-center fw-bold">
                                    #755
                                    <svg class="icon icon-xs text-gray-500 ms-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                            <div>
                                <div class="h6 mb-0 d-flex align-items-center">
                                    <svg class="icon icon-xs text-gray-500 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Country Rank
                                </div>
                                <div class="small card-stats">
                                    United States
                                    <svg class="icon icon-xs text-success" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <a href="#" class="d-flex align-items-center fw-bold">
                                    #32
                                    <svg class="icon icon-xs text-gray-500 ms-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pt-3">
                            <div>
                                <div class="h6 mb-0 d-flex align-items-center">
                                    <svg class="icon icon-xs text-gray-500 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1H8a3 3 0 00-3 3v1.5a1.5 1.5 0 01-3 0V6z" clip-rule="evenodd"></path>
                                        <path d="M6 12a2 2 0 012-2h8a2 2 0 012 2v2a2 2 0 01-2 2H2h2a2 2 0 002-2v-2z">
                                        </path>
                                    </svg>
                                    Category Rank
                                </div>
                                <div class="small card-stats">
                                    Computers Electronics > Technology
                                    <svg class="icon icon-xs text-success" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <a href="#" class="d-flex align-items-center fw-bold">
                                    #11
                                    <svg class="icon icon-xs text-gray-500 ms-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-12 px-0">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h2 class="fs-5 fw-bold mb-1">Acquisition</h2>
                        <p>Tells you where your visitors originated from, such as search engines, social networks or
                            website referrals.</p>
                        <div class="d-block">
                            <div class="d-flex align-items-center me-5">
                                <div class="icon-shape icon-sm icon-shape-danger rounded me-3">
                                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="d-block">
                                    <label class="mb-0">Bounce Rate</label>
                                    <h4 class="mb-0">33.50%</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center pt-3">
                                <div class="icon-shape icon-sm icon-shape-purple rounded me-3">
                                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="d-block">
                                    <label class="mb-0">Sessions</label>
                                    <h4 class="mb-0">9,567</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
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