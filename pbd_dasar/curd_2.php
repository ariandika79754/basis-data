<?php
require("../sistem/koneksi.php");
$hub = open_connection();
$a = @$_GET["a"];
$sql = @$_POST["sql"];

switch ($sql) {
    case "create":
        create_prodi();
        break;
}

switch ($a) { 
    case "list":
        read_data();
        break;
    case "input":
        input_data();
        break;
    default:
        read_data();
        break;
}

mysqli_close($hub);
?>

<?php
function read_data() {
    global $hub;
    $query = "SELECT * FROM dt_prodi"; 
    $result = mysqli_query($hub, $query); 
?>
    <h2>Read Data Program Studi</h2>
    <table border="1" cellpadding="2">
        <tr>
            <td colspan="4"><a href="curd_2.php?a=input">INPUT</a></td>
        </tr>
        <tr>
            <td>ID</td>
            <td>KODE</td>
            <td>NAMA PRODI</td>
            <td>AKREDITASI</td>
        </tr>
        <?php while($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $row['idprodi']; ?></td>
                <td><?php echo $row['kdprodi']; ?></td>
                <td><?php echo $row['nmprodi']; ?></td>
                <td><?php echo $row['akreditasi']; ?></td>
            </tr>
        <?php } ?>
    </table>
<?php 
}
?>

<?php
function input_data() {
    $row = array("kdprodi" => "", "nmprodi" => "", "akreditasi" => "-");
?>
    <h2>Input Data Program Studi</h2>
    <form action="curd_2.php?a=list" method="post">
        <input type="hidden" name="sql" value="create">
        
        Kode Prodi:
        <input type="text" name="kdprodi" maxlength="6" size="6" value="<?php echo trim($row["kdprodi"]) ?>" />
        <br>
        
        Nama Prodi:
        <input type="text" name="nmprodi" maxlength="70" size="70" value="<?php echo trim($row["nmprodi"]) ?>" />
        <br>
        
        Akreditasi Prodi:
        <input type="radio" name="akreditasi" value="-" <?php if ($row["akreditasi"] == '-' || $row["akreditasi"] == '') { echo "checked=\"checked\""; } ?>> -
        <input type="radio" name="akreditasi" value="A" <?php if ($row["akreditasi"] == 'A') { echo "checked=\"checked\""; } ?>> A
        <input type="radio" name="akreditasi" value="B" <?php if ($row["akreditasi"] == 'B') { echo "checked=\"checked\""; } ?>> B
        <input type="radio" name="akreditasi" value="C" <?php if ($row["akreditasi"] == 'C') { echo "checked=\"checked\""; } ?>> C
        <br>
        
        <input type="submit" name="action" value="Simpan">
        <br>
        <a href="curd_2.php?a=list">Batal</a>
    </form>
<?php 
}
?>
<?php
function create_prodi() {
    global $hub; 
    
    $query = "INSERT INTO dt_prodi (kdprodi, nmprodi, akreditasi) VALUES 
              ('".$_POST["kdprodi"]."', '".$_POST["nmprodi"]."', '".$_POST["akreditasi"]."')";

    mysqli_query($hub, $query) or die(mysqli_error($hub));
}
?>
