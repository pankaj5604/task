<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
<link href="{{ asset('css/style.css')}}" rel="stylesheet">
</head>

<body>
@yield('content')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script type="text/javascript">

        $('#LoginForm').on('submit', function (e) {
                $("#email-error").html("");
                $("#password-error").html("");
                var thi = $(this);
                $('#loginSubmit').find('.loadericonfa').show();
                $('#loginSubmit').prop('disabled',true);
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.postlogin') }}",
                    data: formData,
                    success: function (res) {
                        if(res.status == 'failed'){
                            $('#loginSubmit').find('.loadericonfa').hide();
                            $('#loginSubmit').prop('disabled',false);
                            if (res.errors.email) {
                                $('#email-error').show().text(res.errors.email);
                            } else {
                                $('#email-error').hide();
                            }

                            if (res.errors.password) {
                                $('#password-error').show().text(res.errors.password);
                            } else {
                                $('#password-error').hide();
                            }
                        }

                        if(res.status == 200){
                            $('#loginSubmit').prop('disabled',false);
                            toastr.success("You have Successfully loggedin",'Success',{timeOut: 5000});
                            location.href ="{{ url('admin/dashboard') }}";
                        }

                        if(res.status == 300){
                            $('#loginSubmit').find('.loadericonfa').hide();
                            $('#loginSubmit').prop('disabled',false);
                            toastr.error("Your Account is Deactive..Please Contact Admin",'Error',{timeOut: 5000});
                        }

                        if(res.status == 400){
                            $('#loginSubmit').find('.loadericonfa').hide();
                            $('#loginSubmit').prop('disabled',false);
                            toastr.error("Opps! You have entered invalid credentials",'Error',{timeOut: 5000});
                        }
                    },
                    error: function (data) {
                        $('#loginSubmit').find('.loadericonfa').hide();
                        $('#loginSubmit').prop('disabled',false);
                        toastr.error("Please try again",'Error',{timeOut: 5000});
                    }
                });
            });

            $('#registerForm').on('submit', function (e) {
                $("#name-error").html("");
                $("#email-error").html("");
                $("#password-error").html("");
                var thi = $(this);
                $('#RegisterSubmit').find('.loadericonfa').show();
                $('#RegisterSubmit').prop('disabled',true);
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('register.custom') }}",
                    data: formData,
                    success: function (res) {
                        console.log(res);
                        if(res.status == 'failed'){
                            $('#RegisterSubmit').find('.loadericonfa').hide();
                            $('#RegisterSubmit').prop('disabled',false);
                            if (res.errors.name) {
                                $('#name-error').show().text(res.errors.name);
                            } else {
                                $('#name-error').hide();
                            }
                            if (res.errors.email) {
                                $('#email-error').show().text(res.errors.email);
                            } else {
                                $('#email-error').hide();
                            }
                            if (res.errors.password) {
                                $('#password-error').show().text(res.errors.password);
                            } else {
                                $('#password-error').hide();
                            }
                        }

                        if(res.status == 200){
                            $('#RegisterSubmit').prop('disabled',false);
                            toastr.success("You have Successfully Register",'Success',{timeOut: 5000});
                            location.href ="{{ url('/admin') }}";
                            //return redirect()->back();
                        }

                        if(res.status == 400){
                            $('#RegisterSubmit').find('.loadericonfa').hide();
                            $('#RegisterSubmit').prop('disabled',false);
                            toastr.error("Opps! You have entered invalid credentials",'Error',{timeOut: 5000});
                        }
                    },
                    error: function (data) {
                        $('#RegisterSubmit').find('.loadericonfa').hide();
                        $('#RegisterSubmit').prop('disabled',false);
                        toastr.error("Please try again",'Error',{timeOut: 5000});
                    }
                });
            });
            
        </script>
        </body>
        </html>