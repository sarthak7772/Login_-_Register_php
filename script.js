
const authModal = document.querySelector('.auth-modal');
const loginBtn = document.querySelector('.login-btn-modal');
const closeBtn = document.querySelector('.close-btn-modal');
const loginForm = document.querySelector('.form-box.login');
const registerForm = document.querySelector('.form-box.register');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const avatarCircle = document.querySelector('.avatar-circle');
const profileBox = document.querySelector('.profile-box');

if (loginBtn) {
    loginBtn.addEventListener('click', () => {
        authModal.classList.add('active');
        loginForm.classList.add('active');
        registerForm.classList.remove('active');
    });
}

if (closeBtn) {
    closeBtn.addEventListener('click', () => {
        authModal.classList.remove('active');
        loginForm.classList.remove('active');
        registerForm.classList.remove('active');
    });
}

if (avatarCircle && profileBox) {
    avatarCircle.addEventListener('click', () => {
        profileBox.classList.toggle('show');
    });
}

if (registerLink) {
    registerLink.addEventListener('click', (e) => {
        e.preventDefault();
        loginForm.classList.remove('active');
        registerForm.classList.add('active');
        authModal.classList.add('active');
    });
}

if (loginLink) {
    loginLink.addEventListener('click', (e) => {
        e.preventDefault();
        registerForm.classList.remove('active');
        loginForm.classList.add('active');
        authModal.classList.add('active');
    });
}