document.addEventListener('DOMContentLoaded', function() {
    // Handle action button clicks (accept/reject)
    document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', function() {
            const applicationId = this.getAttribute('data-application-id');
            const action = this.getAttribute('data-action');

            // Confirm before changing status
            if (confirm(`Are you sure you want to ${action} this application?`)) {
                updateApplicationStatus(applicationId, action === 'accept' ? 'accepted' : 'rejected');
            }
        });
    });

    // Function to update application status
    function updateApplicationStatus(applicationId, status) {
        const formData = new FormData();
        formData.append('action', 'update_application_status');
        formData.append('application_id', applicationId);
        formData.append('status', status);

        fetch('../public/application_handler.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    const row = document.querySelector(`tr[data-application-id="${applicationId}"]`);
                    const statusCell = row.querySelector('.status-badge');

                    // Update status badge
                    statusCell.className = `status-badge status-${status}`;
                    statusCell.textContent = status.charAt(0).toUpperCase() + status.slice(1);

                    // Disable/enable buttons
                    const acceptBtn = row.querySelector('[data-action="accept"]');
                    const rejectBtn = row.querySelector('[data-action="reject"]');

                    if (status === 'accepted') {
                        acceptBtn.disabled = true;
                        rejectBtn.disabled = false;
                    } else if (status === 'rejected') {
                        acceptBtn.disabled = false;
                        rejectBtn.disabled = true;
                    }

                    // Show success message
                    alert('Application status updated successfully!');
                } else {
                    alert(data.message || 'Failed to update application status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    }
});