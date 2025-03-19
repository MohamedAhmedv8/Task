<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    @include('layout.styles')
    @include('layout.script')
</head>
<body>
<div id="app">
    <div class="main-wrapper">
        <section class="section">
            <div class="container container-login">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary border-box">
                            <div class="card-header card-header-auth">
                                <h4 class="text-center">Login</h4>
                            </div>
                            <div class="card-body card-body-auth">
                                @if(session()->get('success'))
                                    <div class="text-success">{{ session()->get('success') }}</div>
                                @endif
                                @if(session()->get('danger'))
                                    <div class="text-danger">{{ session()->get('danger') }}</div>
                                @endif
                                <form action="{{ route('login_submit') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('user_name') is-invalid @enderror" 
                                        name="user_name" placeholder="User Name" value="{{ old('user_name') }}" autofocus>
                                        @error('user_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="Password">
                                                  @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                        @if(session()->get('error'))
                                             <div class="text-danger">{{ session()->get('error') }}</div>
                                        @endif
                                        <br>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <span>You do not have account! </span>
                                            <a href="{{ route('register') }}"> Register Now</a>
                                        </div>
                                        <div>
                                            <a href="{{ route('forget_password') }}">Forget Password</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
</body>
</html>