document.addEventListener('DOMContentLoaded', function() {
    const applyBtn = document.getElementById('apply-btn');

    if (applyBtn) {
        applyBtn.addEventListener('click', function() {
            const jamId = this.getAttribute('data-jam-id');

            const formData = new FormData();
            formData.append('action', 'apply_to_jam');
            formData.append('jam_id', jamId);

            fetch('../public/jam_handler.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Applied to jam successfully!');
                        this.disabled = true;
                        this.textContent = 'Applied';
                    } else {
                        alert(data.message || 'Failed to apply to jam');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    }
});