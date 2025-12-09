<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Actions</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 60px auto;
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: white;
            margin-bottom: 25px;
        }
        .action-card-container {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .action-card {
            background: #1e1e1e;
            color: #fff;
            width: 350px;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.35);
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.45);
        }

        .action-card h2 {
            margin-bottom: 20px;
            font-size: 22px;
        }

.action-btn {
    width: 100%;
    padding: 10px 0;
    margin: 10px 0;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
    background-color: #440000;
    color: #fff;
    transition: background-color 0.2s ease;
}

.action-btn:hover {
    background-color: #660000;
}

.action-btn.manual {
    background-color: #440000;
}
.action-btn.manual:hover {
    background-color: #660000;
}

.action-btn.lock {
    background-color: #440000;
}
.action-btn.lock:hover {
    background-color: #660000;
}

.action-info {
    margin-top: 15px;
    font-size: 14px;
    opacity: 0.8;
}

    </style>
</head>

<body>
    <div class="action-card-container">

        <div class="action-card">
            <h2>Choose Attendance Action</h2>
    
            <!-- Generate Attendance Code -->
            <form action="generate_code.php" method="POST">
                <input type="hidden" name="session_id" value="<?= $_GET['session_id'] ?? '' ?>">
                <button class="action-btn">Generate Attendance Code</button>
            </form>
    
            <!-- Mark Manual Attendance -->
            <form action="manual_attendance.php" method="GET">
                <input type="hidden" name="session_id" value="<?= $_GET['session_id'] ?? '' ?>">
                <button class="action-btn manual">Mark Attendance Manually</button>
            </form>
    
            <!-- Lock Attendance -->
            <form action="lock_attendance.php" method="POST"
                  onsubmit="return confirm('Are you sure you want to lock attendance? Students will no longer be able to sign in.')">
                <input type="hidden" name="session_id" value="<?= $_GET['session_id'] ?? '' ?>">
                <button class="action-btn lock">Lock Attendance</button>
            </form>
    
            <p class="action-info">Choose one of the options to manage this session’s attendance.</p>
        </div>
    
    </div>
    <a href="facultydashboard.php" class="button">Back to Dashboard</a>
</body>
</html>
