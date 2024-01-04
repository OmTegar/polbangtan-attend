document.addEventListener('DOMContentLoaded', function() {
    // Temukan elemen tombol dan elemen QR Code
    const showScanCamButton = document.getElementById("showScanCamBtn");
    const closeScanCamButton = document.getElementById("closeScanCamBtn");
    const ScanCamElement = document.getElementById("scanCam");

    // Tambahkan event listener untuk tombol "Show QR Code"
    showScanCamButton.addEventListener("click", function() {
        // Tampilkan QR Code
        ScanCamElement.classList.remove("hidden");
    });

    closeScanCamButton.addEventListener("click", function() {
        // Sembunyikan QR Code
        ScanCamElement.classList.add("hidden");
    });
});


function populateCameraOptions(cameras) {
const cameraDropdown = document.getElementById('camera');

cameras.forEach((camera, index) => {
    const option = document.createElement('option');
    option.value = index;
    option.text = camera.name;
    cameraDropdown.appendChild(option);
});
}


document.getElementById('showScanCamBtn').addEventListener('click', function() {
let scanner = new Instascan.Scanner({
    video: document.getElementById('preview'), mirror: false
});

scanner.addListener('scan', function(content) {
    console.log(content);
});

Instascan.Camera.getCameras().then(function(cameras) {
    if (cameras.length > 0) {
        populateCameraOptions(cameras);
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

// Add an event listener to the "camera" dropdown to change the active camera
document.getElementById('camera').addEventListener('change', function() {
    const selectedCameraIndex = this.value;
    scanner.stop(); // Stop the current scanner
    Instascan.Camera.getCameras().then(function(cameras) {
        scanner.start(cameras[selectedCameraIndex]); // Start the selected camera
    });
});

// Add an event listener to the "closeScanCamBtn" button to stop the camera
document.getElementById('closeScanCamBtn').addEventListener('click', function() {
    if (scanner) {
        scanner.stop(); // Stop the scanner to close the camera
    }
});
});