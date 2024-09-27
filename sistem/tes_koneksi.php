<?php require("koneksi.php");

$hub= open_connection ();

if ($hub) {
echo ("Koneksi SUKSES");
} else {
echo ("Koneksi GAGAL");
}
mysqli_close($hub); ?>