@extends('layouts.global')

@section('title')
    Orders
@endsection

@section('content')
    <div class="row bg-white shadow-sm p-3">
        <div class="col-md-12">
            <h3>Orders</h3>
            <hr>
            @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
            @endif
            <form action="{{route('orders.index')}}">
                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <input type="text" value="{{Request::get('key')}}" name="key" class="form-control" placeholder="Search Orders">
                    </div>
                    <div class="col-md-2">
                        <select name="status" id="status" class="form-control">
                            <option value="">Any</option>
                            <option {{Request::get('status') == 'SUBMIT' ? 'selected' : ''}} value="SUBMIT">SUBMIT</option>
                            <option {{Request::get('status') == 'PROCESS' ? 'selected' : ''}} value="PROCESS">PROCESS</option>
                            <option {{Request::get('status') == 'FINISH' ? 'selected' : ''}} value="FINISH">FINISH</option>
                            <option {{Request::get('status') == 'CANCEL' ? 'selected' : ''}} value="CANCEL">CANCEL</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <input type="submit" value="Filter" class="btn btn-primary btn-sm">
                    </div>
                </div>
            </form>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><b>Invoice Number</b></th>
                            <th><b>Status</b></th>
                            <th><b>Buyer</b></th>
                            <th><b>Total Quantity</b></th>
                            <th><b>Order Date</b></th>
                            <th><b>Total Price</b></th>
                            <th><b>Actions</b></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->invoice_number}}</td>
                            <td>
                                @if($order->status == 'SUBMIT')
                                    <span class="badge badge-warning text-light">{{ $order->status}}</span>
                                @elseif($order->status == 'PROCESS')
                                    <span class="badge badge-info text-light">{{ $order->status}}</span>
                                @elseif($order->status == 'FINISH')
                                    <span class="badge badge-success text-light">{{ $order->status}}</span>
                                @elseif($order->status == 'CANCEL')
                                    <span class="badge badge-danger text-light">{{ $order->status}}</span>
                                @endif
                            </td>
                            <td>
                                {{$order->user->name}}<br>
                                <small>{{$order->user->email}}</small>
                            </td>
                            <td>{{$order->totalQuantity}} pcs</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->total_price}}</td>
                            <td>
                                <a href="{{ route('orders.edit',['id' => $order->id])}}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">{{$orders->appends(Request::all())->links()}}</td>
                        </tr>
                    </tfoot>

                </table>
            </div>
            
        </div>
    </div>
@endsection