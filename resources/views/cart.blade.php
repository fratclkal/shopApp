@extends('layouts.app')
@section('page_name')
    Cart
@endsection
@section('content')
    <div class="page-heading">
        <section class="section">
            <div class="row" id="table-hover-row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            @if(\App\Models\Cart::where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->count() >0) <!-- @todo -->
                                <button class="btn btn-danger" onclick="removeAll()">Remove All Products From My Cart</button>
                            @endif
                        </div>
                        <div class="card-content">
                            <!-- table hover -->
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($carts as $cart)
                                        <tr>
                                            <td><img src="{{asset('/products/')."/".\App\Models\Product::find($cart->product_id)->product_path}}" height="80" width="80" alt=""></td>
                                            <td>{{\App\Models\Product::find($cart->product_id)->product_name}}</td>
                                            <td>{{\App\Models\Product::find($cart->product_id)->product_price}} $</td>
                                            <td><button onclick="amountChange({{$cart->id}},0)" class="btn btn-danger">-</button>{{$cart->amount}} <button onclick="amountChange({{$cart->id}},1)" class="btn btn-success">+</button></td>
                                            <td><button onclick="removeItem({{$cart->id}})" class="btn btn-danger">Remove</button></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <h3>Total : {{$total}}</h3>
                            <button class="btn btn-success" onclick="payment()">Payment</button>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>


    <script src="{{asset('panel/assets/js/app.js')}}"></script>

    <script src="{{asset('panel/assets/js/extensions/simple-datatables.js')}}"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                }
            });
        });

        function removeItem(id){
            $.ajax({
                type:'GET',
                data:{id:id},
                url:"{{route('cart.remove')}}",
                success: function (){
                    Swal.fire({
                        icon: 'success',
                        title: 'Process Successfully',
                        html: 'The product has been removed from cart successfully!'
                    }).then(function (result){
                        if(result.value === true){
                            window.location.reload();
                        }
                    });
                }
            });
        }

        function amountChange(id,upOrDown){
            $.ajax({
                type:'GET',
                data:{id:id,status:upOrDown},
                url:"{{route('cart.amountChange')}}",
                success: function (){
                    window.location.reload();
                }
            });
        }

        function removeAll(){
            $.ajax({
                type:'GET',
                url:"{{route('cart.removeAll')}}",
                success: function (){
                    window.location.reload();
                }
            });
        }

        function payment(){
            Swal.fire({
                icon: 'success',
                title: 'Success',
            })
        }

    </script>

@endsection
