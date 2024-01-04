<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-Absen Asrama Polbangtan-mlg</title>
    <link rel="icon" href="{{ asset('img/logo-asrama.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-200">
    <div class="container mx-auto">
        <div class="bg-white shadow-lg w-[500px] rounded p-5 mx-auto mt-12">
            <select name="camera" id="camera">
                <option value="">Pilih Kamera</option>
            </select>
            <video id="preview"></video>

            @if (session()->has('success'))
                <div class="bg-green-500 text-white rounded-lg p-3 mb-5">
                    <p class="text-sm">{{ session()->get('success') }}</p>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-500 text-white rounded-lg p-3 mb-5">
                    <p class="text-sm">{{ session()->get('error') }}</p>
                </div>
            @endif


            {{-- Hiden Form --}}
            <form action="{{ route('presense.api') }}" method="post" id="form">
                @csrf
                <input type="hidden" name="user_id" id="user_id">
                <input type="hidden" name="date" id="date">
                <input type="hidden" name="time" id="time">
                <input type="hidden" name="status" id="status">
            </form>
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="border-b px-4 py-2">id</th>
                        <th class="border-b px-4 py-2">user_id</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-b px-4 py-2">oke</td>
                        <td class="border-b px-4 py-2">oke</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });

        scanner.addListener('scan', function(content) {
            console.log(content);
        });

        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
        });

        scanner.addListener('scan', function(content) {
            try {
                const data = JSON.parse(content);

                document.getElementById('user_id').value = data.user_id;
                document.getElementById('date').value = data.date;
                document.getElementById('time').value = data.time;
                document.getElementById('status').value = data.status;
                document.getElementById('form').submit();
            } catch (error) {
                console.error('Error parsing JSON:', error);
            }
        });
    </script>
</body>

</html>
