document.addEventListener('DOMContentLoaded', function() {
    // Section Navigation
    const navLinks = document.querySelectorAll('.dashboard-link');
    const contentSections = document.querySelectorAll('.content-section');
    
    // Function to activate a section
    const activateSection = (sectionId) => {
        // Remove active class from all links and sections
        navLinks.forEach(l => l.classList.remove('active'));
        contentSections.forEach(s => s.classList.remove('active'));
        
        // Add active class to the target link and section
        const targetLink = document.querySelector(`.dashboard-link[data-section="${sectionId}"]`);
        const targetSection = document.getElementById(`${sectionId}-section`);
        
        if (targetLink) targetLink.classList.add('active');
        if (targetSection) targetSection.classList.add('active');
        
        // Store active section in localStorage
        localStorage.setItem('activeSection', sectionId);
    };

    // Set active section from localStorage if available
    const activeSection = localStorage.getItem('activeSection') || 'dashboard';
    activateSection(activeSection);

    // Handle link clicks
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('data-section');
            activateSection(sectionId);
            
            // Close sidebar on mobile
            if (window.innerWidth < 992) {
                document.querySelector('.dashboard-sidebar').classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    });

    // Mobile Menu Toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const sidebar = document.querySelector('.dashboard-sidebar');
    
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : 'auto';
        });
    }

    // Modal Toggle Functionality
    const toggleModal = (modal, show) => {
        if (show) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        } else {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    };

    // Edit Profile Modal
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const editProfileModal = document.getElementById('edit-profile-modal');
    const closeModalButtons = document.querySelectorAll('.close-modal, .cancel-edit');

    if (editProfileBtn && editProfileModal) {
        editProfileBtn.addEventListener('click', () => toggleModal(editProfileModal, true));
    }

    if (closeModalButtons) {
        closeModalButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                toggleModal(editProfileModal, false);
            });
        });
    }

    // Delete Profile Modal
    const deleteProfileBtn = document.getElementById('delete-profile-btn');
    const deleteProfileModal = document.getElementById('delete-profile-modal');
    const cancelDeleteBtn = document.querySelector('.cancel-delete');

    if (deleteProfileBtn && deleteProfileModal) {
        deleteProfileBtn.addEventListener('click', () => toggleModal(deleteProfileModal, true));
    }

    if (cancelDeleteBtn) {
        cancelDeleteBtn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleModal(deleteProfileModal, false);
        });
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (editProfileModal && e.target === editProfileModal) {
            toggleModal(editProfileModal, false);
        }
        if (deleteProfileModal && e.target === deleteProfileModal) {
            toggleModal(deleteProfileModal, false);
        }
    });

    // Theme Toggle
    const themeToggle = document.createElement('button');
    themeToggle.className = 'btn btn-sm btn-outline theme-toggle';
    themeToggle.innerHTML = '<i class="fas fa-moon"></i> Dark Mode';
    document.querySelector('.header-right').prepend(themeToggle);
    
    themeToggle.addEventListener('click', function() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        themeToggle.innerHTML = newTheme === 'dark' 
            ? '<i class="fas fa-sun"></i> Light Mode' 
            : '<i class="fas fa-moon"></i> Dark Mode';
    });

    // Set initial theme from localStorage
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    if (savedTheme === 'dark') {
        themeToggle.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
    }

    // File Upload Display
    const fileInput = document.getElementById('profile-pic');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
            document.querySelector('.file-name').textContent = fileName;
        });
    }

    // Sample data and rendering functions
    const renderActivities = () => {
        const activities = [
            { icon: 'fa-book', title: 'New assignment posted in CS 101', time: '2 hours ago' },
            { icon: 'fa-calendar-alt', title: 'Exam scheduled for next week', time: '1 day ago' },
            { icon: 'fa-comment', title: 'New announcement from Prof. Johnson', time: '2 days ago' },
            { icon: 'fa-check-circle', title: 'Assignment submitted successfully', time: '3 days ago' }
        ];

        const activityList = document.querySelector('.activity-list');
        if (activityList) {
            activityList.innerHTML = activities.map(activity => `
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas ${activity.icon}"></i>
                    </div>
                    <div class="activity-content">
                        <h4 class="activity-title">${activity.title}</h4>
                        <p class="activity-time">${activity.time}</p>
                    </div>
                </div>
            `).join('');
        }
    };

    const renderCourses = () => {
        const courses = [
            { code: 'CS 101', title: 'Introduction to Programming', professor: 'Prof. Sarah Johnson', progress: 75, color: 'primary' },
            { code: 'MATH 201', title: 'Calculus II', professor: 'Prof. Michael Brown', progress: 60, color: 'secondary' },
            { code: 'ENG 105', title: 'Academic Writing', professor: 'Prof. Emily Wilson', progress: 90, color: 'success' },
            { code: 'PHYS 101', title: 'Physics Fundamentals', professor: 'Prof. David Lee', progress: 45, color: 'warning' }
        ];

        const coursesGrid = document.querySelector('.courses-grid');
        if (coursesGrid) {
            coursesGrid.innerHTML = courses.map(course => `
                <div class="course-card">
                    <div class="course-header bg-${course.color}">
                        <h3>${course.code}</h3>
                        <p>${course.title}</p>
                    </div>
                    <div class="course-body">
                        <p>${course.professor}</p>
                        <div class="course-progress">
                            <div class="progress-bar">
                                <div class="progress" style="width: ${course.progress}%;"></div>
                            </div>
                            <span>${course.progress}% Complete</span>
                        </div>
                    </div>
                    <div class="course-footer">
                        <a href="#" class="btn btn-sm btn-primary">View Course</a>
                    </div>
                </div>
            `).join('');
        }
    };

    // Initialize components
    renderActivities();
    renderCourses();

    // Responsive adjustments
    function handleResize() {
        if (window.innerWidth >= 992) {
            sidebar.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }

    window.addEventListener('resize', handleResize);
});