@extends('layouts.master-without-nav')

@section('title') Login @endsection

@section('content')
    <div class="auth-page-wrapper auth-bg-cover d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <div class="auth-page-content overflow-hidden">

            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden card-bg-fill border-0 card-border-effect-none">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        {{-- <div class="bg-overlay"></div> --}}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-center mb-3 text-white-50">
                                                    <div>
                                                        <img src="{{ URL::asset('assets/images/logo/logo-sm.png')}}" class="d-inline-block auth-logo" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="font-weight: bold; font-size: 25px;">
                                            <center>Content Management System</center>
                                        </div>

                                        {{-- <div style="font-weight: bold; font-size: 16px;">
                                            <center>
                                                <small class="text-muted">Constant Cyber Forensic Solutions Pty Ltd</small>
                                            </center>
                                        </div> --}}

                                        <div class="mt-4">
                                            <form action="{{ route('login.post') }}" method="POST" class="needs-validation" novalidate>
                                                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" value="{{ old('username', 'administrator') }}" id="username" name="username" placeholder="Enter Username" required>
                                                    <div class="invalid-feedback">
                                                        Please enter your Username.
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    {{-- <div class="float-end">
                                                        <a href="#" class="text-muted">Forgot password?</a>
                                                    </div> --}}
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="password" class="form-control pe-5 password-input" name="password" placeholder="Enter Password" id="password-input" value="12345678" required>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon">
                                                            <i class="ri-eye-fill align-middle"></i>
                                                        </button>
                                                        <div class="invalid-feedback">
                                                            Please enter your Password.
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- {!! Geetest::render() !!} --}}

                                                <div class="mt-3">
                                                    <button class="btn btn-success w-100 waves-effect waves-light me-1" type="submit">Login</button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <div class="signin-other-title">
                                                        <h5 class="fs-13 mb-3 title">Login with</h5>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('login.face') }}" type="button" class="btn btn-primary btn-label waves-effect waves-light">
                                                            <i class="ri-body-scan-fill label-icon align-middle fs-20 me-2"></i> Face Recognition
                                                        </a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer" style="margin-bottom: 1%;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        {{-- <div class="text-center text-dark fs-14">
                            <b>Copyright © <script>document.write(new Date().getFullYear())</script> Content Management System - Constant Cyber Forensic Solutions Pty Ltd. All rights reserved.</b>
                        </div> --}}
                        <div class="text-center text-dark fs-14">
                            <b>Copyright © <script>document.write(new Date().getFullYear())</script> Content Management System. All rights reserved.</b>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        @include('components.alert_error')
    </div>
@endsection
