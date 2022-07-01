@extends('layouts.app')
@section('page_name')
    Products
@endsection
@section('content')
    <div class="page-heading">
        <section class="section">
            <div class="card">
                <div class="card-header" style="display: flex;flex-direction: row; justify-content: space-between">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inlineForm">Add Product</button>
                    <a href="{{route('product_list.index')}}" class="btn btn-secondary">Go Product List ></a>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Product Image</th>
                            <th>Sub Category Name</th>
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
                                <td>{{$product->sub_category->sub_category_name}}</td>
                                <td>
                                    <button class="btn btn-warning" onclick="detail({{$product->id}})">Edit</button>
                                    <button class="btn btn-danger" onclick="remove({{$product->id}})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>

    <!--product add form modal -->
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add Sub Category </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <form id="add_product_form" enctype="multipart/form-data">
                    <div class="modal-body">
                        <label>Sub Category Name</label>
                        <div class="form-group">
                            <select name="sub_category_name" id="sub_category_name" class="form-control">
                                @foreach($sub_categories as $sub_category)
                                    <option value="{{$sub_category->id}}">{{$sub_category->sub_category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label>Product Name: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Product Name" name="product_name" id="product_name" class="form-control">
                        </div>
                        <label>Product Price: </label>
                        <div class="form-group">
                            <input type="number" placeholder="Product Price" name="product_price" id="product_price" class="form-control">
                        </div>
                        <label>Product Image: </label>
                        <div class="form-group">
                            <input type="file" placeholder="Product Image" name="product_path" id="product_path" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--product edit form modal -->
    <div class="modal fade text-left" id="editForm" tabindex="-1" aria-labelledby="myModalLabel34" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Sub Category </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <form id="edit_product_form" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="product_id" id="product_id" value="">
                        <label>Sub Category Name</label>
                        <div class="form-group">
                            <select name="sub_category_name_update" id="sub_category_name_update" class="form-control">
                                @foreach($sub_categories as $sub_category)
                                    <option value="{{$sub_category->id}}">{{$sub_category->sub_category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label>Product Name: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Product Name" name="product_name_update" id="product_name_update" class="form-control">
                        </div>
                        <label>Product Price: </label>
                        <div class="form-group">
                            <input type="number" placeholder="Product Price" name="product_price_update" id="product_price_update" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Current Product Image: </label>
                            <img id="product_image_path" src="" width="150" height="150">
                        </div>
                        <label>New Product Image: </label>
                        <div class="form-group">
                            <input type="file" placeholder="Product Image" name="product_path_update" id="product_path_update" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
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

        //create form
        $( document ).on("submit",'#add_product_form',function (event){
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"{{route('product.create')}}",
                type:'POST',
                data:formData,
                dataType: "json",
                contentType: false,
                cache: false,
                processData:false,
                success: function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Process Successfully',
                        html: 'The category has been added successfully!'
                    }).then(function (result){
                        if(result.value === true){
                            window.location.reload();
                        }
                    });
                },
                error: function(data) {
                    var errors = '';
                    for(datas in data.responseJSON['errors']){
                        errors += data.responseJSON['errors'][datas] + '<br>';
                    }
                    //Sweet alert js function
                    Swal.fire({
                        icon:'error',
                        title:'<h1><b>Fail!</b></h1>',
                        html: '<h4>'+errors+'</h4>',
                        position: 'center',
                        height:'500px',
                        width:'600px',
                    });
                }
            });
        });
        // end of create form

        //shows update form infos
        function detail(id){
            $.ajax({
                type:'GET',
                data:{id:id},
                url:"{{route('product.detail')}}",
                success: function (data){
                    $('#product_id').val(data.id);
                    $('#product_name_update').val(data.product_name);
                    $('#product_price_update').val(data.product_price);
                    $('#product_image_path').attr("src","{{asset('/products')}}"+"/"+data.product_path);
                    $('#sub_category_name_update').val(data.sub_category_name);
                    $('#editForm').modal('show');
                }
            });
        }
        //end of update form infos


        //edit form
        $( document ).on("submit",'#edit_product_form',function (event){
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"{{route('product.update')}}",
                type:'POST',
                data:formData,
                dataType: "json",
                contentType: false,
                cache: false,
                processData:false,
                success: function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Process Successfully',
                        html: 'The category has been updated successfully!'
                    }).then(function (result){
                        if(result.value === true){
                            window.location.reload();
                        }
                    });
                },
                error: function(data) {
                    var errors = '';
                    for(datas in data.responseJSON['errors']){
                        errors += data.responseJSON['errors'][datas] + '<br>';
                    }
                    //Sweet alert js function
                    Swal.fire({
                        icon:'error',
                        title:'<h1><b>Fail!</b></h1>',
                        html: '<h4>'+errors+'</h4>',
                        position: 'center',
                        height:'500px',
                        width:'600px',
                    });
                }
            });
        });
        // end of edit form

        //delete parent category
        function remove(id){
            $.ajax({
                type:'GET',
                data:{id:id},
                url:"{{route('product.delete')}}",
                success: function (){
                    Swal.fire({
                        icon: 'success',
                        title: 'Process Successfully',
                        html: 'The category has been deleted successfully!'
                    }).then(function (result){
                        if(result.value === true){
                            window.location.reload();
                        }
                    });
                }
            });
        }
        //end of delete parent category
    </script>

@endsection
