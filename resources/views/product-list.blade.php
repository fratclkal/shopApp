@extends('layouts.app')
@section('page_name')
    Product List
@endsection
@section('content')
    <div class="page-heading">
        <section class="section">
            <div class="card">
                <div class="card-header" style="display: flex;flex-direction: row; justify-content: space-between">
                    <a href="{{route('cart.index')}}" class="btn btn-info">Go to Cart ({{\App\Models\Cart::where('user_id',\Illuminate\Support\Facades\Auth::id())->count()}})</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Product Image</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->product_price}} $</td>
                                <td><img src="{{asset('/products/'. $product->product_path)}}" height="80" width="80"></td>
                                <td>
                                    <button class="btn btn-success" onclick="addToCart({{$product->id}})">Add To Cart</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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

        function addToCart(id){
            $.ajax({
                type:'POST',
                data:{id:id},
                url:"{{route('product_list.addToCart')}}",
                success: function (){
                    Swal.fire({
                        icon: 'success',
                        title: 'Process Successfully',
                        html: 'The product has been added to cart successfully!'
                    }).then(function (result){
                        if(result.value === true){
                            window.location.reload();
                        }
                    });
                }
            });
        }
    </script>

@endsection
