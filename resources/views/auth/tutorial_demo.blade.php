@extends('layouts.master-without-nav')

@section('title') Login @endsection

@section('content')
    <label for="apiKey">API key:</label><input id="apiKey" value="0a97a36c-021e-4c6c-bac7-eb021d3f7b6b" />
    <div></div>
    <label for="subject">Subject:</label><input id="subject" value="" />


    <div>Click to add photo:</div>
    {{-- <input type=file id="newFace" onchange="saveNewImageToFaceCollection(this)" /> --}}
    <div id="camera"></div>
    <br />
    <button type="button" class="btn btn-primary btn-sm" onClick="take_snapshot()">Ambil Foto</button>
    <input type="text" name="images" class="image-tag">


    <div>Click to recognize photo</div>
    <input type=file id="recognizeFace" onchange="recognizeFace(this)" />
    <div>Result:</div>
    <div id="result"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

    <script type="text/javascript">
        // FACE ENROLLMENT
        Webcam.set({
            width: 320,
            height: 240,
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

                var file = dataURLtoFile(foto,'hello.jpeg');
                saveNewImageToFaceCollection(file);
            });
        };

        function saveNewImageToFaceCollection(elem) {
            let subject = encodeURIComponent(document.getElementById("subject").value);
            let apiKey = document.getElementById("apiKey").value;
            let formData = new FormData();
            // let photo = elem.files[0];

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
                    console.log('New example was saved', data);
                })
                .catch(function (error) {
                    alert('Request failed: ' + JSON.stringify(error));
                });
        }

        function recognizeFace(elem) {
            let apiKey = document.getElementById("apiKey").value;
            let formData = new FormData();
            let photo = elem.files[0];

            formData.append("file", photo);

            fetch('http://localhost:8000/api/v1/recognition/recognize',
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
                })
                .catch(function (error) {
                    alert('Request failed: ' + JSON.stringify(error));
                });
        }
    </script>
@endsection
