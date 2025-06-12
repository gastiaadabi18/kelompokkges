<?php
session_start();
//mengakhiri sesi
session_destroy();
echo "<script>alert('Berhasil Logout');
                location.href='login.php';
                </script>";

?>