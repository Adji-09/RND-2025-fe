@extends('layouts.master-without-nav')

@section('title') Login @endsection

@section('content')
    <div class="auth-page-wrapper auth-bg-cover d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <div class="auth-page-content overflow-hidden">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        <div class="card mt-4 card-bg-fill">

                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <a class="btn btn-dark btn-label waves-effect waves-light" href="{{ route('login') }}"><i class="ri-arrow-left-s-line label-icon align-middle fs-16 me-2"></i> Back</a>
                                    </div>
                                    <div class="text-primary" style="font-weight: bold; font-size: 20px;">
                                        <center>Login with Face Recognition</center>
                                    </div>
                                </div>
                                <div class="p-2 mt-2">
                                    <input type="hidden" id="apiKey" value="0a97a36c-021e-4c6c-bac7-eb021d3f7b6b" />
                                    <input type="hidden" name="images" class="image-tag">
                                    <div id="camera" class="mb-1"></div>
                                    <div class="mt-3 text-center">
                                        <button type="button" class="btn btn-success btn-label w-50 waves-effect waves-light" onclick="take_snapshot()">
                                            <i class="ri-body-scan-fill label-icon align-middle fs-20 me-2"></i> Login
                                        </button>
                                    </div>
                                    <div id="result" hidden></div>
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

        @include('components.alert_error_face')
    </div>

    <script src="{{ URL::asset('assets/js/webcam.min.js') }}"></script>

    <script type="text/javascript">
        // FACE RECOGNITION
        Webcam.set({
            width: 575,
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
                recognizeFace(file);
            });
        };

        function recognizeFace(elem) {
            let apiKey = document.getElementById("apiKey").value;
            let formData = new FormData();

            formData.append("file", elem);

            fetch('http://localhost:8000/api/v1/recognition/recognize?limit=0&det_prob_threshold=0.8&prediction_count=1&face_plugins=landmarks,gender,age,calculator,mask,pose&status=true',
            {
                method: "POST",
                headers: {
                    "x-api-key": apiKey
                },
                body: formData
            }
            ).then(r => r.json()).then(
            function (data) {
                document.getElementById("result").innerHTML = JSON.stringify(data);

                // console.log(data);
                // console.log(data['result'][0]['subjects'][0]['subject']);
                // console.log(data['result'][0]['subjects'][0]['similarity']);

                if (data['code'] == 28) {
                    $(document).ready(function() {
                        $("#modalAlertErrorFace").modal("show");
                        $("#modalAlertErrorFace .text-muted").text(data['message']);
                    });
                } else {
                    let formData2 = new FormData();
                    formData2.append("subject", data['result'][0]['subjects'][0]['subject']);
                    formData2.append("similar", data['result'][0]['subjects'][0]['similarity']);

                    fetch('http://localhost:8010/api/login_face',
                    {
                        method: "POST",
                        headers: {
                            'Authorization': 'Bearer {{ Session::get('access_token') }}'
                        },
                        body: formData2
                    }
                    ).then(r2 => r2.json()).then(
                    function (data2) {
                        // console.log(data2);

                        const status_api = data2['status'];

                        if (status_api == true) {
                            const status = data2['status'];
                            const message = data2['message'];
                            const id = data2['data']['id'];
                            const username = data2['data']['username'];
                            const email = data2['data']['email'];
                            const foto = data2['data']['foto'];
                            const role_id = data2['data']['role_id'];
                            const role = data2['data']['role'];
                            const status_user = data2['data']['status'];
                            const access_token = data2['headers']['access_token'];

                            let formData3 = new FormData();
                            formData3.append("status", status);
                            formData3.append("message", message);
                            formData3.append("id", id);
                            formData3.append("username", username);
                            formData3.append("email", email);
                            formData3.append("foto", foto);
                            formData3.append("role_id", role_id);
                            formData3.append("role", role);
                            formData3.append("status_user", status_user);
                            formData3.append("access_token", access_token);

                            // SESSION PUT
                            fetch("{{ url('post-login-face') }}", {
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                    'Authorization': 'Bearer {{ Session::get('access_token') }}'
                                },
                                body: formData3,
                            }).then(function(value) {
                                var base_url = window.location.origin;
                                window.location = base_url + "/dashboard";

                                // console.log(value);
                            });
                        } else {
                            const message = data2['message'];

                            $(document).ready(function() {
                                $("#modalAlertErrorFace").modal("show");
                                $("#modalAlertErrorFace .text-muted").text(message);
                            });
                        }
                    })
                    .catch(function (error2) {
                        // alert('Request failed: ' + JSON.stringify(error2));
                    });
                }
            })
            .catch(function (error) {
                // alert('Request failed: ' + JSON.stringify(error));
            });
        }
    </script>
@endsection
