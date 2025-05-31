<!-- Footer Section -->
<footer class="bg-dark text-light py-4">
        <div class="container text-center">
            <p>&copy; 2023 CyberOnly. All rights reserved.</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#" class="text-light">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="#" class="text-light">Terms of Service</a></li>
                <li class="list-inline-item"><a href="#" class="text-light">Contact Us</a></li>
            </ul>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Dark Mode Toggle dengan Local Storage
        const darkModeToggle = document.getElementById('darkModeToggle');
        
        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
            darkModeToggle.checked = true;
        }

        darkModeToggle.addEventListener('change', () => {
            if (darkModeToggle.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('darkMode', 'enabled');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', null);
            }
        });

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
