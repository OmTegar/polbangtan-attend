function showTab(tabName, button) {
    // Hide all tabs
    var tabs = document.getElementsByClassName("tab-content");
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].style.display = "none";
    }

    // Remove active class from all buttons
    var buttons = document.getElementsByTagName("button");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove("text-utama", "border-b-2", "border-utama");
        buttons[i].classList.add("text-gray-500", "hover:text-utama", "hover:border-utama", "hover:border-b", "transition-all", "duration-500", "ease-in-out");
    }

    // Show the selected tab
    document.getElementById(tabName + "Tab").style.display = "block";
    document.getElementById(tabName).style.display = "block";

    // Add active class to the clicked button
    button.classList.add("text-utama", "border-b-2", "border-utama");
    button.classList.remove("text-gray-500", "hover:text-utama", "hover:border-utama", "hover:border-b", "transition-all", "duration-500", "ease-in-out");
}

document.addEventListener('DOMContentLoaded', function () {
    var uploadForm = document.getElementById('importForm');
    var loadingAnimation = document.getElementById('loadingAnimation');

    uploadForm.addEventListener('submit', function () {
        loadingAnimation.classList.remove('hidden');
    });
});