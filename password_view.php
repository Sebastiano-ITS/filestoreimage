<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';

// RECUPERO PASSWORD DAL DATABASE
$stmt = $conn->prepare("SELECT id, service, username, password_encrypted FROM passwords WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$passwords = [];
while ($row = $result->fetch_assoc()) {
    $passwords[] = $row;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f3;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #aaa;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background: #3498db;
            color: white;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 6px;
        }

        .btn-show {
            background: #2ecc71;
        }

        .btn-hide {
            background: #e74c3c;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .back-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background: #555;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
        }

        .back-btn:hover {
            background: #333;
        }
    </style>

    <script>
        function togglePassword(id) {
            let field = document.getElementById("pwd_" + id);
            let btn = document.getElementById("btn_" + id);

            if (field.dataset.visible === "0") {
                field.innerText = field.dataset.real;
                field.dataset.visible = "1";
                btn.innerText = "Nascondi";
                btn.classList.remove("btn-show");
                btn.classList.add("btn-hide");
            } else {
                field.innerText = "********";
                field.dataset.visible = "0";
                btn.innerText = "Mostra";
                btn.classList.remove("btn-hide");
                btn.classList.add("btn-show");
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h2>📌 Le tue password salvate</h2>

    <table>
        <tr>
            <th>Servizio</th>
            <th>Username</th>
            <th>Password</th>
            <th>Azioni</th>
        </tr>

        <?php foreach ($passwords as $p): ?>
        <tr>
            <td><?php echo htmlspecialchars($p['servizio']); ?></td>
            <td><?php echo htmlspecialchars($p['username']); ?></td>

            <td id="pwd_<?php echo $p['id']; ?>"
                data-visible="0"
                data-real="<?php echo htmlspecialchars($p['password']); ?>">
                ********
            </td>

            <td>
                <button class="btn btn-show"
                        id="btn_<?php echo $p['id']; ?>"
                        onclick="togglePassword(<?php echo $p['id']; ?>)">
                    Mostra
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <a href="dashboard.php" class="back-btn">⬅ Torna alla Dashboard</a>
</div>

</body>
</html>
