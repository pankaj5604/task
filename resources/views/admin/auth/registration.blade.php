@extends('admin.auth.layout')

@section('content')
<div class="container">
      <div class="row">
          <div class="col-lg-3 col-md-2"></div>
          <div class="col-lg-6 col-md-8 login-box">
              <div class="col-lg-12 login-key">
                  <i class="fa fa-key" aria-hidden="true"></i>
              </div>
              <div class="col-lg-12 login-title">
                  Register
              </div>

              <div class="col-lg-12 login-form">
                  <div class="col-lg-12 login-form">
                      <form method="post" action="" class="" id="registerForm">
                          {{ csrf_field() }}

                          <div class="form-group">
                              <label class="form-control-label">name</label>
                              <input type="text" id="name" name="name" class="form-control">
                              <div id="name-error" class="invalid-feedback animated fadeInDown" style="display: none;"></div>
                          </div>
                          
                          <div class="form-group">
                              <label class="form-control-label">Email</label>
                              <input type="text" id="email" name="email" class="form-control">
                              <div id="email-error" class="invalid-feedback animated fadeInDown" style="display: none;"></div>
                          </div>
                          <div class="form-group">
                              <label class="form-control-label">Password</label>
                              <input type="password" class="form-control" id="password" name="password">
                              <div id="password-error" class="invalid-feedback animated fadeInDown" style="display: none;"></div>
                              
                          </div>

                          <div class="col-lg-12 loginbttm">
                              <div class="col-lg-6 login-btm login-text">
                                  <!-- Error Message -->
                              </div>
                              <div class="col-lg-6 login-btm login-button">
                                  <button type="submit" id="loginSubmit" class="btn btn-outline-primary">Register <i class="fa fa-spinner fa-spin loadericonfa" style="display:none;"></i></button>
                              </div>
                              <div class="col-lg-6 login-btm login-text">
                                   <a class="nav-link" href="{{ route('admin.login') }}">Login</a>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
              <div class="col-lg-3 col-md-2"></div>
          </div>
        </div>
@endsection
       