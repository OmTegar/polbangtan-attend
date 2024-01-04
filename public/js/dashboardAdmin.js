// start: Chart
// Menghitung tanggal 7 hari ke belakang dari hari ini
var today = new Date();
var labels = [];
for (var i = 6; i >= 0; i--) {
    var date = new Date(today);
    date.setDate(today.getDate() - i);
    var monthName = date.toLocaleDateString(undefined, { month: 'long' }); // Mengambil nama bulan
    var day = date.getDate(); // Mengambil hari
    labels.push(monthName + ' ' + day);
}

const apiUrl = '/getDataPresenceUserLast7Days'

fetch(apiUrl)
    .then((response) => response.json())
    .then((data) => {
        var data = {
            labels: labels, // Menggunakan label tanggal yang telah dihitung
            datasets: [{
                label: 'Siswa',
                data: data.data, // Gantilah dengan data izin siswa dalam 7 hari terakhir
                backgroundColor: 'rgba(255, 99, 132, 0.2)', // Warna area dalam grafik
                borderColor: 'rgba(255, 99, 132, 1)', // Warna garis tepi dalam grafik
                borderWidth: 1
            }]
        };
       
        // Konfigurasi grafik
        var config = {
            type: 'line', // Jenis grafik (line chart)
            data: data,
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
       
        // Membuat grafik
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, config);
    });

 // Data contoh (gantilah dengan data Anda)
 
// end: Chart