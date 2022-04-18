<h3>Halo, {{ $name }}</h3>

<p>Pesanan anda dengan nomor <strong>{{ $order_number }}</strong> hampir jatuh tempo. Mohon segera melakukan
    pembayaran melalui <a href="{{ env('APP_URL') }}/payment/{{ $order_id }}/create">link berikut</a></p>
<br>
<p>Terima Kasih</p>
