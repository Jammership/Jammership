let isLoggedIn = false;

function checkLoginStatus() {
    if (sessionStorage.getItem('username')) {
        isLoggedIn = true;
    } else {
        isLoggedIn = false;
    }
    return isLoggedIn;
}

function updateEmail() {
    document.getElementById('account-form').addEventListener('submit', function(e) {
        e.preventDefault();

        console.log("UPDATING MAIL")
        const email = document.getElementById('email').value;
        const formData = new FormData();
        formData.append('action', 'update_account');
        formData.append('email', email);

        fetch('../public/account_handler.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Account information updated successfully');
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    });
}

function changePassword() {
    document.getElementById('password-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const currentPassword = document.getElementById('current-password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        if (newPassword !== confirmPassword) {
            alert('New passwords do not match');
            return;
        }

        const formData = new FormData();
        formData.append('action', 'change_password');
        formData.append('current_password', currentPassword);
        formData.append('new_password', newPassword);

        fetch('../public/account_handler.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Password changed successfully');
                    document.getElementById('password-form').reset();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    });
}

function deleteAccount() {
    document.getElementById('delete-account').addEventListener('click', function() {
        if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
            const formData = new FormData();
            formData.append('action', 'delete_account');

            fetch('../public/account_handler.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        logoutUser('../index.php')
                        alert('Your account has been deleted');
                        window.location.href = 'index.php';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        }
    });
}

document.addEventListener('DOMContentLoaded', async function () {
    checkLoginStatus()
})

document.addEventListener('DOMContentLoaded', function() {
    updateEmail();

    changePassword();

    deleteAccount();
});