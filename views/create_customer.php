<?php include 'header.php'; ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-plus fa-2x me-3"></i>
                        <h3 class="mb-0">Thêm Khách Hàng</h3>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= htmlspecialchars($_GET['error']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="../controllers/AuthController.php" class="needs-validation" novalidate>
                        <input type="hidden" name="create_customer" value="1">
                        
                        <div class="mb-4">
                            <label for="username" class="form-label fw-bold">
                                <i class="fas fa-user text-primary me-2"></i>Tên khách hàng
                            </label>
                            <input type="text" name="username" id="username" class="form-control form-control-lg border-0 bg-light" 
                                   placeholder="Nhập tên khách hàng" required>
                            <div class="invalid-feedback">Vui lòng nhập tên khách hàng</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">
                                <i class="fas fa-envelope text-primary me-2"></i>Email
                            </label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg border-0 bg-light" 
                                   placeholder="example@email.com" required>
                            <div class="invalid-feedback">Vui lòng nhập email hợp lệ</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="form-label fw-bold">
                                <i class="fas fa-phone text-primary me-2"></i>Số điện thoại
                            </label>
                            <input type="text" name="phone" id="phone" class="form-control form-control-lg border-0 bg-light" 
                                   placeholder="0912345678" required>
                            <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                            <a href="manage_customers.php" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-save me-2"></i>Tạo khách hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4285f4, #34a853);
        }
        
        .form-control:focus {
            border-color: #4285f4;
            box-shadow: 0 0 0 0.25rem rgba(66, 133, 244, 0.25);
        }
        
        .form-control-lg {
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
        }
        
        .bg-light {
            background-color: #f8f9fa !important;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #4285f4, #34a853);
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #34a853, #4285f4);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(66, 133, 244, 0.3);
        }
        
        .btn-light {
            background-color: #f8f9fa;
            border-color: #ddd;
        }
        
        .btn-light:hover {
            background-color: #e9ecef;
        }
        
        .card {
            border-radius: 1rem;
            overflow: hidden;
        }
        
        .card-header {
            border-bottom: none;
        }
        
        /* Animation for form fields */
        .form-control {
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            transform: translateY(-4px);
        }
    </style>
    
    <script>
        // Form validation script
        (function() {
            'use strict';
            
            // Fetch all forms we want to apply validation to
            var forms = document.querySelectorAll('.needs-validation');
            
            // Loop over them and prevent submission
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</div>

<?php include 'footer.php'; ?>