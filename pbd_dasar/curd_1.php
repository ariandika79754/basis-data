<?php 
require("../sistem/koneksi.php");
$hub = open_connection();
read_data();
mysqli_close($hub);
?>

<?php
function read_data() {
    global $hub; 
    $query = "SELECT * FROM dt_prodi";
    $result = mysqli_query($hub, $query); 
    
    if (!$result) {
        die("Query error: " . mysqli_error($hub)); 
    }
?>
    <h2>Read Data Program Studi</h2>
    <table border="1" cellpadding="2">
        <tr>
            <td>ID</td>
            <td>KODE</td>
            <td>NAMA PRODI</td>
            <td>AKREDITASI</td>
            <td>AKSI</td>
        </tr>
        <?php while ($row = mysqli_fetch_array($result)) { ?>
        <tr>
            <td><?php echo $row['idprodi']; ?></td>
            <td><?php echo $row['kdprodi']; ?></td>
            <td><?php echo $row['nmprodi']; ?></td>
            <td><?php echo $row['akreditasi']; ?></td>
            <td><a href="#">EDIT</a> | <a href="#">HAPUS</a></td>
        </tr>
        <?php } ?>
    </table>
<?php 
}
?>
