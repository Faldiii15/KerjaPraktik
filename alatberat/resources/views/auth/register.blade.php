
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My JAK</title>
  <link rel="shortcut icon" type="image/png" href="./assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="./assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="./assets/images/logos/logo.svg" alt="">
                </a>
                <p class="text-center">Silahkan Sign Up</p>
                <form method="POST" action="{{ route('register') }}">
                  @csrf
                  <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="textHelp">
                    @error('name')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                    @error('email')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control" id="password" name="password">
                      <span class="input-group-text bg-white">
                        <i class="bi bi-eye toggle-password" toggle="#password" style="cursor: pointer;"></i>
                      </span>
                    </div>
                    @error('password')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                      <span class="input-group-text bg-white">
                        <i class="bi bi-eye toggle-password" toggle="#password_confirmation" style="cursor: pointer;"></i>
                      </span>
                    </div>
                    @error('password_confirmation')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                     @enderror
                  </div>

                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Register</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Sudah memiliki akun? Silahkan</p>
                    <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Login</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script>
  document.querySelectorAll('.toggle-password').forEach(function (eyeIcon) {
    eyeIcon.addEventListener('click', function () {
      const input = document.querySelector(this.getAttribute('toggle'));
      const isPassword = input.getAttribute('type') === 'password';

      input.setAttribute('type', isPassword ? 'text' : 'password');
      this.classList.toggle('bi-eye');
      this.classList.toggle('bi-eye-slash');
    });
  });
</script>
</body>

</html>