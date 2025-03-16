const userIcon = document.getElementById("userIcon");
const userModal = document.getElementById("userModal");
const showRegister = document.getElementById("showRegister");
const showLogin = document.getElementById("showLogin");
const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");
const aboutUs = document.getElementById("aboutus");
const banners = document.getElementById("banners");
const homeLink = document.getElementById("homeLink");
const aboutUsLink = document.getElementById("aboutUsLink");
const contactUsLink = document.getElementById("contactUsLink");

userIcon.addEventListener("click", () => {
    userModal.style.display = "flex";
});

window.addEventListener("click", (event) => {
    if (event.target === userModal) {
        userModal.style.display = "none";
    }
});

showRegister.addEventListener("click", () => {
    loginForm.style.display = "none";
    registerForm.style.display = "block";
});

showLogin.addEventListener("click", () => {
    registerForm.style.display = "none";
    loginForm.style.display = "block";
});

homeLink.addEventListener("click", (e) => {
    e.preventDefault();
    banners.style.display = "flex";
    aboutUs.style.display = "none";
    contactUsLink.style.display = "none";
});

aboutUsLink.addEventListener("click", (e) => {
    e.preventDefault();
    banners.style.display = "none";
    aboutUs.style.display = "flex";
     contactUsLink.style.display = "none";

});

contactUsLink.addEventListener("click", (e) => {
    e.preventDefault();
    banners.style.display = "none";
    aboutUs.style.display = "none";
    contactUsLink.style.display = "flex";

});