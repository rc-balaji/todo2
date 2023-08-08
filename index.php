<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head section same as before -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
        *
        {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body 
        {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
            background-image: url("bg.png");
            background-repeat: no-repeat;
            background-size: cover;
        }
        .body 
        {
            position: relative;
            width: 680px;
            height: auto;
            background: #1c1c1c;
            border-radius: 8px;
            overflow: hidden;
        }
        .completed-button{
            text-decoration: none;
        }
        .top-btn,.completed-button{
            padding: 5px 10px;
            background-color: #ff5b57;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .top-btn:hover,.completed-button:hover{
            background-color:black;
            
        }
        .top-btn:hover{
            background-color:black;
            border: 1px solid white;
        }
        .top-buttons{
            margin-bottom: 30px;
            margin-left: 460px;
            margin-top: 40px;
        }
        .create-todo input[type="submit"]{
            border: none;
            outline: none;
            padding: 8px;
            background-color: #9026d7;
            cursor: pointer;
            border-radius: 4px;
            font-weight: 600;
            width: 100px;
            color: black;
            margin-bottom: 30px;
            
        }
        
        
        .create-todo input[type="text"],
.create-todo input[type="datetime-local"] {
    background-color: #45f3ff;
}
    </style>
</head>
<body>
<div class="top-buttons">
        <button class="top-btn" >
        <a href="completed.php" class="completed-button">Completed</a></button>
        <button class="top-btn">  <a href="login.php" class="completed-button">Sign Out</a></button>
    </div>
    <div class="body" >
    
    <main class="app">
        <section class="greeting">

            <h2 class="title" style="color:#45f3ff" >
                What's up, Balaji
            </h2>
        </section>
        
        <section class="create-todo">
            <h3 style="color:#45f3ff" >CREATE A TODO</h3>
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
        </section style="color:#45f3ff" >
        <!-- TODO List -->
            <h3 style="color:#45f3ff" >TODO LIST</h3>
            <table style="background-color:#45f3ff" class="list" id="todo-list">
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
    </div>
    <script>
         function completeItem(index) {
            window.location.href = 'index.php?complete=' + index;
        }

        function clearAll() {
            if (confirm('Are you sure you want to clear all completed tasks?')) {
                window.location.href = 'index.php?clearall';
            }
        }
        
        function setDate(value) {
            var selectedTime = value.slice(11, 16);
        }

        function setName(value) {
            var inputName = value;
        } </script>

<?php
function readTodos() {
    $todos = json_decode(file_get_contents('todos.json'), true) ?: [];
    return $todos;
}

function writeTodos($todos) {
    file_put_contents('todos.json', json_encode($todos, JSON_PRETTY_PRINT));
}

function readCompleted() {
    $completed = json_decode(file_get_contents('completed.json'), true) ?: [];
    return $completed;
}

function writeCompleted($completed) {
    file_put_contents('completed.json', json_encode($completed, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function DisplayTodos()
{
    $todos = readTodos();
    $todoList = '';
    $counter = 1;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = $_POST['content'];
        $createdAt = $_POST['createdAt'];
        
        // Check if content is not empty before adding the task
        if (!empty($content) && !empty($createdAt)) {
            $todo = [
                'content' => $content,
                'done' => false,
                'createdAt' => $createdAt
            ];
            $todos[] = $todo;
            writeTodos($todos);
        }

        header("Location: index.php");
        exit();
    }

    if (isset($_GET['complete'])) {
        $index = $_GET['complete'];
        if (isset($todos[$index])) {
            $completed = readCompleted();
            $completedTodo = $todos[$index];
            $completedTodo['completedAt'] = date('Y-m-d H:i:s');
            $completed[] = $completedTodo;
            unset($todos[$index]);
            writeCompleted($completed);
            writeTodos($todos);
            header("Location: index.php");
            exit();
        }
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

</body>
</html>
