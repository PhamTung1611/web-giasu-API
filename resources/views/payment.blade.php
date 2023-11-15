<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{url('deposit')}}" method="POST">
        @csrf
        <input type="text" name="total" placeholder="Nhap so tien can nap">
        <button type="submit" name="redirect">Nạp tiền vào tài khoản</button>
    </form>
</body>
</html>