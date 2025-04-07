<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Management App - My Work</title>
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
    
    .search-bar {
      width: 100%;
      padding: 12px;
      background-color: #f2f2f2;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      margin-bottom: 20px;
      color: #333;
    }
    
    .search-bar::placeholder {
      color: #888;
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
  </style>
</head>
<body>
  <div class="sidebar">
    <a href="http://localhost/TaskManager/view/home.php" class="sidebar-item">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
        <polyline points="9 22 9 12 15 12 15 22"></polyline>
      </svg>
      Home
    </a>
    
    <a href="http://localhost/TaskManager/view/mywork.php" class="sidebar-item active">
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
    <h1>My work</h1>
    <div class="subtitle">You are not a member of any teams</div>
    
    <input type="text" class="search-bar" placeholder="Search for tasks">
    
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
          <div class="task-title">Meet with the product team to discuss the new app</div>
          <div class="task-due">Due Tomorrow</div>
        </div>
      </div>
      
      <div class="task-item">
        <div class="checkbox"></div>
        <div class="task-details">
          <div class="task-title">Review the wireframes for the new app</div>
          <div class="task-due">Due in 3 days</div>
        </div>
      </div>
      
      <div class="task-item">
        <div class="checkbox"></div>
        <div class="task-details">
          <div class="task-title">Conduct a usability test for the new app</div>
          <div class="task-due">Due in 5 days</div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>