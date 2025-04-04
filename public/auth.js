document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const showRegisterLink = document.getElementById('show-register');
    const showLoginLink = document.getElementById('show-login');
    const loginSection = document.getElementById('login-section');
    const registerSection = document.getElementById('register-section');
    const logoutBtn = document.getElementById('logout-btn');
    const authContainer = document.getElementById('auth-container');

    // Show register form
    showRegisterLink.addEventListener('click', function(e) {
        e.preventDefault();
        loginSection.style.display = 'none';
        registerSection.style.display = 'block';
    });

    // Show login form
    showLoginLink.addEventListener('click', function(e) {
        e.preventDefault();
        registerSection.style.display = 'none';
        loginSection.style.display = 'block';
    });

    // Handle registration
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();

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

        promise.then(response => response.text()).then(text => console.log(text))

        // promise
        //     .then(response => response.text())
        //     .then(text => {
        //         console.log('Raw response:', text);
        //         // You can try to parse it only if it’s valid JSON
        //         try {
        //             const data = JSON.parse(text);
        //             console.log('Parsed data:', data);
        //         } catch (err) {
        //             console.error('Parsing error:', err);
        //         }
        //     })
        //     .catch(error => {
        //         console.error('Fetch error:', error);
        //     });



        // promise
        // .then(response => response.json())
        // .then(data => {
        //     alert(data.message);
        //     if (data.success) {
        //         // Reset form and show login section
        //         registerForm.reset();
        //         registerSection.style.display = 'none';
        //         loginSection.style.display = 'block';
        //     }
        // })
        // .catch(error => {
        //     console.error('Error:', error);
        //     alert('An error occurred. Please try again later.');
        // });
    });

    // // Handle login
    // loginForm.addEventListener('submit', function(e) {
    //     e.preventDefault();
    //
    //     const username = document.getElementById('login-username').value;
    //     const password = document.getElementById('login-password').value;
    //     const userType = document.getElementById('login-user-type').value;
    //
    //     const formData = new FormData();
    //     formData.append('action', 'login');
    //     formData.append('username', username);
    //     formData.append('password', password);
    //     formData.append('userType', userType);
    //
    //     fetch('auth_handler.php', {
    //         method: 'POST',
    //         body: formData
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.success) {
    //             // Hide auth container and show dashboard
    //             authContainer.style.display = 'none';
    //             dashboard.style.display = 'block';
    //
    //             // Update dashboard username
    //             dashboardUsername.textContent = `Welcome, ${username}!`;
    //
    //             // Show appropriate dashboard based on user role
    //             if (data.userRole === 'jammer') {
    //                 jammerDashboard.style.display = 'block';
    //                 if (organizerDashboard) organizerDashboard.style.display = 'none';
    //             } else if (data.userRole === 'organizer') {
    //                 if (jammerDashboard) jammerDashboard.style.display = 'none';
    //                 if (organizerDashboard) organizerDashboard.style.display = 'block';
    //             }
    //
    //             // Store user info in sessionStorage
    //             sessionStorage.setItem('userId', data.userId);
    //             sessionStorage.setItem('userRole', data.userRole);
    //             sessionStorage.setItem('username', username);
    //
    //         } else {
    //             alert(data.message);
    //         }
    //     })
    //     .catch(error => {
    //         console.error('Error:', error);
    //         alert('An error occurred. Please try again later.');
    //     });
    // });
    //
    // // Handle logout
    // if (logoutBtn) {
    //     logoutBtn.addEventListener('click', function() {
    //         const formData = new FormData();
    //         formData.append('action', 'logout');
    //
    //         fetch('auth_handler.php', {
    //             method: 'POST',
    //             body: formData
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.success) {
    //                 // Clear session storage
    //                 sessionStorage.clear();
    //
    //                 // Show auth container and hide dashboard
    //                 authContainer.style.display = 'block';
    //                 dashboard.style.display = 'none';
    //
    //                 // Reset forms
    //                 loginForm.reset();
    //                 if (registerForm) registerForm.reset();
    //
    //                 // Show login section
    //                 loginSection.style.display = 'block';
    //                 if (registerSection) registerSection.style.display = 'none';
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //             alert('An error occurred. Please try again later.');
    //         });
    //     });
    // }

    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
});