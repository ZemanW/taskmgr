<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Management App - Inbox</title>
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
    
    .view-switcher {
      display: flex;
      margin-bottom: 20px;
    }
    
    .view-option {
      padding: 8px 16px;
      border-radius: 8px;
      margin-right: 12px;
      cursor: pointer;
      font-size: 14px;
    }
    
    .view-option.active {
      background-color: #e1f5fe;
      color: #0288d1;
    }
    
    .message-list {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }
    
    .message-item {
      display: flex;
      padding: 16px;
      border-bottom: 1px solid #eee;
    }
    
    .message-item:last-child {
      border-bottom: none;
    }
    
    .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #e0e0e0;
      margin-right: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 500;
      color: #666;
    }
    
    .message-content {
      flex: 1;
    }
    
    .message-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
    }
    
    .sender-name {
      font-weight: 500;
    }
    
    .message-time {
      color: #888;
      font-size: 12px;
    }
    
    .message-subject {
      font-weight: 500;
      margin-bottom: 4px;
    }
    
    .message-preview {
      color: #666;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
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
    
    <a href="http://localhost/TaskManager/view/mywork.php" class="sidebar-item">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="7" height="7"></rect>
        <rect x="14" y="3" width="7" height="7"></rect>
        <rect x="14" y="14" width="7" height="7"></rect>
        <rect x="3" y="14" width="7" height="7"></rect>
      </svg>
      My Work
    </a>
    
    <a href="http://localhost/TaskManager/view/notification.php" class="sidebar-item active">
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
    <h1>Inbox</h1>
    <div class="subtitle">You have 3 unread messages</div>
    
    <input type="text" class="search-bar" placeholder="Search messages">
    
    <div class="view-switcher">
      <div class="view-option active">All</div>
      <div class="view-option">Unread</div>
      <div class="view-option">Flagged</div>
    </div>
    
    <div class="message-list">
      <div class="message-item">
        <div class="avatar">JD</div>
        <div class="message-content">
          <div class="message-header">
            <div class="sender-name">John Doe</div>
            <div class="message-time">10:30 AM</div>
          </div>
          <div class="message-subject">Re: App Design Feedback</div>
          <div class="message-preview">I've looked at the latest mockups and I think the navigation needs some work. The user flow seems...</div>
        </div>
      </div>
      
      <div class="message-item">
        <div class="avatar">SM</div>
        <div class="message-content">
          <div class="message-header">
            <div class="sender-name">Sarah Miller</div>
            <div class="message-time">Yesterday</div>
          </div>
          <div class="message-subject">Product team meeting agenda</div>
          <div class="message-preview">Here's the agenda for tomorrow's meeting. Please review and let me know if you have any topics to add...</div>
        </div>
      </div>
      
      <div class="message-item">
        <div class="avatar">TW</div>
        <div class="message-content">
          <div class="message-header">
            <div class="sender-name">Tom Wilson</div>
            <div class="message-time">Yesterday</div>
          </div>
          <div class="message-subject">User testing schedule</div>
          <div class="message-preview">The user testing for the new app is scheduled for next week. Please confirm your availability...</div>
        </div>
      </div>
      </div>
      </div>
      </body>
      </html>

