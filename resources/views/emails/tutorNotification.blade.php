@component('mail::message')
# Xin chào,

Dưới đây là mã code giúp bạn có thể lấy lại mật khẩu.

@component('mail::panel')
<h3 style="color: red;">Mã code: <span style="color: blue"> {{ $token }}</span></h3>
@endcomponent

@endcomponent
