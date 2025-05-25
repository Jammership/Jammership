let isLoggedIn = false;

function checkLoginStatus() {
    // sessionStorage is client-side only, not a secure way to "prove" login status
    // but can be used for UI hinting.
    if (sessionStorage.getItem('username')) {
        isLoggedIn = true;
    } else {
        isLoggedIn = false;
    }
    return isLoggedIn;
}

document.addEventListener('DOMContentLoaded', async function () {
    checkLoginStatus(); // Updates the global isLoggedIn based on sessionStorage

    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const showRegisterLink = document.getElementById('show-register');
    const showLoginLink = document.getElementById('show-login');
    const loginSection = document.getElementById('login-section');
    const registerSection = document.getElementById('register-section');
    const authContainer = document.getElementById('auth-container');
    const mainContainer = document.getElementById('main-container');

    // This UI toggle is for when Auth.php loads.
    // If PHP session was active, user would have been redirected.
    // This handles cases where sessionStorage might still exist (e.g., tab reopened).
    if (isLoggedIn) {
        authContainer.style.display = 'none';
        mainContainer.style.display = 'block';
    } else {
        authContainer.style.display = 'block';
        mainContainer.style.display = 'none';
    }

    if (showRegisterLink) {
        showRegisterLink.addEventListener('click', function (e) {
            e.preventDefault();
            loginSection.style.display = 'none';
            registerSection.style.display = 'block';
        });
    }

    if (showLoginLink) {
        showLoginLink.addEventListener('click', function (e) {
            e.preventDefault();
            registerSection.style.display = 'none';
            loginSection.style.display = 'block';
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', function (event) {
            register(event, registerForm, registerSection, loginSection);
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            login(event, authContainer, mainContainer); // Pass mainContainer for UI update
        });
    }
});

function login(event, authContainer, mainContainer) {
    event.preventDefault();

    const username = document.getElementById('login-username').value;
    const password = document.getElementById('login-password').value;
    const userType = document.getElementById('login-user-type').value;

    const formData = new FormData();
    formData.append('action', 'login');
    formData.append('username', username);
    formData.append('password', password);
    formData.append('userType', userType);

    // Path is relative to where auth.js is (Jammership/api/)
    // So, ../public/auth_handler.php
    fetch('../public/auth_handler.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Store user info in sessionStorage (for UI convenience)
                sessionStorage.setItem('id', data.user.id);
                sessionStorage.setItem('role', data.user.role);
                sessionStorage.setItem('username', data.user.username);
                sessionStorage.setItem('email', data.user.email); // Assuming email is returned

                // Redirect to dashboard
                // Path is relative to where auth.js is (Jammership/api/)
                // So, ../public/dashboard.php
                window.location.href = '../public/dashboard.php';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred during login. Please try again later.');
        });
}

function register(event, registerForm, registerSection, loginSection) {
    event.preventDefault();

    const username = document.getElementById('register-username').value;
    const email = document.getElementById('register-email').value;
    const password = document.getElementById('register-password').value;
    const userType = document.getElementById('register-user-type').value;

    if (!username.trim()) {
        alert('Username is required.');
        return;
    }
    if (!validateEmail(email)) {
        alert('Please enter a valid email address.');
        return;
    }
    // Corrected password length check to match server-side (at least 8 characters)
    if (password.length < 8) {
        alert('Password must be at least 8 characters long.');
        return;
    }

    const formData = new FormData();
    formData.append('action', 'register');
    formData.append('username', username);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('userType', userType);

    // Path is relative to where auth.js is (Jammership/api/)
    // So, ../public/auth_handler.php
    fetch('../public/auth_handler.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            // Clone the response stream. response.json() and response.text() consume the body,
            // so if the first attempt fails, we need a way to read it again.
            const responseClone = response.clone();

            return response.json() // Attempt to parse the response body as JSON
                .catch(jsonParseError => {
                    // This block executes if response.json() fails (e.g., not valid JSON)
                    // We'll try to get the raw text body instead.
                    return responseClone.text().then(textBody => {
                        // Log the raw text body because JSON parsing failed
                        console.error("Failed to parse server response as JSON. Status:", response.status, "Raw text:", textBody);

                        // Create a new error to be caught by the main .catch() block,
                        // including the original parsing error and the text body for context.
                        const error = new Error(`Server returned a non-JSON response (Status: ${response.status}). Check console for raw text.`);
                        error.isJsonParseError = true; // Custom flag
                        error.originalError = jsonParseError; // The actual error from .json()
                        error.responseText = textBody; // The raw text
                        error.status = response.status;
                        throw error; // Propagate this more informative error
                    });
                });
        })
        .then(data => { // This block executes if response.json() was successful
            alert(data.message); // Show the server's message to the user

            if (data.success) {
                registerForm.reset();
                registerSection.style.display = 'none';
                loginSection.style.display = 'block';
            } else {
                // data.success is false, meaning the server processed the request
                // but indicated a failure (e.g., validation error, email taken).
                // Log the entire JSON response from the server for debugging.
                console.error('Server reported an error (data.success === false):', data);
            }
        })
        .catch(error => {
            // This catches:
            // 1. Network errors (fetch itself failed, e.g., server down, CORS issue not handled by server)
            // 2. The custom error thrown if .json() failed (it will have 'isJsonParseError' flag)
            // 3. Any other unexpected errors in the .then() chain.

            console.error('Error during registration:', error); // Log the full error object

            // Provide a user-friendly alert
            if (error.isJsonParseError) {
                // We already logged the raw text when the error was created.
                // Alert the custom message we created.
                alert(error.message);
            } else if (error.message && error.message.includes("Failed to fetch")) {
                // This is a common message for network errors
                alert('Network error. Unable to connect to the server. Please check your connection and try again.');
            }
            else {
                // For other errors (or if data.success was false, though that's logged above)
                // If data.success was false, the alert(data.message) in the .then() block already ran.
                // This alert is more for truly unexpected issues or network problems not caught above.
                alert('An unexpected error occurred. Please try again later. Check the console for more details.');
            }
        });
}

function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}