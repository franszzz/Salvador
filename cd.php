<?php
require 'sessao.php';
requireLogin();
require 'config.php';

$task = "";
$task_id = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task']) && !empty(trim($_POST['task']))) {
        $task = trim($_POST['task']);
        if (isset($_POST['task_id']) && !empty($_POST['task_id'])) {
            // atualizar
            $task_id = $_POST['task_id'];
            $stmt = $conn->prepare("UPDATE tarefas SET tarefa = ? WHERE id = ? AND usuarios_id = ?");
            $stmt->bind_param("sii", $task, $task_id, $_SESSION['usuarios_id']);
        } else {
            // add
            $stmt = $conn->prepare("INSERT INTO tarefas (usuarios_id, tarefa) VALUES (?, ?)");
            $stmt->bind_param("is", $_SESSION['usuarios_id'], $task);
        }
        $stmt->execute();
        $stmt->close();
        header("Location: cd.php");
        exit();
    }
} 
  elseif (isset($_GET['deletar'])) {
            $task_id = $_GET['deletar'];
            $stmt = $conn->prepare("DELETE FROM tarefas WHERE id = ? AND usuarios_id = ?");
            $stmt->bind_param("ii", $task_id, $_SESSION['usuarios_id']);
            $stmt->execute();
            $stmt->close();
    header("Location: cd.php");
    exit();
} 
   elseif (isset($_GET['editar'])) {
             $task_id = $_GET['editar'];
            $stmt = $conn->prepare("SELECT tarefa FROM tarefas WHERE id = ? AND usuarios_id = ?");
            $stmt->bind_param("ii", $task_id, $_SESSION['usuarios_id']);
            $stmt->execute();
            $stmt->bind_result($task);
             $stmt->fetch();
           $stmt->close();
}

$searchQuery = "";
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
}

$query = "SELECT * FROM tarefas WHERE usuarios_id = " . $_SESSION['usuarios_id'] . " AND tarefa LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Tarefas</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'
    integrity='sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM' crossorigin='anonymous'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class='navbar'>
       <a href="sair.php">Sair</a>
    </div>

    <div class="container">
        <h1>Tarefas</h1>

        <form action="cd.php" method="post">
                <label for="task">Adicione uma tarefa:</label>
                <input type="text" id="task" name="task" value="<?php echo isset($task) ? htmlspecialchars($task) : ''; ?>" required>
                <?php if (isset($task_id) && !empty($task_id)): ?> 
                <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
                <?php endif; ?>
            <button type="submit"><?php echo isset($task_id) && !empty($task_id) ? 'Atualizar' : 'Adicionar'; ?></button>
        </form>

        <form action="cd.php" method="post">
                <label for="search">Pesquise uma tarefa:</label>
                <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button type="submit">Pesquisar</button>
        </form>

        <h2>Suas tarefas:</h2>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                <?php echo htmlspecialchars($row['tarefa']); ?> 
                <a href="cd.php?editar=<?php echo $row['id']; ?>">Editar</a> 
                <a href="cd.php?deletar=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');">Excluir</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>



