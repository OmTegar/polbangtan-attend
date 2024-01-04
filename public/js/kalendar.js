// start: kalender
var keluar = [];

  document.addEventListener('DOMContentLoaded', function() {
    fetch('/get-presence-date')
        .then(response => response.json())
        .then(data => {
            data.forEach(date => {
                keluar.push({
                    title: 'Keluar',
                    start: date.presence_date,
                });
            });
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                height: 450,
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next', // Hanya menyertakan tombol prev dan next
                    center: 'title',
                    right: ''
                },
                events: keluar, // Menggabungkan array masuk dan keluar
                eventContent: function(arg) {
                    var eventEl = document.createElement('div');
                    eventEl.innerHTML = arg.event.title;
                
                    // Menggunakan kelas-kelas Tailwind untuk mengatur tampilan
                    eventEl.className = ' px-1 text-white text-center text-sm';
                
                    // Atur warna latar belakang dan teks berdasarkan judul acara
                    eventEl.classList.add('bg-red-500')
                
                    return { domNodes: [eventEl] };
                }
            });
            calendar.render();
        });
        // .then(data => {
        //     keluar = data.map(date => ({
        //         title: 'Keluar',
        //         start: date.presence_date,
        //     }))
        // });

        
 });
// end: kalender