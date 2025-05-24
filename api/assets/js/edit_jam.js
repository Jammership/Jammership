document.addEventListener('DOMContentLoaded', function() {
    const editJamForm = document.getElementById('edit-jam-form');
    const deleteJamBtn = document.getElementById('delete-jam-btn');

    // Handle form submission for updating jam
    if (editJamForm) {
        editJamForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('action', 'update_jam');

            fetch('jam_handler.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Game jam updated successfully!');
                        window.location.href = 'organizer_dashboard.php';
                    } else {
                        alert(data.message || 'An error occurred while updating the jam');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    }

    // Handle delete jam button
    if (deleteJamBtn) {
        deleteJamBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this game jam? This action cannot be undone!')) {
                const jamId = this.getAttribute('data-jam-id');

                const formData = new FormData();
                formData.append('action', 'delete_jam');
                formData.append('jam_id', jamId);

                fetch('jam_handler.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Game jam deleted successfully!');
                            window.location.href = 'organizer_dashboard.php';
                        } else {
                            alert(data.message || 'An error occurred while deleting the jam');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            }
        });
    }
});