<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>to-do-list</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="todo-container">
        <h1>To-Do-List</h1>
        <form class="todo-form" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <input type="text" name="task" id="task" placeholder="tambahkan tugas baru...">
            <button type="submit" name="add">Tambah</button>

        </form>
        <?php 
            // mulai session
            session_start();
            // inisialisasi array untuk daftar todos jika belum ada
            if (!isset($_SESSION['task'])) {

                $_SESSION['task'] = [];
            }

            // jika ada form yang di submit maka tambahkan to do ke daftar todos
            if (isset($_POST['add'])) {
                $task = trim($_POST['task']);
                if (!empty($task)){
                    // menambahkan task ke session array todos
                    $_SESSION['tasks'][]= $task;
                }
                // redirect untuk menghindari resubmission saat refresh
                header('Location:' . htmlspecialchars($_SERVER['PHP_SELF']));
                exit();
            }

            // jika ada request untuk mengahpus todo 
         if (isset($_POST['delete'])) {
            $index_to_delete = $_POST['delete'];
                if(isset($_SESSION['tasks'])){
                    unset($_SESSION['tasks'][$index_to_delete]);
                    //  reset index array setelah penghapusan
                    $_SESSION['tasks'] = array_values($_SESSION['tasks']);
                }
                header('Location:' . htmlspecialchars($_SERVER['PHP_SELF']));
                exit();
            }
        
        
        
        ?>
        <ul class="todo-list">
            <?php foreach($_SESSION['tasks'] as $index => $task):?>
                <li>
                    <?= htmlspecialchars($task); ?>
                    <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" style="display: inline;">
                        <input type="hidden" name="delete" value="<?= $index; ?>">
                        <button type="submit" class="delete-btn">Hapus</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>