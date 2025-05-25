document.addEventListener('DOMContentLoaded', function() {
    // Handle jam card clicks to view details
    document.querySelectorAll('.jam-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't navigate if the apply button was clicked
            if (e.target.classList.contains('apply-btn')) {
                return;
            }

            const jamId = this.getAttribute('data-jam-id');
            window.location.href = `jam_details.php?id=${jamId}`;
        });
    });

    // Handle apply to jam button clicks
    document.querySelectorAll('.apply-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent triggering the card click

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
    });
});