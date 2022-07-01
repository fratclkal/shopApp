@extends('layouts.app')
@section('page_name')
    Parent Categories
@endsection
@section('content')
    <div class="page-heading">
        <section class="section">
            <div class="card">
                <div class="card-header" style="display: flex;flex-direction: row; justify-content: space-between">
                    <a href="{{route('sub_category.index')}}" class="btn btn-secondary">Go Sub Category</a>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inlineForm">Add Parent Category</button>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Parent Category Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($parents as $parent)
                            <tr>
                                <td>{{$parent->id}}</td>
                                <td>{{$parent->parent_name}}</td>
                                <td>
                                    <button class="btn btn-warning" onclick="detail({{$parent->id}})">Edit</button>
                                    <button class="btn btn-danger" onclick="remove({{$parent->id}})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>

    <!--parent category add form modal -->
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add Parent Category </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <form id="add_parent_category_form">
                    <div class="modal-body">
                        <label>Parent Category Name: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Parent Category Name" name="parent_name" id="parent_name" class="form-control">
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

    <!--parent category edit form modal -->
    <div class="modal fade text-left" id="editForm" tabindex="-1" aria-labelledby="myModalLabel34" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Parent Category </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <form id="edit_parent_category_form">
                    <div class="modal-body">
                        <input type="hidden" name="parent_category_id" id="parent_category_id" value="">
                        <label>Parent Category Name: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Parent Category Name" name="parent_name_update" id="parent_name_update" class="form-control">
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
        $( document ).on("submit",'#add_parent_category_form',function (event){
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"{{route('parent_category.create')}}",
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
                url:"{{route('parent_category.detail')}}",
                success: function (data){
                    $('#parent_category_id').val(data.id);
                    $('#parent_name_update').val(data.parent_name);
                    $('#editForm').modal('show');
                }
            });
        }
        //end of update form infos


        //edit form
        $( document ).on("submit",'#edit_parent_category_form',function (event){
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"{{route('parent_category.update')}}",
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
                url:"{{route('parent_category.delete')}}",
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
