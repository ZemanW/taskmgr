<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Get user data and task statistics
try {
    // Get user data
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    // Get tasks due today
    $stmt = $pdo->prepare("SELECT COUNT(*) as today_count FROM tasks WHERE user_id = ? AND DATE(due_date) = CURDATE()");
    $stmt->execute([$_SESSION['user_id']]);
    $tasksToday = $stmt->fetch()['today_count'];

    // Get tasks in progress
    $stmt = $pdo->prepare("SELECT COUNT(*) as progress_count FROM tasks WHERE user_id = ? AND status = 'in_progress'");
    $stmt->execute([$_SESSION['user_id']]);
    $tasksInProgress = $stmt->fetch()['progress_count'];

    // Get completed tasks this week
    $stmt = $pdo->prepare("SELECT COUNT(*) as completed_count FROM tasks WHERE user_id = ? AND status = 'completed' AND created_at >= DATE_SUB(NOW(), INTERVAL 1 WEEK)");
    $stmt->execute([$_SESSION['user_id']]);
    $completedThisWeek = $stmt->fetch()['completed_count'];

    // Get unread notifications count
    $stmt = $pdo->prepare("SELECT COUNT(*) as notification_count FROM notifications WHERE user_id = ? AND is_read = 0");
    $stmt->execute([$_SESSION['user_id']]);
    $unreadNotifications = $stmt->fetch()['notification_count'];

    // Get today's tasks
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? AND DATE(due_date) = CURDATE() ORDER BY due_date ASC");
    $stmt->execute([$_SESSION['user_id']]);
    $todayTasks = $stmt->fetchAll();

    // Get recently updated tasks
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY updated_at DESC LIMIT 5");
    $stmt->execute([$_SESSION['user_id']]);
    $recentTasks = $stmt->fetchAll();

} catch(PDOException $e) {
    error_log("Error fetching dashboard data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Management App - Home</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    
    body {
      background-color: #f7f7f7;
      display: flex;
      min-height: 100vh;
    }
    
    .sidebar {
      width: 300px;
      background-color: white;
      border-right: 1px solid #e0e0e0;
      padding: 20px;
      height: 100vh;
      position: fixed;
      overflow-y: auto;
    }
    
    .sidebar-item {
      display: flex;
      align-items: center;
      padding: 12px 16px;
      margin-bottom: 8px;
      border-radius: 8px;
      cursor: pointer;
      color: #333;
      font-size: 14px;
      text-decoration: none;
    }
    
    .sidebar-item.active {
      background-color: #f2f2f2;
      font-weight: 500;
    }
    
    .sidebar-item:hover:not(.active) {
      background-color: #f8f8f8;
    }
    
    .sidebar-item svg {
      margin-right: 12px;
      color: #555;
    }
    
    .main-content {
      flex: 1;
      padding: 32px;
      margin-left: 300px;
    }
    
    h1 {
      font-size: 24px;
      font-weight: 600;
      color: #111;
      margin-bottom: 8px;
    }
    
    .subtitle {
      color: #666;
      font-size: 14px;
      margin-bottom: 24px;
    }
    
    .task-container {
      margin-top: 20px;
    }
    
    .task-item {
      display: flex;
      align-items: flex-start;
      padding: 16px 0;
      border-bottom: 1px solid #eee;
    }
    
    .checkbox {
      width: 18px;
      height: 18px;
      border: 2px solid #ddd;
      border-radius: 4px;
      margin-right: 16px;
      cursor: pointer;
      margin-top: 2px;
    }
    
    .task-details {
      flex: 1;
    }
    
    .task-title {
      font-size: 16px;
      font-weight: 500;
      color: #333;
      margin-bottom: 4px;
    }
    
    .task-due {
      font-size: 14px;
      color: #888;
    }
    
    .bottom-buttons {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 300px;
      padding: 20px;
      background-color: white;
    }
    
    .button {
      display: flex;
      align-items: center;
      padding: 12px 16px;
      margin-bottom: 8px;
      cursor: pointer;
      color: #333;
      font-size: 14px;
      border-radius: 8px;
    }
    
    .button:hover {
      background-color: #f8f8f8;
    }
    
    .button svg {
      margin-right: 12px;
      color: #555;
    }
    
    .content-card {
      background-color: white;
      border-radius: 12px;
      padding: 24px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
      margin-bottom: 24px;
    }
    
    .card-title {
      font-size: 18px;
      font-weight: 500;
      margin-bottom: 16px;
      color: #222;
    }
    
    .welcome-header {
      display: flex;
      align-items: center;
      margin-bottom: 32px;
    }
    
    .welcome-header .avatar {
      width: 64px;
      height: 64px;
      font-size: 24px;
      margin-right: 24px;
      background-color: #e0e0e0;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 500;
      color: #666;
    }
    
    .stats-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 16px;
      margin-bottom: 32px;
    }
    
    .stat-card {
      background-color: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }
    
    .stat-title {
      color: #666;
      font-size: 14px;
      margin-bottom: 8px;
    }
    
    .stat-value {
      font-size: 24px;
      font-weight: 600;
      color: #333;
    }
    
    .recent-section {
      margin-top: 32px;
    }
    
    h2 {
      font-size: 20px;
      font-weight: 500;
      color: #333;
      margin-bottom: 16px;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <a href="http://localhost/TaskManager/view/home.php" class="sidebar-item active">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
        <polyline points="9 22 9 12 15 12 15 22"></polyline>
      </svg>
      Home
    </a>
    
    <a href="http://localhost/TaskManager/view/mywork.php" class="sidebar-item">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="7" height="7"></rect>
        <rect x="14" y="3" width="7" height="7"></rect>
        <rect x="14" y="14" width="7" height="7"></rect>
        <rect x="3" y="14" width="7" height="7"></rect>
      </svg>
      My Work
    </a>
    
    <a href="http://localhost/TaskManager/view/notification.php" class="sidebar-item">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
      </svg>
      Inbox
    </a>
    
    <a href="../controllers/logout.php" class="sidebar-item">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
        <polyline points="16 17 21 12 16 7"></polyline>
        <line x1="21" y1="12" x2="9" y2="12"></line>
      </svg>
      Logout
    </a>
    
    <div class="bottom-buttons">
      <div class="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19"></line>
          <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Create
      </div>
    </div>
  </div>
  
  <div class="main-content">
    <div class="welcome-header">
      <div class="avatar">
        <?php 
        // Safely get the first letter of the user's name
        echo isset($user['NAME']) ? strtoupper(substr($user['NAME'], 0, 1)) : '?'; 
        ?>
      </div>
      <div>
        <h1>Welcome back, <?php echo isset($user['NAME']) ? htmlspecialchars($user['NAME']) : 'User'; ?></h1>
        <div class="subtitle">Here's what's happening today</div>
      </div>
    </div>
    
    <div class="stats-container">
      <div class="stat-card">
        <div class="stat-title">Tasks Due Today</div>
        <div class="stat-value"><?php echo $tasksToday; ?></div>
      </div>
      
      <div class="stat-card">
        <div class="stat-title">Tasks In Progress</div>
        <div class="stat-value"><?php echo $tasksInProgress; ?></div>
      </div>
      
      <div class="stat-card">
        <div class="stat-title">Completed This Week</div>
        <div class="stat-value"><?php echo $completedThisWeek; ?></div>
      </div>
      
      <div class="stat-card">
        <div class="stat-title">New Messages</div>
        <div class="stat-value"><?php echo $unreadNotifications; ?></div>
      </div>
    </div>
    
    <div class="content-card">
      <div class="card-title">Today's Schedule</div>
      <div class="task-container">
        <div class="task-item">
          <div class="checkbox"></div>
          <div class="task-details">
            <div class="task-title">Design the UI for the new app</div>
            <div class="task-due">Due Today</div>
          </div>
        </div>
        
        <div class="task-item">
          <div class="checkbox"></div>
          <div class="task-details">
            <div class="task-title">Write the user guide for the new app</div>
            <div class="task-due">Due Today</div>
          </div>
        </div>
        
        <div class="task-item">
          <div class="checkbox"></div>
          <div class="task-details">
            <div class="task-title">Team Standup Meeting</div>
            <div class="task-due">10:00 AM - 10:30 AM</div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="recent-section">
      <h2>Recently Updated</h2>
      <div class="content-card">
        <div class="task-container">
          <div class="task-item">
            <div class="checkbox"></div>
            <div class="task-details">
              <div class="task-title">Finalize Q2 Planning</div>
              <div class="task-due">Updated 2 hours ago</div>
            </div>
          </div>
          
          <div class="task-item">
            <div class="checkbox"></div>
            <div class="task-details">
              <div class="task-title">Review marketing materials</div>
              <div class="task-due">Updated yesterday</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php
// Helper function for time ago format
function timeAgo($datetime) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->d == 0) {
        if ($diff->h == 0) {
            return "just now";
        }
        return $diff->h . " hours ago";
    }
    if ($diff->d == 1) {
        return "yesterday";
    }
    return $diff->d . " days ago";
}
?>