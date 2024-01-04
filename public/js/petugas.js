document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-button');
    const popup = document.getElementById('editPopup');
    const closePopupButton = document.getElementById('closeEditPopup');
    const petugas1Select = document.getElementById('petugas1');
    const petugas2Select = document.getElementById('petugas2');

    editButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // Mendapatkan ID petugas dari data attribute
            const petugasId = button.dataset.petugasId;

            // Menyimpan ID petugas pada elemen select (opsional)
            petugas1Select.dataset.petugasId = petugasId;
            petugas2Select.dataset.petugasId = petugasId;

            // Menampilkan ID petugas pada console (ubah sesuai kebutuhan)
            console.log('ID Petugas:', petugasId);

            // ... Lakukan manipulasi data atau tindakan lainnya di sini ...

            // Menampilkan popup
            popup.classList.remove('hidden');
        });
    });

    // Tambahkan event listener untuk tombol penyimpanan di dalam popup (opsional)
    // ...

    // Menambahkan event listener untuk tombol penutup popup
    closePopupButton.addEventListener('click', function () {
        popup.classList.add('hidden');
    });
});
