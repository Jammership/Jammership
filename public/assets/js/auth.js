let isLoggedIn = false;

function checkLoginStatus() {
    if (sessionStorage.getItem('username')) {
        isLoggedIn = true;
    } else {
        isLoggedIn = false;
    }
    return isLoggedIn;
}

document.addEventListener('DOMContentLoaded', async function () {
    checkLoginStatus()

    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const showRegisterLink = document.getElementById('show-register');
    const showLoginLink = document.getElementById('show-login');
    const loginSection = document.getElementById('login-section');
    const registerSection = document.getElementById('register-section');
    const authContainer = document.getElementById('auth-container');
    const mainContainer = document.getElementById('main-container')

    if (isLoggedIn) {
        authContainer.style.display = 'none';
        mainContainer.style.display = 'block';
    } else {
        authContainer.style.display = 'block';
        mainContainer.style.display = 'none';
    }

    showRegisterLink.addEventListener('click', function (e) {
        e.preventDefault();
        loginSection.style.display = 'none';
        registerSection.style.display = 'block';
    });

    showLoginLink.addEventListener('click', function (e) {
        e.preventDefault();
        registerSection.style.display = 'none';
        loginSection.style.display = 'block';
    });

    registerForm.addEventListener('submit', function (event) {
        register(event, registerForm, registerSection, loginSection)
    });

    loginForm.addEventListener('submit', function (event) {
        login(event, authContainer)
    });
});

function logoutUser(redirectUrl = null) {
    const formData = new FormData();
    formData.append('action', 'logout');

    fetch('auth_handler.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                sessionStorage.clear();
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                } else {
                    window.location.reload();
                }
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Logout error:', error);
        });
}

function login(event, authContainer) {
    event.preventDefault();

    const username = document.getElementById('login-username').value;
    const password = document.getElementById('login-password').value;
    const userType = document.getElementById('login-user-type').value;

    const formData = new FormData();
    formData.append('action', 'login');
    formData.append('username', username);
    formData.append('password', password);
    formData.append('userType', userType);

    fetch('auth_handler.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data)
            if (data.success) {
                authContainer.style.display = 'none';

                // Store user info in sessionStorage
                sessionStorage.setItem('id', data.user['id']);
                sessionStorage.setItem('role', data.user['role']);
                sessionStorage.setItem('username', data.user['username']);
                window.location.href = 'dashboard.php';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again later.');
        });
}

function register(event, registerForm, registerSection, loginSection) {
    event.preventDefault();

    console.log('Registering...');
    const username = document.getElementById('register-username').value;
    const email = document.getElementById('register-email').value;
    const password = document.getElementById('register-password').value;
    const userType = document.getElementById('register-user-type').value;

    console.log(username, email, password, userType);

    if (!validateEmail(email)) {
        alert('Please enter a valid email address');
        return;
    }

    if (password.length <= 0) {
        alert('Password must be at least 8 characters long');
        return;
    }

    const formData = new FormData();
    formData.append('action', 'register');
    formData.append('username', username);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('userType', userType);

    const promise = fetch('auth_handler.php', {
        method: 'POST',
        body: formData
    });


    promise.then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            registerForm.reset();
            registerSection.style.display = 'none';
            loginSection.style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again later.');
    });
}

function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}