document.addEventListener('DOMContentLoaded', function() {
    const createJamForm = document.getElementById('create-jam-form');

    createJamForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('action', 'create_jam');

        fetch('jam_handler.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Game jam created successfully!');
                    window.location.href = 'dashboard.php';
                } else {
                    alert(data.message || 'An error occurred while creating the jam');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    });
});