<?php include '../components/chatbot-popup.html'; ?>
</div>
        </div>
    </div>

    <!-- Sidebar toggle button -->
    <button type="button" id="sidebarCollapse" class="btn">
        <i class="fas fa-bars"></i>
    </button>

    <!-- JavaScript -->
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle functionality
            document.getElementById('sidebarCollapse').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('active');
                document.getElementById('content').classList.toggle('active');
                this.classList.toggle('active');
            });

            // Set active link based on current page
            const currentLocation = window.location.href;
            const menuItems = document.querySelectorAll('#sidebar ul li a');
            menuItems.forEach(function(item) {
                if (currentLocation.includes(item.getAttribute('href'))) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        });
    </script>
</body>

</html>