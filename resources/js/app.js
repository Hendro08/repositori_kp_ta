import "./bootstrap";

// LOGIN
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.querySelector(".toggle-password-btn");
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.querySelector(".toggle-icon");
    if (toggleBtn) {
        toggleBtn.addEventListener("click", function () {
            const type =
                passwordInput.getAttribute("type") === "password"
                    ? "text"
                    : "password";
            passwordInput.setAttribute("type", type);

            // Toggle icon
            if (type === "password") {
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            } else {
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            }
        });
    }
});

// REGISTER
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtns = document.querySelectorAll(".toggle-password-btn");
    toggleBtns.forEach(function (toggleBtn) {
        toggleBtn.addEventListener("click", function () {
            const targetId = this.getAttribute("data-target");
            const passwordInput = document.getElementById(targetId);
            const icon = this.querySelector("i");
            const type =
                passwordInput.getAttribute("type") === "password"
                    ? "text"
                    : "password";
            passwordInput.setAttribute("type", type);
            if (type === "password") {
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        });
    });
});
