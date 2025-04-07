<!doctype html>
<html lang="en">
<head>
  <title>Đăng Nhập - Đăng ký</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/laundryservice/styles.css">
</head>
<body>
<div id="stars"></div>
<div id="stars2"></div>
<div id="stars3"></div>

<div class="section">
  <div class="container">
    <div class="row full-height justify-content-center">
      <div class="col-12 text-center align-self-center py-5">
        <div class="section pb-5 pt-5 pt-sm-2 text-center">
          <h6 class="mb-0 pb-3"><span>Đăng Nhập </span><span>Đăng Ký</span></h6>
          <input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
          <label for="reg-log"></label>

          <!-- Flash Messages -->
          <?php if (isset($_GET['error'])): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
          <?php endif; ?>
          <?php if (isset($_GET['success'])): ?>
              <div class="alert alert-success">
                  Đăng ký thành công! Bạn có thể <a href='login.php'>đăng nhập</a> ngay.
              </div>
          <?php endif; ?>

          <div class="card-3d-wrap mx-auto">
            <div class="card-3d-wrapper">

              <!-- Login -->
              <div class="card-front">
                <div class="center-wrap">
                  <div class="section text-center">
                    <h4 class="pb-3">Đăng Nhập</h4>
                    <form action="../controllers/AuthController.php" method="POST">
                      <input type="hidden" name="login" value="1">

                      <div class="form-group">
                        <input type="email" name="email" class="form-style" placeholder="Email" required>
                        <i class="input-icon uil uil-at"></i>
                      </div>  
                      <div class="form-group mt-2">
                        <input type="password" name="password" class="form-style" placeholder="Mật Khẩu" required>
                        <i class="input-icon uil uil-lock-alt"></i>
                      </div>

                      <button type="submit" class="btn mt-4">Đăng nhập</button>

                      <div class="form-group mt-2">
                        <p>Hoặc</p>
                        <a href="#" class="btn"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="btn"><i class="fa-brands fa-google"></i></a>
                        <a href="#" class="btn"><i class="fa-brands fa-github"></i></a>
                      </div>

                      <p class="mb-0 mt-4 text-center"><a href="#" class="link">Quên mật khẩu?</a></p>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Register -->
              <div class="card-back">
                <div class="center-wrap">
                  <div class="section text-center">
                    <h4 class="mb-3 pb-3">Đăng Ký</h4>
                    <form action="../controllers/AuthController.php" method="POST">
                      <input type="hidden" name="register" value="1">

                      <div class="form-group">
                        <input type="text" name="username" class="form-style" placeholder="Nhập tên của bạn" required>
                        <i class="input-icon uil uil-user"></i>
                      </div>
                      <div class="form-group mt-2">
                        <input type="tel" name="phone" class="form-style" placeholder="Nhập số điện thoại" required>
                        <i class="input-icon uil uil-phone"></i>
                      </div>  
                      <div class="form-group mt-2">
                        <input type="email" name="email" class="form-style" placeholder="Email" required>
                        <i class="input-icon uil uil-at"></i>
                      </div>
                      <div class="form-group mt-2">
                        <input type="password" name="password" class="form-style" placeholder="Mật khẩu" required>
                        <i class="input-icon uil uil-lock-alt"></i>
                      </div>
                      <div class="form-group mt-2">
                        <select name="role" class="form-style" required>
                          <option value="customer">Customer</option>
                          <option value="employee">Employee</option>
                          <option value="admin">Admin</option>
                        </select>
                      </div>

                      <button type="submit" class="btn mt-4">Đăng ký</button>
                    </form>
                  </div>
                </div>
              </div>

            </div> <!-- .card-3d-wrapper -->
          </div> <!-- .card-3d-wrap -->
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
