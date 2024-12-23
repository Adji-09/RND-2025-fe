@extends('layouts.master-without-nav')

@section('title') Login @endsection

@section('content')
    <label for="apiKey">API key:</label><input id="apiKey" value="0a97a36c-021e-4c6c-bac7-eb021d3f7b6b" />
    <button onclick="video()">video</button>
    <video id="live" width="640" height="480" autoplay style="display:none;"></video>
    <canvas width="640" id="canvas" height="480" style="display:none;"></canvas>
    <canvas width="640" id="canvas2" height="480"></canvas>

    <script type="text/javascript">
        function video() {
            let video = document.getElementById("live");
            let canvas = document.getElementById("canvas");
            let canvas2 = document.getElementById("canvas2");
            let ctx = canvas.getContext('2d');
            let ctx2 = canvas2.getContext('2d');
            let apiKey = document.getElementById("apiKey").value;

            navigator.mediaDevices.getUserMedia({
                video: {width: 640, height: 480}
            }).then(function (stream) {
                video.srcObject = stream;

                document.addEventListener("next_frame", draw);

                const evt = new Event("next_frame", {"bubbles": true, "cancelable": false});
                document.dispatchEvent(evt);
            });

            function draw() {
                ctx.drawImage(video, 0, 0, 640, 480);
                canvas.toBlob(function (blob) {
                    blob.name = "blob.jpeg"
                    let fd = new FormData();
                    fd.append('file', blob, "blob.jpeg");

                    fetch('http://localhost:8000/api/v1/recognition/recognize',
                        {
                            method: "POST",
                            headers: {
                                "x-api-key": apiKey
                            },
                            body: fd
                        }
                    ).then(r => r.json()).then(
                        function (data) {
                            const evt = new Event("next_frame", {"bubbles": true, "cancelable": false});
                            document.dispatchEvent(evt);
                            ctx2.clearRect(0, 0, 640, 480);
                            ctx2.drawImage(video, 0, 0, 640, 480);
                            if (!data.result) {
                                return;
                            }
                            let box = data.result[0].box;
                            let name = data.result[0].subjects[0].subject;
                            ctx2.lineWidth = 3;
                            ctx2.strokeStyle = 'green';
                            ctx2.strokeRect(box.x_min, box.y_min, box.x_max - box.x_min, box.y_max - box.y_min);
                            ctx2.font = '24px serif';
                            ctx2.strokeText(name, box.x_min, box.y_min - 20);
                        });
                }, 'image/jpeg', 0.95);
            }

        }


    </script>
@endsection
