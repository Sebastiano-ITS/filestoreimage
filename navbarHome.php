<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", sans-serif;
        }
        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            width: 100%;
            box-sizing: border-box;
        }

        .navbar h1 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-links a {
            margin-left: 15px;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
            color: white;
        }

        .home-btn {
            background: #10b981;
        }

        .home-btn:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .logout-btn {
            background: #ef4444;
        }

        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        /* Bottone Profilo (icona) */
        .profile-btn {
            background: #6b7280;
            color: white;
            padding: 10px 14px;
            border-radius: 50%;
            margin-left: 15px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .profile-btn:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .navbar {
                padding: 12px 18px;
            }

            .navbar h1 {
                font-size: 16px;
            }

            .nav-links a {
                padding: 8px 14px;
                font-size: 14px;
            }

            .profile-btn {
                padding: 8px 12px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h1>I tuoi File</h1>

    <div class="nav-links">
        <a href="logout.php" class="logout-btn">Disconetti</a>

        <!-- Icona Profilo -->
        <a href="profile.php" class="profile-btn">
            <i class="fas fa-user"></i>
        </a>
    </div>
</div>

</body>
</html>
