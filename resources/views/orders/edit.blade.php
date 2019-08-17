@extends('layouts.global')

@section('title')
    Edit Order
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 bg-white shadow-sm p-3">
            <h3>Edit Order</h3>
            <hr>
            <form action="{{ route('orders.update',['id' => $order->id])}}" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">

                <label for="invoice_number">Invoice Number</label>
                <input type="text" class="form-control" value="{{$order->invoice_number}}" disabled>
                <br>

                <label for="buyer">Buyer</label>
                <input type="text" class="form-control" value="{{$order->user->name}}" disabled>
                <br>

                <label for="created_at">Order Date</label>
                <input type="text" class="form-control" value="{{$order->created_at}}" disabled>
                <br>

                <label for="">Books ({{$order->totalQuantity}})</label><br>
                <ul>
                    @foreach($order->books as $book)
                        <li>{{$book->title}} <b>({{$book->pivot->quantity}})</b></li>
                    @endforeach
                </ul>

                <label for="">Total Price</label>
                <input type="text" class="form-control" value="{{$order->total_price}}" disabled>
                <br>

                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option {{$order->status == 'SUBMIT' ? 'selected' : ''}} value="SUBMIT">SUBMIT</option>
                    <option {{$order->status == 'PROCESS' ? 'selected' : ''}} value="PROCESS">PROCESS</option>
                    <option {{$order->status == 'FINISH' ? 'selected' : ''}} value="FINISH">FINISH</option>
                    <option {{$order->status == 'CANCEL' ? 'selected' : ''}} value="CANCEL">CANCEL</option>
                </select>
                <br>

                <input type="submit" value="SAVE" class="btn btn-primary btn-sm float-right">

            </form>
        </div>
    </div>
    <br>
@endsection