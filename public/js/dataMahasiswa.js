// dataMahasiswa.js

var csrfToken = $('meta[name="csrf-token"]').attr('content');


$(document).ready(function() {
    function updateNomorRuangan(data) {
        var nomorRuanganDropdown = $('#nomor_ruangan');
        nomorRuanganDropdown.empty();
        nomorRuanganDropdown.append('<option selected hidden>Pilih Ruangan</option>');
        
        $.each(data, function(index, nomorRuangan) {
            nomorRuanganDropdown.append('<option value="' + nomorRuangan + '">' + nomorRuangan + '</option>');
        });
    }

    function updateTable(data) {
        var tableBody = $('#result');
        tableBody.empty();

        $.each(data, function(index, mahasiswa) {
            var blokRuanganName = mahasiswa.blok.name;
            var kelasName = mahasiswa.kelas.nama_kelas;
            var row = '<tr class="bg-white border-b">' +
                '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">' + (index + 1) + '</th>' +
                '<td class="px-6 py-4">' + mahasiswa.nim + '</td>' +
                '<td class="px-6 py-4">' + mahasiswa.name + '</td>' +
                '<td class="px-6 py-4">' + kelasName + '</td>' +
                '<td class="px-6 py-4">' + blokRuanganName + mahasiswa.no_kamar + '</td>' +
                '<td class="px-6 py-4">' + mahasiswa.no_hp + '</td>' +
                '<td class="px-6 py-4">' +
                '<div class="flex gap-1">' +
                '<a href="/data-mahasiswa/edit/' + mahasiswa.id + '" class="bg-utama text-white rounded p-2">Edit</a>' +
                '<form action="/data-mahasiswa/' + mahasiswa.id + '" method="post">' +
                '<input type="hidden" name="_method" value="DELETE">' +
                '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                '<button class="bg-red-500 text-white rounded p-2">Hapus</button>' +
                '</form>' +
                '</div>' +
                '</td>' +
                '</tr>';

            tableBody.append(row);
        });
    }

    $('#blok_ruangan').change(function() {
        var blokRuangan = $('#blok_ruangan').val();
        $.ajax({
            type: 'post',
            url: '/data-mahasiswa/get-nomor-ruangan',
            data: {
                blok_ruangan: blokRuangan,
                _token: csrfToken
            },
            success: function(data) {
                updateNomorRuangan(data);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('#blok_ruangan').change(function() {
        var blokRuangan = $('#blok_ruangan').val();
        $.ajax({
            type: 'post',
            url: '/data-mahasiswa/search-blokruangan',
            data: {
                blok_ruangan: blokRuangan,
                _token: csrfToken
            },
            success: function(data) {
                updateTable(data);
            }
        });
    });

    $('#nomor_ruangan').change(function() {
        var blokRuangan = $('#blok_ruangan').val();
        var nomorRuangan = $('#nomor_ruangan').val();
        $.ajax({
            type: 'post',
            url: '/data-mahasiswa/search-mahasiswa-by-data',
            data: {
                blok_ruangan: blokRuangan,
                nomor_ruangan: nomorRuangan,
                _token: csrfToken
            },
            success: function(data) {
                updateTable(data);
            }
        });
    });

    $(document).ready(function() {
        $('#search-form').submit(function(event) {
            event.preventDefault(); // Menghentikan aksi standar formulir
    
            var searchTerm = $('#search-input').val();
    
            // Mengirim permintaan pencarian menggunakan AJAX
            $.ajax({
                type: 'post',
                url: '/data-mahasiswa/searchbar-mahasiswa', // Ganti dengan URL endpoint pencarian di server Anda
                data: {
                    search_term: searchTerm,
                    _token: csrfToken
                },
                success: function(data) {
                    // Lakukan sesuatu dengan hasil pencarian, misalnya memperbarui tampilan atau tabel
                    updateTable(data);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });    
});
