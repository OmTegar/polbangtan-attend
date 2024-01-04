// start: Sidebar
const sidebarToggle = document.querySelector('.sidebar-toggle')
const sidebarOverlay = document.querySelector('.sidebar-overlay')
const sidebarMenu = document.querySelector('.sidebar-menu')
const main = document.querySelector('.main')
sidebarToggle.addEventListener('click', function (e) {
    e.preventDefault()
    sidebarMenu.classList.toggle('-translate-x-full')
    sidebarOverlay.classList.toggle('hidden');
    main.classList.toggle('active');
})
sidebarOverlay.addEventListener('click', function (e) {
    e.preventDefault()
    main.classList.add('active')
    sidebarOverlay.classList.add('hidden')
    sidebarMenu.classList.add('-translate-x-full')
})
document.querySelectorAll('.sidebar-dropdown-toggle').forEach(function (item) {
    item.addEventListener('click', function (e) {
        e.preventDefault()
        const parent = item.closest('.group')
        if (parent.classList.contains('selected')) {
            parent.classList.remove('selected')
        } else {
            document.querySelectorAll('.sidebar-dropdown-toggle').forEach(function (i) {
                i.closest('.group').classList.remove('selected')
            })
            parent.classList.add('selected')
        }
    })
})
// end: Sidebar

// start: preloder
    // Aktifkan preloading saat dokumen dimuat
    window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        preloader.style.display = 'none'; // Menyembunyikan preloading
    });
// end: preloader

// start: Popper
const popperInstance = {}
document.querySelectorAll('.dropdown').forEach(function (item, index) {
    const popperId = 'popper-' + index
    const toggle = item.querySelector('.dropdown-toggle')
    const menu = item.querySelector('.dropdown-menu')
    menu.dataset.popperId = popperId
    popperInstance[popperId] = Popper.createPopper(toggle, menu, {
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, 8],
                },
            },
            {
                name: 'preventOverflow',
                options: {
                    padding: 24,
                },
            },
        ],
        placement: 'bottom-end'
    });
})
document.addEventListener('click', function (e) {
    const toggle = e.target.closest('.dropdown-toggle')
    const menu = e.target.closest('.dropdown-menu')
    if (toggle) {
        const menuEl = toggle.closest('.dropdown').querySelector('.dropdown-menu')
        const popperId = menuEl.dataset.popperId
        if (menuEl.classList.contains('hidden')) {
            hideDropdown()
            menuEl.classList.remove('hidden')
            showPopper(popperId)
        } else {
            menuEl.classList.add('hidden')
            hidePopper(popperId)
        }
    } else if (!menu) {
        hideDropdown()
    }
})

function hideDropdown() {
    document.querySelectorAll('.dropdown-menu').forEach(function (item) {
        item.classList.add('hidden')
    })
}
function showPopper(popperId) {
    popperInstance[popperId].setOptions(function (options) {
        return {
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: true },
            ],
        }
    });
    popperInstance[popperId].update();
}
function hidePopper(popperId) {
    popperInstance[popperId].setOptions(function (options) {
        return {
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: false },
            ],
        }
    });
}
// end: Popper

// start: remove active main
function handleMediaChange(mediaQuery) {
    const mainElement = document.querySelector('.main');
    
    if (mediaQuery.matches) {
      mainElement.classList.remove('active');
    } else {
      mainElement.classList.add('active');
    }
  }
  
  const mediaQuery = window.matchMedia('(min-width: 768px)');
  handleMediaChange(mediaQuery);
  mediaQuery.addListener(handleMediaChange);
  // end: remove active main

// start: Tab
document.querySelectorAll('[data-tab]').forEach(function (item) {
    item.addEventListener('click', function (e) {
        e.preventDefault()
        const tab = item.dataset.tab
        const page = item.dataset.tabPage
        const target = document.querySelector('[data-tab-for="' + tab + '"][data-page="' + page + '"]')
        document.querySelectorAll('[data-tab="' + tab + '"]').forEach(function (i) {
            i.classList.remove('active')
        })
        document.querySelectorAll('[data-tab-for="' + tab + '"]').forEach(function (i) {
            i.classList.add('hidden')
        })
        item.classList.add('active')
        target.classList.remove('hidden')
    })
})
// end: Tab

// // start: showpincode
// document.addEventListener('DOMContentLoaded', function() {
//     // Temukan elemen tombol dan elemen QR Code
//     const showPinCodeButton = document.getElementById("showPinCodeBtn");
//     const closePinCodeButton = document.getElementById("closePinCodeBtn");
//     const pinCodeElement = document.getElementById("pinCode");

//     // Tambahkan event listener untuk tombol "Show QR Code"
//     showPinCodeButton.addEventListener("click", function () {
//         // Tampilkan QR Code
//         pinCodeElement.classList.remove("hidden");
//     });

//     // Tambahkan event listener untuk tombol "Close QR Code"
//     closePinCodeButton.addEventListener("click", function () {
//         // Sembunyikan QR Code
//         pinCodeElement.classList.add("hidden");
//     });
// });
// // end: showkodeqr

// // start: kode pin
// const otpInputs = [...document.querySelectorAll(".otp-input")];

// otpInputs.forEach((input, index) => {
//     input.addEventListener("input", (e) => {
//         if (e.target.value.length > 1) {
//             e.target.value = e.target.value[0];
//         }
//         if (e.target.value && index < otpInputs.length - 1) {
//             otpInputs[index + 1].focus();
//         }
//         const allInputsFilled = otpInputs.every((input) => input.value);
//         // Jika semua input sudah terisi, submit form
//         if (allInputsFilled) {
//           document.getElementById('formpin').submit();
//         }
//     });

//     input.addEventListener("keydown", (e) => {
//         if (e.key === "Backspace" && index > 0 && !e.target.value) {
//             otpInputs[index - 1].focus();
//         }
//     });
// });
// // end: kode pin