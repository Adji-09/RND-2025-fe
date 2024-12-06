@extends('layouts.master')

@section('title') {{ $li }} {{ $title }} @endsection

@section('content')

    @include('components.breadcrumb')

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-dark btn-label waves-effect waves-light" href="{{ route('user') }}"><i class="ri-arrow-left-s-line label-icon align-middle fs-16 me-2"></i> Back</a>
                    <button type="button" class="btn btn-sm btn-warning modalAlertSuccess" data-bs-toggle="modal" data-bs-title="Success" hidden></button>
                    <button type="button" class="btn btn-sm btn-warning modalAlertError" data-bs-toggle="modal" data-bs-title="Error" hidden></button>
                </div>
                <div class="card-body">
                    <form id="form" action="{{ route('user.update') }}" method="POST" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" id="token" value="{{ Session::get('access_token') }}" />
                        @foreach($datas as $data)
                            <input type="hidden" id="id" name="id" value="{{ $data->id }}" />
                            {{-- <div class="col-md-12" style="text-align:center;">
                                <div class="shrink-0 my-2 text-center position-relative d-inline-block mx-auto">
                                    <img src="{{ $data->foto }}" id="image_preview" class="rounded-circle avatar-xl img-thumbnail" alt="Preview" title="Preview" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="foto" class="form-label">Photo</label>
                                <small class="text-muted"><i>&nbsp;<span style="color: red;">File:</span> JPEG, JPG, PNG (Max: 2 MB)</i></small>
                                <input type="file" class="form-control" id="foto" name="foto" placeholder="Photo" accept="image/png, image/jpg, image/jpeg"/>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="password">Password <span style="color: red;">*</span></label>
                                <small class="text-muted"><i>(Min: 8 Character)</i></small>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" class="form-control pe-5 password-input" id="new_password" name="password"
                                        placeholder="Password" onkeyup="checkConfirmPass(); return false;" required>
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon-np">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        Please enter Password.
                                    </div>
                                </div>
                                <span id="msg_new_pass" class="msg_new_pass"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="confirm_password">Confirmation Password <span style="color: red;">*</span></label>
                                <small class="text-muted"><i>(Min: 8 Character)</i></small>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" class="form-control pe-5 password-input" id="confirm_password" name="confirm_password"
                                        placeholder="Confirmation Password" onkeyup="checkConfirmPass(); return false;" required>
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon-cop">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        Please enter Confirmation Password.
                                    </div>
                                </div>
                                <span id="msg_con_pass" class="msg_con_pass"></span>
                            </div> --}}
                            <div class="col-md-12">
                                <label for="role_id" class="form-label">Role <span style="color: red;">*</span></label>
                                <select class="form-select" id="role_id" name="role_id" required>
                                    <option value="" disabled>---</option>
                                    <option value="1" {{ $data->role_id == 1 ? "selected" : "" }}>Administrator</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please choose Role.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="status_user" class="form-label">Status <span style="color: red;">*</span></label>
                                <select class="form-select" id="status_user" name="status_user" required>
                                    <option value="" disabled>---</option>
                                    <option value="1" {{ $data->status == 1 ? "selected" : "" }}>Active</option>
                                    <option value="2" {{ $data->status == 2 ? "selected" : "" }}>Inactive</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please choose Status.
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-success btn-label waves-effect waves-light" id="btn_simpan"><i class="ri-save-2-fill label-icon align-middle fs-16 me-2"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('components.alert_success')
    @include('components.alert_error')

@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/pages/password-addon.init.js') }}"></script>

    <script>
        var success = <?php echo json_encode(\Session::get('success')) ?>;

        var error = <?php echo json_encode(\Session::get('error')) ?>;

        if (success) {
            $(document).ready(function() {
                $("#modalAlertSuccess").modal("show");
            });
        }

        if (error) {
            $(document).ready(function() {
                $("#modalAlertError").modal("show");
            });
        }

        // create onchange event listener for foto input
        document.getElementById('foto').onchange = function(evt) {
            const [file] = this.files
            if (file) {
                // if there is an image, create a preview in image_preview
                document.getElementById('image_preview').src = URL.createObjectURL(file)
            }
        }

        // CHECK USERNAME
        function checkUsername()
        {
            var token = document.getElementById('token');
            var username = document.getElementById('username');
            var msg_username = document.getElementById('msg_username');

            var goodColor = "#66CC66";
            var badColor = "#FF6666";

            var form = new FormData();
            form.append("username", username.value);

            var settings = {
                "url": "http://localhost:8010/api/user/getByUsername/",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Authorization": "Bearer " + token.value
                },
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": form
            };

            $.ajax(settings).done(function (response) {

                var parsed_data = JSON.parse(response);

                if (parsed_data.username != "") {
                    username.style.border = 'solid 1px';
                    username.style.borderColor = badColor;
                    msg_username.style.color = badColor;
                    msg_username.innerHTML = "Username is already registered!";
                    document.getElementById("btn_simpan").disabled = true;
                } else {
                    username.style.border = 'solid 1px';
                    username.style.borderColor = goodColor;
                    msg_username.innerHTML = "";
                    document.getElementById("btn_simpan").disabled = false;
                }
            });
        }

        // VALIDASI EMAIL
        function IsEmail(email) {
            const regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!regex.test(email)) {
                return false;
            } else {
                return true;
            }
        }

        // CHECK EMAIL
        function checkEmail()
        {
            var token = document.getElementById('token');
            var email = document.getElementById('email');
            var msg_email = document.getElementById('msg_email');

            var goodColor = "#66CC66";
            var badColor = "#FF6666";

            var form = new FormData();
            form.append("email", email.value);

            var settings = {
                "url": "http://localhost:8010/api/user/getByEmail/",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Authorization": "Bearer " + token.value
                },
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": form
            };

            $.ajax(settings).done(function (response) {

                var parsed_data = JSON.parse(response);

                if (IsEmail(email.value) === false) {
                    email.style.border = 'solid 1px';
                    email.style.borderColor = badColor;
                    msg_email.style.color = badColor;
                    msg_email.innerHTML = "Invalid!";
                    document.getElementById("btn_simpan").disabled = true;
                } else {
                    if (parsed_data.email != "") {
                        email.style.border = 'solid 1px';
                        email.style.borderColor = badColor;
                        msg_email.style.color = badColor;
                        msg_email.innerHTML = "Email is already registered!";
                        document.getElementById("btn_simpan").disabled = true;
                    } else {
                        email.style.border = 'solid 1px';
                        email.style.borderColor = goodColor;
                        msg_email.innerHTML = "";
                        document.getElementById("btn_simpan").disabled = false;
                    }
                }
            });
        }

        // CHECK CONFIRM PASSWORD
        function checkConfirmPass()
        {
            var newPassword = document.getElementById('new_password');
            var confirmPassword = document.getElementById('confirm_password');
            var msg_new_pass = document.getElementById('msg_new_pass');
            var msg_con_pass = document.getElementById('msg_con_pass');

            var goodColor = "#66CC66";
            var badColor = "#FF6666";

            if (newPassword.value == confirmPassword.value) {
                confirmPassword.style.border = 'solid 1px';
                confirmPassword.style.borderColor = goodColor;
                msg_con_pass.innerHTML = "";
                document.getElementById("btn_simpan").disabled = false;
            } else if (confirmPassword.value == newPassword.value) {
                confirmPassword.style.border = 'solid 1px';
                confirmPassword.style.borderColor = goodColor;
                msg_con_pass.innerHTML = "";
                document.getElementById("btn_simpan").disabled = false;
            } else if (newPassword.value != confirmPassword.value) {
                confirmPassword.style.border = 'solid 1px';
                confirmPassword.style.borderColor = badColor;
                msg_con_pass.style.color = badColor;
                msg_con_pass.innerHTML = "Confirm Password doesn't match!";
                document.getElementById("btn_simpan").disabled = true;
            } else if (confirmPassword.value != newPassword.value) {
                confirmPassword.style.border = 'solid 1px';
                confirmPassword.style.borderColor = badColor;
                msg_con_pass.style.color = badColor;
                msg_con_pass.innerHTML = "Confirm Password doesn't match!";
                document.getElementById("btn_simpan").disabled = true;
            } else {
            }

            if (newPassword.value.length < 8) {
                newPassword.style.border = 'solid 1px';
                newPassword.style.borderColor = badColor;
                msg_new_pass.style.color = badColor;
                msg_new_pass.innerHTML = "Password less than 8 characters!";
                document.getElementById("btn_simpan").disabled = true;
            } else if (newPassword.value.length >= 8) {
                newPassword.style.border = 'solid 1px';
                newPassword.style.borderColor = goodColor;
                msg_new_pass.innerHTML = "";
                document.getElementById("btn_simpan").disabled = false;
            } else if (confirmPassword.value.length < 8) {
                confirmPassword.style.border = 'solid 1px';
                confirmPassword.style.borderColor = badColor;
                msg_con_pass.style.color = badColor;
                msg_con_pass.innerHTML = "Password less than 8 characters!";
                document.getElementById("btn_simpan").disabled = true;
            } else if (confirmPassword.value.length >= 8) {
                confirmPassword.style.border = 'solid 1px';
                confirmPassword.style.borderColor = goodColor;
                msg_con_pass.innerHTML = "";
                document.getElementById("btn_simpan").disabled = false;
            }
        }
    </script>
@endsection
