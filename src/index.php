<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ui ui ui, integração com GIThub concluida através de script terraform</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>ui ui ui, integração com GIThub concluida através de script terraform</h2>

<?php
// Mensagem de sucesso ou erro
if (isset($message)) {
    echo "<p>$message</p>";
}

// Fazer a conexão ao MySQL
#####################################################################
$conn = new mysqli('DBaser', 'mysqluser', '@pass123!', 'mysql');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
####################################################################

// Criar um novo registo
if (isset($_POST['submit_create'])) {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $cilindrada = $_POST['cilindrada'];
    $velocidade_maxima = $_POST['velocidade_maxima'];
    $sql = "INSERT INTO motos (marca, modelo, cilindrada, velocidade_maxima) VALUES ('$marca', '$modelo', '$cilindrada', '$velocidade_maxima')";
    if ($conn->query($sql) === TRUE) {
        $message = "Novo registo criado com sucesso";
    } else {
        $message = "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Eliminar um registro
if (isset($_POST['submit_delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM motos WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "Registo eliminado com sucesso";
    } else {
        $message = "Erro ao eliminar o registo: " . $conn->error;
    }
}

// Atualizar um registro
if (isset($_POST['submit_update'])) {
    $id = $_POST['id'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $cilindrada = $_POST['cilindrada'];
    $velocidade_maxima = $_POST['velocidade_maxima'];
    $sql = "UPDATE motos SET marca='$marca', modelo='$modelo', cilindrada='$cilindrada', velocidade_maxima='$velocidade_maxima' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "Registo atualizado com sucesso";
    } else {
        $message = "Erro ao atualizar o registo: " . $conn->error;
    }
}

// Query a todos os registros da BD
$sql = "SELECT * FROM motos";
$result = $conn->query($sql);

?>

<!-- Formulário para criar um novo registo -->
<h3>Criar Registo de Mota</h3>
<form method="post">
    <label>Marca:</label>
    <input type="text" name="marca" required>
    <label>Modelo:</label>
    <input type="text" name="modelo" required>
    <label>Cilindrada:</label>
    <input type="number" name="cilindrada" required>
    <label>Velocidade Máxima:</label>
    <input type="number" name="velocidade_maxima" required>
    <button type="submit" name="submit_create">Criar</button>
</form>

<!-- Formulário para editar um registo -->
<?php
if (isset($_POST['submit_edit'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM motos WHERE id=$id";
    $edit_result = $conn->query($sql);
    if ($edit_result->num_rows > 0) {
        $edit_row = $edit_result->fetch_assoc();
?>

<h3>Editar Registo</h3>
<form method="post">
    <input type="hidden" name="id" value="<?php echo $edit_row['id']; ?>">
    <label>Marca:</label>
    <input type="text" name="marca" value="<?php echo $edit_row['marca']; ?>" required>
    <label>Modelo:</label>
    <input type="text" name="modelo" value="<?php echo $edit_row['modelo']; ?>" required>
    <label>Cilindrada:</label>
    <input type="number" name="cilindrada" value="<?php echo $edit_row['cilindrada']; ?>" required>
    <label>Velocidade Máxima:</label>
    <input type="number" name="velocidade_maxima" value="<?php echo $edit_row['velocidade_maxima']; ?>" required>
    <button type="submit" name="submit_update">Atualizar</button>
</form>

<?php
    }
}
?>

<!-- Tabela para exibir registos -->
<h3>Registros</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Cilindrada</th>
            <th>Velocidade Máxima</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['marca'] . "</td>";
                echo "<td>" . $row['modelo'] . "</td>";
                echo "<td>" . $row['cilindrada'] . "</td>";
                echo "<td>" . $row['velocidade_maxima'] . "</td>";
                echo "<td>";
                echo "<form method='post' style='display:inline;'>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                echo "<button type='submit' name='submit_edit'>Editar</button>";
                echo "</form>";
                echo "<form method='post' style='display:inline;'>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                echo "<button type='submit' name='submit_delete'>Eliminar</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nenhum registo foi encontrado</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
$conn->close();
?>

</body>
</html>
