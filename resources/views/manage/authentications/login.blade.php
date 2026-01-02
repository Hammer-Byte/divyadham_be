@extends('manage.layouts.blankLayout')

@section('title', 'Admin Login')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('admin/assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('manage._partials.logo',["width"=>250])</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Welcome to {{config('app.name')}}! 👋</h4>

          <form id="frm_login" class="mb-3" action="{{ route('manage.login') }}" method="post">
            @include('manage.include.notify')
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email or username" autofocus>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
                <a href="javascript:void(0)">
                  <small>Forgot Password?</small>
                </a>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection


@section('inlineScript')
  <script>
    $('#frm_login').validate({
      rules: {
        email: {
          required: true,
          email: true
        },
        password: {
          required: true,
        }
      },
      messages: {
        email: {
          required: 'Email is required.',
          email: 'Please enter valid email address.'
        },
        password: {
          required: 'Password is required.'
        }
      }
    });
  </script>
@endsection
