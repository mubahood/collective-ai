<!DOCTYPE html>
<html>
<head>
    <title>Upload Video and Record Audio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .alert-danger {
            background-color: #ffdddd;
            border: 1px solid #ff0000;
            color: #ff0000;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #28a745;
            color: #28a745;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        input[type="file"] {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>Upload Video and Record Audio</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Audio Recording UI -->
    <button id="startRecord">Start Recording</button>
    <button id="stopRecord" style="display: none;">Stop Recording</button>
    <audio id="audioPlayer" controls></audio>

    <!-- Video Upload Form -->
    <form method="POST" action="" enctype="multipart/form-data">
        @csrf

        <!-- Video Upload Input -->
        <div>
            <label for="video">Upload Video:</label>
            <input type="file" name="video" id="video" accept="video/*">
        </div>

        <!-- Hidden Field for Recorded Audio -->
        <input type="hidden" name="audio" id="audioInput">

        <button type="submit">Upload Video and Audio</button>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/recorderjs/1.1.2/recorder.min.js"></script>
    <script>
        const startButton = document.getElementById('startRecord');
        const stopButton = document.getElementById('stopRecord');
        const audioPlayer = document.getElementById('audioPlayer');

        let audioContext = new AudioContext();
        let mediaRecorder;
        let audioChunks = [];

        startButton.addEventListener('click', async () => {
            mediaRecorder = new MediaRecorder(await navigator.mediaDevices.getUserMedia({ audio: true }));

            mediaRecorder.ondataavailable = (e) => {
                if (e.data.size > 0) {
                    audioChunks.push(e.data);
                }
            };

            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                audioPlayer.src = URL.createObjectURL(audioBlob);

                // Set the recorded audio data in the hidden input field
                const audioInput = document.getElementById('audioInput');
                const reader = new FileReader();
                reader.onload = function (event) {
                    audioInput.value = event.target.result;
                };
                reader.readAsDataURL(audioBlob);
            };

            mediaRecorder.start();
            startButton.style.display = 'none';
            stopButton.style.display = 'inline';
        });

        stopButton.addEventListener('click', () => {
            mediaRecorder.stop();
            startButton.style.display = 'inline';
            stopButton.style.display = 'none';
        });
    </script>
</body>
</html>
