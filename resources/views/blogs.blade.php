
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
<div class="container mt-5">
<div class="form-group">
    <label class="col-form-label" for="title">Category 
    </label>
    <select name="category" id="category"  class="form-control common_selector">
    <option value="">select category</option>
        @foreach($categories as $category)
          <option value="{{ $category->id }}">{{ $category->title }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label class="col-form-label" for="search">search 
    </label>
    <input type="text" name="search" id="search" class="form-control common_input">
</div>
<div class="card-group blogdata row">
  
  
</div>
</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
  $(document).ready(function(){
    filter_data(0);
    $('.common_selector').click(function(){
        filter_data(0);
    });
    $(".common_input").keyup(function(){
        filter_data(0);
    });
    function filter_data(page,scroll=0)
    {  
      var search = $('#search').val();
      var category = $('#category').val();
        $.ajax({
            url:"{{ url('/blog-filter') }}",
            method:"POST",
            data:{search:search,category:category,_token: '{{ csrf_token() }}'},
            success:function(response){
              $(".blogdata").html(response);   
            }
        });
    }
    });
</script>

</html>