<!DOCTYPE html>
<html>
<head>
    <title>Blogs</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Blogs</a>

  <div class="collapse navbar-collapse" id="navbarText">
    <span class="navbar-text">
      <a href="{{ route('admin.logout')  }}">Logout</a>
    </span>
  </div>
</nav>
    
<div class="container mt-5">
    <h2 class="mb-4">Blogs</h2>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#BlogModal" id="AddBlogBtn">Add Blog</button>
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


<div class="modal fade" id="BlogModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="form-valide"  id="blogsform" method="post" enctype="multipart/form-data"> 
               
                    <div class="modal-header">
                        <h5 class="modal-title" id="formtitle">Add Blog</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="attr-cover-spin" class="cover-spin"></div>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-form-label" for="title">Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control input-flat" id="title" name="title" placeholder="">
                            <div id="title-error" class="invalid-feedback animated fadeInDown" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="description">Description <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control input-flat" id="description" name="description" ></textarea>
                            <div id="description-error" class="invalid-feedback animated fadeInDown" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="displayattributename">Thumbnail
                            </label>
                            <input type="file" class="form-control-file" id="blogthumb" onchange="" name="blogthumb">
                            <div id="blogthumb-error" class="invalid-feedback animated fadeInDown" style="display: none;"></div>
                            <img src="{{ url('images/placeholder_image.png') }}" class="" id="blogthumb_image_show" height="50px" width="50px" style="margin-top: 5px">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="title">Category <span class="text-danger">*</span>
                            </label>
                            <select name="category_id" id="category_id"  class="form-control" >
                                @foreach($categories as $category)
                                 <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            <div id="category-error" class="invalid-feedback animated fadeInDown" style="display: none;"></div>
                        </div>
                        
                        
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="blog_id" id="blog_id">
                        <button type="button" class="btn btn-outline-primary" id="save_newBlogBtn">Save & New <i class="fa fa-circle-o-notch fa-spin loadericonfa" style="display:none;"></i></button>
                        <button type="button" class="btn btn-primary" id="save_closeBlogBtn">Save & Close <i class="fa fa-circle-o-notch fa-spin loadericonfa" style="display:none;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<div class="modal fade" id="DeleteBlogModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remove Blog</h5>
                </div>
                <div class="modal-body">
                    Are you sure you wish to remove this Blog and this Blog related products also deleted ?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-danger" id="RemoveBlogSubmit" type="submit">Remove <i class="fa fa-circle-o-notch fa-spin removeloadericonfa" style="display:none;"></i></button>
                </div>
            </div>
        </div>
    </div>
   
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.blogs.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'image', name: 'image'},
            {data: 'title', name: 'title'},
            {data: 'category', name: 'category'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });

  $('body').on('click', '#AddBlogBtn', function (e) {
        $("#BlogModal").find('.modal-title').html("Add New Blog");
    });

    function save_blog(btn,btn_type){
            $(btn).prop('disabled',true);
            $(btn).find('.loadericonfa').show();
            var action  = $(btn).attr('data-action');
         
            var formData = new FormData($("#blogsform")[0]);
            formData.append('action',action);
         
            //var tab_type = get_attributes_page_tabType();

            //formData.push({ name: "tab_type", value: tab_type });

            $.ajax({
                type: 'POST',
                url: "{{ url('admin/addorupdateblog') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    $('.yajra-datatable').DataTable().ajax.reload();
                    if(res.status == 'failed'){
                        $(btn).find('.loadericonfa').hide();
                        $(btn).prop('disabled',false);
                        if (res.errors.title) {
                            $('#title-error').show().text(res.errors.title);
                        } else {
                            $('#title-error').hide();
                        }

                        if (res.errors.blogthumb) {
                            $('#blogthumb-error').show().text(res.errors.blogthumb);
                        } else {
                            $('#blogthumb-error').hide();
                        }

                        if (res.errors.category_id) {
                            $('#category-error').show().text(res.errors.category_id);
                        } else {
                            $('#category-error').hide();
                        }
                    }

                    if(res.status == 200){
                        if(btn_type == 'save_close'){
                            $("#BlogModal").modal('hide');
                            $(btn).find('.loadericonfa').hide();
                            $(btn).prop('disabled',false);
                            if(res.action == 'add'){
                              
                                toastr.success("blog Added",'Success',{timeOut: 5000});
                            }
                            if(res.action == 'update'){
                             
                                toastr.success("blog Updated",'Success',{timeOut: 5000});
                            }
                        }

                        if(btn_type == 'save_new'){
                            $(btn).find('.loadericonfa').hide();
                            $(btn).prop('disabled',false);
                            $("#BlogModal").find('form').trigger('reset');
                            $('#blog_id').val("");
                            $('#title-error').html("");
                            $('#category-error').html("");
                            $("#BlogModal").find("#save_newBlogBtn").removeAttr('data-action');
                            $("#BlogModal").find("#save_closeBlogBtn").removeAttr('data-action');
                            $("#BlogModal").find("#save_newBlogBtn").removeAttr('data-id');
                            $("#BlogModal").find("#save_closeBlogBtn").removeAttr('data-id');
                            $("#title").focus();
                            if(res.action == 'add'){
                               
                                toastr.success("Blog Added",'Success',{timeOut: 5000});
                            }
                            if(res.action == 'update'){
                             
                                toastr.success("Blog Updated",'Success',{timeOut: 5000});
                            }
                            
                        }
                        
                    }

                    if(res.status == 400){
                        $("#BlogModal").modal('hide');
                        $(btn).find('.loadericonfa').hide();
                        $(btn).prop('disabled',false);
                        $('.yajra-datatable').DataTable().ajax.reload();
                        toastr.error("Please try again",'Error',{timeOut: 5000});
                    }
                },
                error: function (data) {
                    $("#BlogModal").modal('hide');
                    $(btn).find('.loadericonfa').hide();
                    $(btn).prop('disabled',false);
                    $('.yajra-datatable').DataTable().ajax.reload();
                    toastr.error("Please try again",'Error',{timeOut: 5000});
                }
            });
        }

        $('body').on('click', '#save_newBlogBtn', function () {
            save_blog($(this),'save_new');
        });

        $('body').on('click', '#save_closeBlogBtn', function () {
            save_blog($(this),'save_close');
        });

    $('body').on('click', '#editBlogBtn', function () {
        var blog_id = $(this).attr('data-id');
        $.get("{{ url('admin/blog') }}" +'/' + blog_id +'/edit', function (data) {
            $('#BlogModal').find('.modal-title').html("Edit " + data.title);
            $('#BlogModal').find('#save_newBlogBtn').attr("data-action","update");
            $('#BlogModal').find('#save_closeBlogBtn').attr("data-action","update");
            $('#BlogModal').find('#save_newBlogBtn').attr("data-id",blog_id);
            $('#BlogModal').find('#save_closeBlogBtn').attr("data-id",blog_id);
            $('#blog_id').val(data.id);
            $('#title').val(data.title);
            $('#description').val(data.description);
           // $("#category_id select").val(data.category_id);
            $("#category_id").val(data.category_id).change();
            if(data.image==null){
                var default_image = "{{ url('images/placeholder_image.png') }}";
                $('#blogthumb_image_show').attr('src', default_image);
            }
            else{
                var image = "{{ url('images/blogthumb') }}" +"/" + data.image;
                $('#blogthumb_image_show').attr('src', image);
            }
        })
    });

    $('#BlogModal').on('shown.bs.modal', function (e) {
        $("#title").focus();
    });

    $('#BlogModal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
        $(this).find("#save_newBlogBtn").removeAttr('data-action');
        $(this).find("#save_closeBlogBtn").removeAttr('data-action');
        $(this).find("#save_newBlogBtn").removeAttr('data-id');
        $(this).find("#save_closeBlogBtn").removeAttr('data-id');
        $('#blog_id').val("");
        $('#Blogname-error').html("");
        $('#blogthumb-error').html("");
        var default_image = "{{ url('images/placeholder_image.png') }}";
        $('#blogthumb_image_show').attr('src', default_image);
    });

    $('body').on('click', '#deleteBlogBtn', function (e) {
        // e.preventDefault();
        var blog_id = $(this).attr('data-id');
        $("#DeleteBlogModal").find('#RemoveBlogSubmit').attr('data-id',blog_id);
        $.get("{{ url('admin/blog') }}" +'/' + blog_id +'/edit', function (data) {
            $('#DeleteBlogModal').find('.modal-title').html("Remove " + data.title);
        })
    });

    $('body').on('click', '#RemoveBlogSubmit', function (e) {
        $('#RemoveBlogSubmit').prop('disabled',true);
        $(this).find('.removeloadericonfa').show();
        e.preventDefault();
        var blog_id = $(this).attr('data-id');
        $.ajax({
            type: 'GET',
            url: "{{ url('admin/blog') }}" +'/' + blog_id +'/delete',
            success: function (res) {
                $('.yajra-datatable').DataTable().ajax.reload();
                if(res.status == 200){
                    $("#DeleteBlogModal").modal('hide');
                    $('#RemoveBlogSubmit').prop('disabled',false);
                    $("#RemoveBlogSubmit").find('.removeloadericonfa').hide();
                    
                    toastr.success("Blog Deleted",'Success',{timeOut: 5000});
                }

                if(res.status == 400){
                    $("#DeleteBlogModal").modal('hide');
                    $('#RemoveBlogSubmit').prop('disabled',false);
                    $("#RemoveBlogSubmit").find('.removeloadericonfa').hide();
                    
                    toastr.error("Please try again",'Error',{timeOut: 5000});
                }
            },
            error: function (data) {
                $("#DeleteBlogModal").modal('hide');
                $('#RemoveBlogSubmit').prop('disabled',false);
                $("#RemoveBlogSubmit").find('.removeloadericonfa').hide();
                
                toastr.error("Please try again",'Error',{timeOut: 5000});
            }
        });
    });

    $('#DeleteBlogModal').on('hidden.bs.modal', function () {
        $(this).find("#RemoveBlogSubmit").removeAttr('data-id');
    });

    $('#blogthumb').change(function(){
        $('#blogthumb-error').hide();
        var file = this.files[0];
        var fileType = file["type"];
        var validImageTypes = ["image/jpeg", "image/png", "image/jpg"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            $('#blogthumb-error').show().text("Please provide a Valid Extension Image(e.g: .jpg .png)");
            var default_image = "{{ url('images/placeholder_image.png') }}";
            $('#blogthumb_image_show').attr('src', default_image);
        }
        else {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#blogthumb_image_show').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
</html>