// Dapatkan tombol dropdown radio
const dropdownRadioButton = $('#dropdownRadioButton');

// Dapatkan semua radio button dengan name="filter-radio"
const filterRadioButtons = $('input[name="filter-radio"]');

// Tambahkan event listener ke semua radio button
filterRadioButtons.on('change', function() {
  // Dapatkan nilai radio button yang dipilih
  const selectedFilterRadioValue = $(this).val();

  // Dapatkan teks radio button yang dipilih
  const selectedFilterRadioLabel = $(this).next('label').text();

  // Ubah teks tombol dropdown radio
  dropdownRadioButton.find('span#filterLabel').text(selectedFilterRadioLabel);
});


document.addEventListener("DOMContentLoaded", function () {
    const selectElement = document.getElementById("filterSelect"); // Ganti "filterSelect" dengan ID elemen select Anda.

    selectElement.addEventListener("change", function () {
        this.form.submit();
    });
});

