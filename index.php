<!DOCTYPE html>
<html lang="en">

<?php
$todos = json_decode(file_get_contents('todos.json'), true) ?: [];
$completed = json_decode(file_get_contents('completed.json'), true) ?: [];
if (isset($_GET['complete'])) {
    $index = $_GET['complete'];
    if (isset($todos[$index])) {
        $completedTodo = $todos[$index];
        $completedTodo['completedAt'] = date('Y-m-d H:i:s');
        $completed[] = $completedTodo;
        unset($todos[$index]);
        file_put_contents('completed.json', json_encode($completed));
        file_put_contents('todos.json', json_encode($todos));
    }
}

function DisplayTodos()
{
    $todos = json_decode(file_get_contents('todos.json'), true) ?: [];
    $todoList = '';
    $counter = 1;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = $_POST['content'];
        $createdAt = $_POST['createdAt'];
        $todo = [
            'content' => $content,
            'done' => false,
            'createdAt' => $createdAt
        ];
        $todos[] = $todo;
        file_put_contents('todos.json', json_encode($todos));
    }

    if (empty($todos)) {
        $todoList .= '<tr><td colspan="4" class="no-task">No Task Available</td></tr>';
    } else {
        foreach ($todos as $index => $todo) {
            $todoList .= '<tr class="todo-item">';
            $todoList .= '<td class="sno">' . $counter . '.</td>';
            $todoList .= '<td class="task">' . htmlspecialchars($todo['content']) . '</td>';
            $todoList .= '<td class="deadline">';
            $todoList .= 'Date: ' . date('d.m.Y', strtotime($todo['createdAt'])) . '<br>';
            $todoList .= 'Time: ' . date('H:i', strtotime($todo['createdAt']));
            $todoList .= '</td>';
            $todoList .= '<td class="status">';
            $todoList .= '<button class="complete-button" onclick="completeItem(' . $index . ')">Complete</button>';
            $todoList .= '</td>';
            $todoList .= '</tr>';
            $counter++;
        }
    }
    return $todoList;
}

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class="app">
        <section class="greeting">
            <h2 class="title">
                What's up, Balaji
            </h2>
        </section>
        <section class="create-todo">
            <h3>CREATE A TODO</h3>
            <form action="index.php" method="post" id="new-todo-form">
                <div class="task-input">
                    <input type="text" name="content" id="content" placeholder="e.g. finish homework" onchange="setName(this.value)" required>
                </div>
                <div class="datetime-input">
                    <input type="datetime-local" name="createdAt" id="createdAt" onchange="setDate(this.value)" required>
                </div>
                <div class="add-button">
                    <input type="submit" value="Add todo">
                </div>
            </form>
        </section>
        <!-- TODO List -->
        <section class="completed-list">
            <h3>TODO LIST</h3>
            <table class="list" id="todo-list">
                <tr class="list-header">
                    <th>S.no</th>
                    <th>Task</th>
                    <th>Deadline</th>
                    <th>Status</th>
                </tr>
                <?php echo DisplayTodos(); ?>
            </table>
        </section>
        <!-- End of Todo List -->
    </main>
    <div class="top-buttons">
        <a href="completed.php" class="completed-button">Completed</a>
        <a href="login.php" class="signout-button">Sign Out</a>
    </div>
    <script>
        function setName(value) {
            console.log('setName called with value:', value);
        }

        function setDate(value) {
            console.log('setDate called with value:', value);
        }

        function completeItem(index) {
            window.location.href = 'index.php?complete=' + index;
        }

        function clearAll() {
            if (confirm('Are you sure you want to clear all completed tasks?')) {
                window.location.href = 'index.php?clearall';
            }
        }
    </script>
</body>

</html>
