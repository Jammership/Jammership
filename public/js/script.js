// Simple page navigation
function showPage(pageId) {
    // Hide all pages
    document.getElementById("homepage").style.display = "none";
    document.getElementById("loginPage").style.display = "none";
    document.getElementById("registerPage").style.display = "none";

    // Show the selected page
    document.getElementById(pageId).style.display = "block";

    // Scroll to top when changing pages
    window.scrollTo(0, 0);
}

// Form submission handling
document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const email = document.getElementById("loginEmail").value;
    const password = document.getElementById("loginPassword").value;

    // This is where you would normally send data to a PHP script
    // For demo, just show an alert
    alert("Login successful! Welcome back to GameJam!");
    console.log("Login attempt:", email);

    // Redirect to homepage after login
    showPage("homepage");
});
// Simple click handler for every “Join Now” button
document.querySelectorAll('.active-jams .btn').forEach(btn => {
    btn.addEventListener('click', () => {
        // you can read data-jam if needed: btn.dataset.jam
        showPage('registerPage');
    });
});

document.getElementById("registerForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const name = document.getElementById("registerName").value;
    const email = document.getElementById("registerEmail").value;
    const password = document.getElementById("registerPassword").value;

    // Simple validation
    if (password !== confirmPassword) {
        alert("Passwords don't match! Please try again.");
        return;
    }

    if (password.length < 6) {
        alert("Password should be at least 6 characters long!");
        return;
    }

    // This is where you would normally send data to a PHP script
    // For demo, just show an alert
    alert("Registration successful! Welcome to GameJam, " + name + "!");
    console.log("Registration:", name, email);

    // Redirect to homepage after registration
    showPage("homepage");
});