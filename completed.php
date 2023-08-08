<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed List</title>
    <link rel="stylesheet" href="style.css">
    </head>
    <style>
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
.app
        {
            position: relative;
            width: 680px;
            height: auto;
            background: #1c1c1c;
            border-radius: 8px;
            overflow: hidden;
        }

    </style>

<body>
    <main class="app">
        <section class="completed-list">
            <div style="color:#45f3ff" class="completed-heading">Completed Task<span class="clear-all-button" onclick="clearAll()">Clear All</span></div>
            <table style="background-color:#45f3ff"  class="list" id="completed-list">
                <tr class="list-header">
                    <th>S.no</th>
                    <th>Task</th>
                    <th>Completed Time</th>
                </tr>
                <?php echo DisplayCompleted(); ?>
            </table>
        </section>
    </main>
    <script>
        function clearAll() {
            if (confirm('Are you sure you want to clear all completed tasks?')) {
                window.location.href = 'completed.php?clearall';
            }
        }
    </script>
</body>

</html>

<?php
function readCompleted() {
    $completed = json_decode(file_get_contents('completed.json'), true) ?: [];
    return $completed;
}

function writeCompleted($completed) {
    file_put_contents('completed.json', json_encode($completed, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function DisplayCompleted()
{
    $completed = readCompleted();
    $completedList = '';
    $counter = 1;

    if (isset($_GET['clearall'])) {
        $completed = [];
        writeCompleted($completed);
        header("Location: index.php");
        exit();
    }

    if (empty($completed)) {
        $completedList .= '<tr><td colspan="3" class="no-task">Not Yet Completed</td></tr>';
    } else {
        foreach ($completed as $todo) {
            $completedList .= '<tr class="completed-item">';
            $completedList .= '<td class="completed-serial">' . $counter . '.</td>';
            $completedList .= '<td class="completed-content">' . htmlspecialchars($todo['content']) . '</td>';
            $completedList .= '<td class="completed-at">';
            $completedList .= 'Date: ' . date('d.m.Y H:i', strtotime($todo['completedAt'])) . '<br>';
            $completedList .= 'Time: ' . date('H:i', strtotime($todo['completedAt']));
            $completedList .= '</td>';
            $completedList .= '</tr>';
            $counter++;
        }
    }
    return $completedList;
}
?>