<?php 
require("../sistem/koneksi.php");

$hub = open_connection(); // Perbaikan penulisan koneksi
$a = @$_GET["a"]; // Penggunaan $_GET yang benar
$id = @$_GET["id"];
$sql = @$_POST["sql"]; // Penggunaan $_POST yang benar

// Menangani aksi SQL
switch ($sql) {
    case "create":
        create_prodi();
        break;
    case "update":
        update_prodi();
        break;
}

// Menangani aksi berdasarkan parameter 'a'
switch ($a) {
    case "list":
        read_data();
        break;
    case "input":
        input_data();
        break;
    case "edit":
        edit_data($id); // Edit data berdasarkan ID
        break;
    default:
        read_data();
        break;
}

mysqli_close($hub); // Menutup koneksi
?>

<?php
function read_data() {
    global $hub; // Mengakses koneksi

    // Query untuk mengambil data
    $query = "SELECT * FROM dt_prodi";
    $result = mysqli_query($hub, $query); 

    if (!$result) {
        die("Query error: " . mysqli_error($hub));
    }
?>
    <h2>Read Data Program Studi</h2>
    <table border="1" cellpadding="2">
        <tr>
            <td colspan="5"><a href="curd_3.php?a=input">INPUT</a></td>
        </tr>
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
            <td>
                <a href="curd_3.php?a=edit&id=<?php echo $row['idprodi']; ?>">EDIT</a>
            </td>
        </tr>
        <?php } ?>
    </table>
<?php 
}
?>

<?php
function input_data() {
    $row = array(
        "kdprodi" => "",
        "nmprodi" => "",
        "akreditasi" => ""
    );
?>
    <h2>Input Data Program Studi</h2>
    <form action="curd_3.php?a=list" method="post">
        <input type="hidden" name="sql" value="create">
        Kode Prodi
        <input type="text" name="kdprodi" maxlength="6" size="6" value="<?php echo trim($row["kdprodi"]) ?>" />
        <br>
        Nama Prodi
        <input type="text" name="nmprodi" maxlength="70" size="70" value="<?php echo trim($row["nmprodi"]) ?>" />
        <br>
        Akreditasi Prodi
        <input type="radio" name="akreditasi" value="-" <?php if ($row["akreditasi"] == '') { echo 'checked="checked"'; } ?>> - 
        <input type="radio" name="akreditasi" value="A" <?php if ($row["akreditasi"] == 'A') { echo 'checked="checked"'; } ?>> A
        <input type="radio" name="akreditasi" value="B" <?php if ($row["akreditasi"] == 'B') { echo 'checked="checked"'; } ?>> B
        <input type="radio" name="akreditasi" value="C" <?php if ($row["akreditasi"] == 'C') { echo 'checked="checked"'; } ?>> C
        <br>
        <input type="submit" name="action" value="Simpan">
        <br>
        <a href="curd_3.php?a=list">Batal</a>
    </form>
<?php 
}
?>

<?php
function edit_data($id) {
    global $hub; 
    $query = "SELECT * FROM dt_prodi WHERE idprodi = $id";
    $result = mysqli_query($hub, $query);
    $row = mysqli_fetch_array($result);
?>
    <h2>Edit Data Program Studi</h2>
    <form action="curd_3.php?a=list" method="post">
        <input type="hidden" name="sql" value="update">
        <input type="hidden" name="idprodi" value="<?php echo trim($id) ?>">
        Kode Prodi
        <input type="text" name="kdprodi" maxlength="6" size="6" value="<?php echo trim($row["kdprodi"]) ?>" />
        <br>
        Nama Prodi
        <input type="text" name="nmprodi" maxlength="70" size="70" value="<?php echo trim($row["nmprodi"]) ?>" />
        <br>
        Akreditasi Prodi
        <input type="radio" name="akreditasi" value="-" <?php if ($row["akreditasi"] == '') { echo 'checked="checked"'; } ?>> - 
        <input type="radio" name="akreditasi" value="A" <?php if ($row["akreditasi"] == 'A') { echo 'checked="checked"'; } ?>> A
        <input type="radio" name="akreditasi" value="B" <?php if ($row["akreditasi"] == 'B') { echo 'checked="checked"'; } ?>> B
        <input type="radio" name="akreditasi" value="C" <?php if ($row["akreditasi"] == 'C') { echo 'checked="checked"'; } ?>> C
        <br>
        <input type="submit" name="action" value="Simpan">
        <br>
        <a href="curd_3.php?a=list">Batal</a>
    </form>
<?php 
}
?>

<?php
function create_prodi() {
    global $hub; // Akses koneksi
    global $_POST; // Akses data POST

    $query = "INSERT INTO dt_prodi (kdprodi, nmprodi, akreditasi) VALUES ('".$_POST["kdprodi"]."', '".$_POST["nmprodi"]."', '".$_POST["akreditasi"]."')";
    mysqli_query($hub, $query) or die(mysqli_error($hub));
}

function update_prodi() {
    global $hub; // Akses koneksi
    global $_POST; // Akses data POST

    $query = "UPDATE dt_prodi SET kdprodi = '".$_POST["kdprodi"]."', nmprodi = '".$_POST["nmprodi"]."', akreditasi = '".$_POST["akreditasi"]."' WHERE idprodi = '".$_POST["idprodi"]."'";
    mysqli_query($hub, $query) or die(mysqli_error($hub));
}
?>
