// Tab navigation
document.addEventListener('DOMContentLoaded', function() {
    // Set default active tab to My Work (as in the original image)
    document.getElementById('work-tab').classList.add('active');
    document.getElementById('work-content').classList.add('active');
    
    // Handle tab clicks
    const tabs = document.querySelectorAll('.sidebar-item');
    tabs.forEach(tab => {
      tab.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all tabs and content
        document.querySelectorAll('.sidebar-item').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        
        // Add active class to clicked tab
        this.classList.add('active');
        
        // Show corresponding content
        const contentId = this.getAttribute('id').replace('-tab', '-content');
        document.getElementById(contentId).classList.add('active');
      });
    });
  });