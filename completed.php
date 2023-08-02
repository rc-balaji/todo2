<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed List</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <main class="app">
        <!-- Completed List -->
        <section class="completed-list">
            <div class="completed-heading">Completed Task<span class="clear-all-button" onclick="clearAll()">Clear All</span></div>
            <table class="list" id="completed-list">
                <tr class="list-header">
                    <th>S.no</th>
                    <th>Task</th>
                    <th>Completed Time</th>
                </tr>
                <?php
                $completed = json_decode(file_get_contents('completed.json'), true) ?: [];
                $completedList = '';
                $counter = 1;
                if (isset($_GET['clearall'])) {
                    $completed = [];
                    file_put_contents('completed.json', json_encode($completed));
                }
                foreach ($completed as $index => $task) {
                    echo '<tr>';
                    echo '<td>' . $counter . '</td>';
                    echo '<td>' . htmlspecialchars($task['content']) . '</td>';
                    echo '<td>' . date('d.m.Y H:i', strtotime($task['completedAt'])) . '</td>';
                    echo '</tr>';
                    $counter++;
                }
                ?>
            </table>
        </section>
        <!-- End of Completed List -->
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
