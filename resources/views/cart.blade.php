@extends('shop')
   
@section('content')
<table id="cart" class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                 
                <tr rowId="{{ $id }}">
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{asset('images')}}/{{ $details['image'] }}" class="card-img-top"/></div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">tk {{ $details['price'] }}</td>
                    <td data-th="Quantity">
                    <div class="d-flex">
                    <form action="{{ route('cart.increment', $id) }}" method="POST">
                        @csrf
                        <button type="submit">+</button>
                    </form>
                    <span class="form-control w-25">{{ $details['quantity'] }}</span>
                    <form action="{{ route('cart.decrement', $id) }}" method="POST">
                        @csrf
                        <button type="submit">-</button>
                    </form>
                    </div>
                    
                    </td>
                    
                    <td data-th="Total">${{ $details['price'] * $details['quantity'] }}</td>
                    <td data-th="Action" class="action">
                       
                        <a class="btn btn-outline-danger btn-sm delete-product"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right">
                <a href="{{ url('/home') }}" class="btn btn-primary"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                <button class="btn btn-danger">Checkout</button>

                <p class="fw-bold mx-auto">Total : Tk {{ $totalPrice }} only.</p>
            </td>
        </tr>
    </tfoot>
</table>
@endsection


@section('scripts')
<script type="text/javascript">
   
    $(".delete-product").click(function (e) {
        e.preventDefault();
   
        var ele = $(this);
   
        if(confirm("Do you really want to delete?")) {
            $.ajax({
                url: '{{ route('delete.cart.product') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("rowId")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
   
</script>
@endsection

   