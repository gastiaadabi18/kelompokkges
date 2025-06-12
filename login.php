<?php 

include ('koneksi.php');
//jika tombol submit ditekan
if(isset($_POST['submit'])){
    $username =$_POST['username'];
    $password =md5($_POST['password']);
    //cek ke database
    $tampil = mysqli_query($koneksi,"SELECT * FROM user WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_array($tampil);
    //jika ada datanya
    if($data){
        //aktifkan sesi disimpan
        session_start();
        $_SESSION['username']=$username;
        $_SESSION['nama']=$data['nama_lengkap'];
        $_SESSION['level']=$data['level'];
        $_SESSION['statuslogin']='Y';
        //berhasil login akan diarahkan ke dashboard
        echo "<script>alert('Berhasil Login');
                location.href='index.php';
                </script>";

  }else{
        echo "<script>alert('login gagal ! Pastikan username dan password benar');
                location.href='login.php';
                </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Coffee Restoran</title>
  
  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet"/>
</head>
<body>

  <div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-5">
      <div class="login-card">
        <div class="text-center mb-4 login-logo">
          <i class="fas fa-mug-hot"></i> Coffee Restoran
        </div>
        <form class="user" action="" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
          </div>
          <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-lock"></i></span>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
          </div>
          <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-primary">
              <i class="fas fa-sign-in-alt me-1"></i> Login
            </button>
          </div>
        </form>
        <div class="mt-3 text-center">
          <small>© <?= date('Y') ?> Coffee Restoran. All rights reserved.</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (opsional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


