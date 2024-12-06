@extends('layouts.master')

@section('title') {{ $title }} @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-sm btn-warning modalAlertSuccess" data-bs-toggle="modal" data-bs-title="Success" hidden></button>
    <button type="button" class="btn btn-sm btn-warning modalAlertError" data-bs-toggle="modal" data-bs-title="Error" hidden></button>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-border-secondary">
                    <div class="card-body p-4">
                        <div class="text-center">
                            @foreach($datas as $data)
                                <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                    <img src="{{ $data->foto }}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" id="image_preview" alt="user-profile-image">
                                </div>
                                <h5 class="mb-1">{{ $data->username }}</h5>
                                <p class="text-muted mb-0">{{ Session::get('role') }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card card-border-secondary">
                    {{-- <div class="card-header">

                    </div> --}}
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-border-top nav-border-top-primary mb-4" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab" aria-selected="true">
                                    Update Profile
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab" aria-selected="false" tabindex="-1">
                                    Update Password
                                </a>
                            </li>
                            <li class="nav-item" role="face">
                                <a class="nav-link" data-bs-toggle="tab" href="#face" role="tab" aria-selected="false" tabindex="-1">
                                    Face Enrollment
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active show" id="personalDetails" role="tabpanel">
                                <form id="form" action="{{ route('profile.change_profile') }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    @foreach($datas as $data)
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                        <div class="row g-2">
                                            <div class="col-lg-4">
                                                <label for="foto" class="form-label">Photo</label>
                                                <small class="text-muted"><i>&nbsp;<span style="color: red;">File:</span> JPEG, JPG, PNG (Max: 2 MB)</i></small>
                                                <input type="file" class="form-control" id="foto" name="foto" placeholder="Photo" accept="image/png, image/jpg, image/jpeg"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="username" class="form-label">Username <span style="color: red;">*</span></label>
                                                <input type="hidden" id="old_username" value="{{ $data->username }}">
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                                                value="{{ $data->username }}" required>
                                                <div class="invalid-feedback">
                                                    Please enter Username.
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="email" class="form-label">Email <span style="color: red;">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                                value="{{ $data->email }}" required>
                                                <div class="invalid-feedback">
                                                    Please enter Email.
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-end mt-2">
                                                    <button type="submit" class="btn btn-success btn-label waves-effect waves-light" onclick="renameSubject()"><i class="ri-save-2-fill label-icon align-middle fs-16 me-2"></i> Update profile</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </form>
                            </div>

                            <div class="tab-pane" id="changePassword" role="tabpanel">
                                <form id="form_pass" action="{{ route('profile.change_password') }}" method="POST" class="needs-validation" novalidate>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    @foreach($datas as $data)
                                        <input type="hidden" id="token" value="{{ Session::get('access_token') }}" />
                                        <input type="hidden" id="id_pass" name="id" value="{{ $data->id }}">
                                        <div class="row g-2">
                                            <div class="col-lg-4">
                                                <label class="form-label" for="current_password">Current Password <span style="color: red;">*</span></label>
                                                <div class="position-relative auth-pass-inputgroup">
                                                    <input type="password" class="form-control pe-5 password-input" id="current_password" name="current_password"
                                                        placeholder="Current Password" onkeyup="checkCurPass(); return false;" required>
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon-cp">
                                                        <i class="ri-eye-fill align-middle"></i>
                                                    </button>
                                                    <div class="invalid-feedback">
                                                        Please enter Current Password.
                                                    </div>
                                                </div>
                                                <span id="msg_cur_pass" class="msg_cur_pass"></span>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label" for="new_password">New Password <span style="color: red;">*</span></label>
                                                <small class="text-muted"><i>(Min: 8 Character)</i></small>
                                                <div class="position-relative auth-pass-inputgroup">
                                                    <input type="password" class="form-control pe-5 password-input" id="new_password" name="new_password"
                                                        placeholder="New Password" onkeyup="checkCurPass(); return false;" required>
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon-np">
                                                        <i class="ri-eye-fill align-middle"></i>
                                                    </button>
                                                    <div class="invalid-feedback">
                                                        Please enter New Password.
                                                    </div>
                                                </div>
                                                <span id="msg_new_pass" class="msg_new_pass"></span>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label" for="confirm_password">Confirmation Password <span style="color: red;">*</span></label>
                                                <small class="text-muted"><i>(Min: 8 Character)</i></small>
                                                <div class="position-relative auth-pass-inputgroup">
                                                    <input type="password" class="form-control pe-5 password-input" id="confirm_password" name="confirm_password"
                                                        placeholder="Confirmation Password" onkeyup="checkCurPass(); return false;" required>
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon-cop">
                                                        <i class="ri-eye-fill align-middle"></i>
                                                    </button>
                                                    <div class="invalid-feedback">
                                                        Please enter Confirmation Password.
                                                    </div>
                                                </div>
                                                <span id="msg_con_pass" class="msg_con_pass"></span>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-end mt-2">
                                                    <button type="reset" class="btn btn-secondary waves-effect waves-light">Reset</button>
                                                    <button type="submit" id="btn_simpan" class="btn btn-success btn-label waves-effect waves-light"><i class="ri-save-2-fill label-icon align-middle fs-16 me-2"></i> Change password</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </form>
                            </div>

                            <div class="tab-pane" id="face" role="tabpanel">
                                <input type="hidden" id="apiKey" value="0a97a36c-021e-4c6c-bac7-eb021d3f7b6b" />
                                <input type="hidden" name="images" class="image-tag">
                                <div id="camera" class="mb-1"></div>
                                <button type="button" class="btn btn-primary btn-label waves-effect waves-light mb-5" onClick="take_snapshot()">
                                    <i class="ri-camera-line label-icon align-middle fs-16 me-2"></i> Take picture
                                </button>
                                <br>
                                {{-- LIST FACE ENROLLMENT --}}
                                @if($faces)
                                    <h2 class="mb-3">
                                        <span class="badge bg-success">List Face Enrollment</span>
                                    </h2>
                                @endif
                                <div class="row row-cols-1 row-cols-md-3 g-4 mb-0">
                                    @foreach($faces as $row)
                                        <div class="col" style="height: 300px;">
                                            <div class="card h-100">
                                                <div class="card-img-top rounded" style="background-image: url('http://localhost:8000/api/v1/static/0a97a36c-021e-4c6c-bac7-eb021d3f7b6b/images/{{ $row->image_id }}');
                                                    max-width: 100%; height: 300px; background-position: center; background-repeat: no-repeat; background-size: cover;">
                                                    <div class="d-flex justify-content-between m-2">
                                                        <div>&nbsp;</div>
                                                        <div>
                                                            <button class="dropdown-item remove-list modalConfirmDelete" data-bs-toggle="modal" data-id_delete="{{ $row->image_id }}" title="Remove">
                                                                <i class="ri-delete-bin-line align-bottom me-2 text-dark ri-xl"></i>
                                                            </button>
                                                            <input type="hidden" id="image_id" value="{{ $row->image_id }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.alert_success')
    @include('components.alert_success_password')
    @include('components.alert_error')
    @include('profile.confirm_delete')

@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/pages/profile.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/password-addon.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/webcam.min.js') }}"></script>

    <script type="text/javascript">
        var success = <?php echo json_encode(\Session::get('success')) ?>;

        var success_password = <?php echo json_encode(\Session::get('success_password')) ?>;

        var error = <?php echo json_encode(\Session::get('error')) ?>;

        if (success) {
            $(document).ready(function() {
                $("#modalAlertSuccess").modal("show");
            });
        }

        if (success_password) {
            $(document).ready(function() {
                $("#modalAlertSuccessPassword").modal("show");
            });
        }

        if (error) {
            $(document).ready(function() {
                $("#modalAlertError").modal("show");
            });
        }

        // SHOW MODAL REMOVE FACE
        $(document).on('click', '.modalConfirmDelete', function() {
            $('.id_delete').text($(this).data('id_delete'));
            $('#modalConfirmDelete').modal('show');
        });

        // create onchange event listener for foto input
        document.getElementById('foto').onchange = function(evt) {
            const [file] = this.files
            if (file) {
                // if there is an image, create a preview in image_preview
                document.getElementById('image_preview').src = URL.createObjectURL(file)
            }
        }

        // CHECK CURRENT PASSWORD
        function checkCurPass()
        {
            var token = document.getElementById('token');
            var id_pass = document.getElementById('id_pass');
            var curPassword = document.getElementById('current_password');
            var newPassword = document.getElementById('new_password');
            var confirmPassword = document.getElementById('confirm_password');
            var msg_cur_pass = document.getElementById('msg_cur_pass');
            var msg_new_pass = document.getElementById('msg_new_pass');
            var msg_con_pass = document.getElementById('msg_con_pass');

            var goodColor = "#66CC66";
            var badColor = "#FF6666";

            var formElement = document.getElementById("form_pass");
            var form = new FormData(formElement);
            form.append("id_pass", id_pass.value);
            form.append("password", curPassword.value);

            var settings = {
                "url": "http://localhost:8010/api/check_password/",
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

                if (parsed_data.status == true) {
                    curPassword.style.border = 'solid 1px';
                    curPassword.style.borderColor = goodColor;
                    msg_cur_pass.innerHTML = "";
                    newPassword.disabled = false;
                    confirmPassword.disabled = false;
                    document.getElementById("btn_simpan").disabled = false;

                    // CHECK PASSWORD
                    if (newPassword.value.length >= 8) {
                        newPassword.style.border = 'solid 1px';
                        newPassword.style.borderColor = goodColor;
                        msg_new_pass.innerHTML = "";
                        document.getElementById("btn_simpan").disabled = false;
                    } else if (newPassword.value.length < 8) {
                        newPassword.style.border = 'solid 1px';
                        newPassword.style.borderColor = badColor;
                        msg_new_pass.style.color = badColor;
                        msg_new_pass.innerHTML = "Password less than 8 characters!";
                        document.getElementById("btn_simpan").disabled = true;
                    } else {
                    }

                    // CHECK CONFIRM PASSWORD
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

                    if (confirmPassword.value.length < 8) {
                        confirmPassword.style.border = 'solid 1px';
                        confirmPassword.style.borderColor = badColor;
                        msg_con_pass.style.color = badColor;
                        msg_con_pass.innerHTML = "Password less than 8 characters!";
                        document.getElementById("btn_simpan").disabled = true;
                    }
                } else {
                    curPassword.style.border = 'solid 1px';
                    curPassword.style.borderColor = badColor;
                    msg_cur_pass.style.color = badColor;
                    msg_cur_pass.innerHTML = "Incorrect password!";
                    newPassword.disabled = true;
                    confirmPassword.disabled = true;
                    document.getElementById("btn_simpan").disabled = true;
                }
            });
        }

        // FACE ENROLLMENT
        Webcam.set({
            width: 550,
            height: 400,
            dest_width: 640,
            dest_height: 480,
            image_format: 'jpeg',
            jpeg_quality: 90,
            force_flash: false,
            flip_horiz: true,
            fps: 45
        });

        Webcam.attach('#camera');

        function dataURLtoFile(dataurl, filename) {
            var arr = dataurl.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[arr.length - 1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);
            while(n--){
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, {type:mime});
        }

        function take_snapshot() {
            Webcam.snap(function(foto) {
                document.querySelector(".image-tag").value = foto;

                var file = dataURLtoFile(foto, 'hello.jpeg');
                saveNewImageToFaceCollection(file);
            });
        };

        function renameSubject() {
            var old_subject = document.getElementById("old_username").value;
            var subject = document.getElementById("username").value;
            var apiKey = document.getElementById("apiKey").value;

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");
            myHeaders.append("x-api-key", apiKey);

            var raw = JSON.stringify({
                "subject": subject
            });

            var requestOptions = {
                method: 'PUT',
                headers: myHeaders,
                body: raw,
                redirect: 'follow'
            };

            fetch("http://localhost:8000/api/v1/recognition/subjects/" + old_subject, requestOptions)
                .then(response => response.text())
                .then(result => console.log(result))
                .catch(error => console.log('error', error));

        }

        function saveNewImageToFaceCollection(elem) {
            let subject = encodeURIComponent("{{ Session::get('username') }}");
            let apiKey = document.getElementById("apiKey").value;
            let formData = new FormData();

            formData.append("file", elem);

            fetch('http://localhost:8000/api/v1/recognition/faces/?subject=' + subject,
            {
                method: "POST",
                headers: {
                    "x-api-key": apiKey
                },
                body: formData
            }
            ).then(r => r.json()).then(
            function (data) {
                // console.log('New example was saved', data);

                const image_id = data['image_id'];

                let formData2 = new FormData();
                formData2.append("image_id", image_id);

                // SESSION PUT
                fetch("{{ url('profile/face_enroll') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Authorization': 'Bearer {{ Session::get('access_token') }}'
                    },
                    body: formData2,
                }).then(function(value) {
                    var base_url = window.location.origin;
                    window.location = base_url + "/profile";

                    // console.log(value);
                });
            })
            .catch(function (error) {
                // alert('Request failed: ' + JSON.stringify(error));
            });
        }

        function removeById() {
            var image_id = document.getElementById("image_id").value;
            var apiKey = document.getElementById("apiKey").value;

            var myHeaders = new Headers();
            myHeaders.append("x-api-key", apiKey);

            var requestOptions = {
                method: 'DELETE',
                headers: myHeaders,
                redirect: 'follow'
            };

            fetch("http://localhost:8000/api/v1/recognition/faces/" + image_id, requestOptions)
                .then(response => response.text())
                .then(result => console.log(result))
                .catch(error => console.log('error', error));
        }
    </script>
@endsection
