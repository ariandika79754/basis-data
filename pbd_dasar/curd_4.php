<?php
require("../sistem/koneksi.php");

$hub = open_connection();
$a = @$_GET["a"];
$id = @$_GET["id"];
$sql = @$_POST["sql"];
$error_messages = [];

switch ($sql) {
    case "create":
        create_prodi();
        break;
    case "update":
        update_prodi();
        break;
}

switch ($a) {
    case "list":
        read_data();
        break;
    case "input":
        input_data();
        break;
    case "edit":
        edit_data($id);
        break;
    case "delete":
        delete_prodi($id);
        break;
    default:
        read_data();
        break;
}

mysqli_close($hub);

function read_data()
{
    global $hub;

    $query = "SELECT * FROM dt_prodi";
    $result = mysqli_query($hub, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($hub));
    }
?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Data Program Studi</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 20px;
                background-image: url('icon/pol3.jpg');
            }

            h2 {
                color: #333;
            }

            table {
                width: 80%;
                margin: 20px auto;
                border-collapse: collapse;
                background-color: #fff;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            th,
            td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #007BFF;
                color: white;
            }

            tr:hover {
                background-color: #f1f1f1;
            }

            a {
                color: #007BFF;
                text-decoration: none;
            }

            a:hover {
                text-decoration: underline;
            }

            .button {
                padding: 10px 15px;
                color: white;
                background-color: #007BFF;
                border: none;
                border-radius: 5px;
                text-decoration: none;
                margin: 10px 0;
                display: inline-block;
            }

            .button:hover {
                background-color: #0056b3;
            }

            .icon {
                width: 20px;
                height: 20px;
                vertical-align: middle;
                cursor: pointer;
            }

            .edit-icon,
            .delete-icon {
                width: 20px;
                height: 20px;
                display: inline-block;
                background-color: transparent;
                border: none;
                cursor: pointer;
            }

            .edit-icon::before {
                content: '\270E';
                color: #007BFF;
                font-size: 20px;
            }

            .delete-icon::before {
                content: '\2716';
                color: red;
                font-size: 20px;
            }

            .search-container {
                display: flex;
                justify-content: space-between;
                margin: 20px auto;
                width: 80%;
            }

            /* Style responsif untuk tabel */
            @media screen and (max-width: 768px) {
                table {
                    display: block;
                    overflow-x: auto;
                    white-space: nowrap;
                }
            }

            .search-box {
                position: relative;
                flex-grow: 1;
            }

            .search-box input {
                width: 30%;
                padding: 10px 40px 10px 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }

            .search-icon {
                position: absolute;
                left: 380px;
                top: 50%;
                transform: translateY(-50%);
                color: #999;
            }

            .input-button {
                margin-left: 1200px;
                /* Agar tombol bergeser ke kanan */
                margin-bottom: 0px;
            }
        </style>
    </head>

    <body>
        <h1 align="center">Read Data Program Studi</h1>
        <div class="input-button">
            <a class="button" href="curd_4.php?a=input">Tambah</a>
        </div>
        <div class="search-container">
            <div class="search-box">
                <span class="search-icon">🔍</span>
                <input type="text" id="search" placeholder="Cari..." onkeyup="searchTable()">
            </div>
        </div>
        <table>
            <tr>
                <th>No</th>
                <th>KODE</th>
                <th>NAMA PRODI</th>
                <th>AKREDITASI</th>
                <th>AKSI</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $row['idprodi']; ?></td>
                    <td><?php echo $row['kdprodi']; ?></td>
                    <td><?php echo $row['nmprodi']; ?></td>
                    <td><?php echo $row['akreditasi']; ?></td>
                    <td>
                        <div class="action-icons">
                            <a href="curd_4.php?a=edit&id=<?php echo $row['idprodi']; ?>" class="edit-icon"></a>
                            <a href="curd_4.php?a=delete&id=<?php echo $row['idprodi']; ?>" class="delete-icon" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <script>
            function searchTable() {
                const input = document.getElementById('search');
                const filter = input.value.toLowerCase();
                const table = document.querySelector('table');
                const rows = table.getElementsByTagName('tr');

                for (let i = 1; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let found = false;

                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j].textContent.toLowerCase().includes(filter)) {
                            found = true;
                            break;
                        }
                    }

                    rows[i].style.display = found ? '' : 'none';
                }
            }
        </script>
    </body>

    </html>
<?php
}
function input_data($error_messages = [])
{
    $row = array(
        "kdprodi" => "",
        "nmprodi" => "",
        "akreditasi" => ""
    );
?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Input Data Program Studi</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-image: url('icon/pol3.jpg');
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <h2>Input Data Program Studi</h2>
            <?php if (!empty($error_messages)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($error_messages as $message): ?>
                            <li><?php echo $message; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="curd_4.php?a=list" method="post">
                <input type="hidden" name="sql" value="create">
                <div class="form-group">
                    <label>Kode Prodi</label>
                    <input type="text" name="kdprodi" class="form-control" maxlength="6" value="<?php echo trim($row["kdprodi"]) ?>" />
                </div>
                <div class="form-group">
                    <label>Nama Prodi</label>
                    <input type="text" name="nmprodi" class="form-control" maxlength="70" value="<?php echo trim($row["nmprodi"]) ?>" />
                </div>
                <div class="form-group">
                    <label>Akreditasi Prodi</label><br>
                    <input type="radio" name="akreditasi" value="-" <?php if ($row["akreditasi"] == '') echo 'checked'; ?>> -
                    <input type="radio" name="akreditasi" value="A" <?php if ($row["akreditasi"] == 'A') echo 'checked'; ?>> A
                    <input type="radio" name="akreditasi" value="B" <?php if ($row["akreditasi"] == 'B') echo 'checked'; ?>> B
                    <input type="radio" name="akreditasi" value="C" <?php if ($row["akreditasi"] == 'C') echo 'checked'; ?>> C
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a class="btn btn-secondary" href="curd_4.php?a=list">Batal</a>
            </form>
        </div>
    </body>

    </html>
<?php
}
function edit_data($id)
{
    global $hub;
    $query = "SELECT * FROM dt_prodi WHERE idprodi = $id";
    $result = mysqli_query($hub, $query);
    $row = mysqli_fetch_array($result);
?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Data Program Studi</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-image: url('icon/pol3.jpg');
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <h2>Edit Data Program Studi</h2>
            <form action="curd_4.php?a=list" method="post">
                <input type="hidden" name="sql" value="update">
                <input type="hidden" name="idprodi" value="<?php echo trim($id) ?>">
                <div class="form-group">
                    <label>Kode Prodi</label>
                    <input type="text" name="kdprodi" class="form-control" maxlength="6" value="<?php echo trim($row["kdprodi"]) ?>" />
                </div>
                <div class="form-group">
                    <label>Nama Prodi</label>
                    <input type="text" name="nmprodi" class="form-control" maxlength="70" value="<?php echo trim($row["nmprodi"]) ?>" />
                </div>
                <div class="form-group">
                    <label>Akreditasi Prodi</label><br>
                    <input type="radio" name="akreditasi" value="-" <?php if ($row["akreditasi"] == '') echo 'checked'; ?>> -
                    <input type="radio" name="akreditasi" value="A" <?php if ($row["akreditasi"] == 'A') echo 'checked'; ?>> A
                    <input type="radio" name="akreditasi" value="B" <?php if ($row["akreditasi"] == 'B') echo 'checked'; ?>> B
                    <input type="radio" name="akreditasi" value="C" <?php if ($row["akreditasi"] == 'C') echo 'checked'; ?>> C
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a class="btn btn-secondary" href="curd_4.php?a=list">Batal</a>
            </form>
        </div>
    </body>

    </html>
<?php
}


function create_prodi()
{
    global $hub;
    global $_POST;
    global $error_messages;

    // Validation
    if (empty($_POST["kdprodi"])) {
        $error_messages[] = "Kode Prodi harus diisi.";
    }
    if (empty($_POST["nmprodi"])) {
        $error_messages[] = "Nama Prodi harus diisi.";
    }
    if (empty($_POST["akreditasi"])) {
        $error_messages[] = "Akreditasi harus dipilih.";
    }

    if (!empty($error_messages)) {
        input_data($error_messages); // Show the form again with errors
        return;
    }

    $query = "INSERT INTO dt_prodi (kdprodi, nmprodi, akreditasi) VALUES ('" . $_POST["kdprodi"] . "', '" . $_POST["nmprodi"] . "', '" . $_POST["akreditasi"] . "')";
    mysqli_query($hub, $query) or die(mysqli_error($hub));
    header("Location: curd_4.php?a=list");
    exit();
}

function update_prodi()
{
    global $hub;
    global $_POST;

    $query = "UPDATE dt_prodi SET kdprodi = '" . $_POST["kdprodi"] . "', nmprodi = '" . $_POST["nmprodi"] . "', akreditasi = '" . $_POST["akreditasi"] . "' WHERE idprodi = " . $_POST["idprodi"];
    mysqli_query($hub, $query) or die(mysqli_error($hub));
}

function delete_prodi($id)
{
    global $hub;
    $query = "DELETE FROM dt_prodi WHERE idprodi = $id";
    mysqli_query($hub, $query) or die(mysqli_error($hub));
    header("Location: curd_4.php?a=list");
    exit();
}
