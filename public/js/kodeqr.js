document.addEventListener('DOMContentLoaded', function() {
    // Temukan elemen tombol dan elemen QR Code
    const showQRCodeButton = document.getElementById("showQRCodeBtn");
    const closeQRCodeButton = document.getElementById("closeQRCodeBtn");
    const qrCodeElement = document.getElementById("qrCode");

    // Tambahkan event listener untuk tombol "Show QR Code"
    showQRCodeButton.addEventListener("click", function () {
        // Tampilkan QR Code
        qrCodeElement.classList.remove("hidden");
    });

    // Tambahkan event listener untuk tombol "Close QR Code"
    closeQRCodeButton.addEventListener("click", function () {
        // Sembunyikan QR Code
        qrCodeElement.classList.add("hidden");
    });
});