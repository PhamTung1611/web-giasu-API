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
                {{-- <li class="breadcrumb-item"><a href="#">Tables</a></li> --}}
            </ol>
        </nav>
        <h2 class="h4">{{$title}}</h2>
    </div>
</div>
<div class="table-settings mb-4">
    <div class="row align-items-center justify-content-between">
        <div class="col col-lg-8 col-xl-8 text-right">
            <form class="input-group w-full h-10" action="{{route('list_history_connect')}}" method="POST">
                @csrf
                <label for="class" class="form-label">Ngày bắt đầu</label>
                <input type="date" name="dateStart">
                <label for="class" class="form-label">Ngày kết thúc</label>
                <input type="date" name="dateEnd">
                <button type="submit" class="btn btn-secondary mb-3">Lọc</button>
            </form>
        </div>
    </div>
</div>
<div class="card card-body border-0 shadow table-wrapper table-responsive">

    <div id="myChart" data-data-from-php="{{ json_encode($statusData) }}" style="width:1000px; max-width:600px; height:500px;"></div>
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
@endsection