{!! Form::model($payment, [
    'route' => ['payments.update', $payment],
    'id' => 'form-payment',
    'method' => 'PUT',
]) !!}

<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="sale_number">{{ __('No Transaksi') }}</label>
            {!! Form::text('sale_number', $payment->sale->sale_number, ['class' => 'form-control', 'disabled' => true, 'id' => 'sale_number']) !!}
        </div>

        <div class="form-group">
            <label for="destination_bank">{{ __('Bank Tujuan') }}</label>
            {!! Form::text('destination_bank', null, ['class' => 'form-control', 'id' => 'destination_bank']) !!}
        </div>

        <div class="form-group">
            <label for="sender_bank">{{ __('Bank Pengirim') }}</label>
            {!! Form::text('sender_bank', null, ['class' => 'form-control', 'id' => 'sender_bank']) !!}
        </div>

        <div class="form-group">
            <label for="sender_account_name">{{ __('Nama Pengirim') }}</label>
            {!! Form::text('sender_account_name', null, ['class' => 'form-control', 'id' => 'sender_account_name']) !!}
        </div>

        <div class="form-group">
            <label for="sender_account_number">{{ __('No Rekening Pengirim') }}</label>
            {!! Form::text('sender_account_number', null, ['class' => 'form-control', 'id' => 'sender_account_number']) !!}
        </div>

        <div class="form-group">
            <label for="date">{{ __('Tanggal Pembayaran') }}</label>
            {!! Form::date('date', \Carbon\Carbon::parse($payment->date)->format('Y-m-d'), ['class' => 'form-control', 'id' => 'date']) !!}
        </div>
    </div>
</div>

{!! Form::close() !!}
