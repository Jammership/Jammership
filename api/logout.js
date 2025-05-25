function logoutUser(redirectUrl = null) {
    const formData = new FormData();
    formData.append('action', 'logout');

    fetch('../public/auth_handler.php', {
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