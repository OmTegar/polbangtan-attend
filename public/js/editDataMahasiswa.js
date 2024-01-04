document.addEventListener("DOMContentLoaded", function () {
    const showPopupButton = document.getElementById("showPopup");
    const closePopupButton = document.getElementById("closePopup");
    const popup = document.getElementById("popup");

    showPopupButton.addEventListener("click", function () {
        popup.classList.remove("hidden");
    });

    closePopupButton.addEventListener("click", function () {
        popup.classList.add("hidden");
    });
});