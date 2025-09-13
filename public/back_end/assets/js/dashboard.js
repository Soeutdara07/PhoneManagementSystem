// Script Design Dashboard=================
        // Sidebar state management
        let sidebarState = {
            isOpen: window.innerWidth > 768,
            isMobile: window.innerWidth <= 768
        };

        // Get DOM elements
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const teamIndicator = document.getElementById('teamIndicator');
        const overlay = document.getElementById('overlay');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');

        // Update sidebar state based on screen size
        function updateSidebarState() {
            const wasMobile = sidebarState.isMobile;
            sidebarState.isMobile = window.innerWidth <= 768;
            
            // If transitioning from mobile to desktop
            if (wasMobile && !sidebarState.isMobile) {
                sidebarState.isOpen = true;
                updateSidebarUI();
            }
            // If transitioning from desktop to mobile
            else if (!wasMobile && sidebarState.isMobile) {
                sidebarState.isOpen = false;
                updateSidebarUI();
            }
        }

        // Update UI based on sidebar state
        function updateSidebarUI() {
            if (sidebarState.isMobile) {
                // Mobile behavior
                if (sidebarState.isOpen) {
                    sidebar.classList.remove('collapsed');
                    sidebar.classList.add('show');
                    overlay.classList.add('show');
                    document.body.style.overflow = 'hidden';
                } else {
                    sidebar.classList.add('collapsed');
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
                mainContent.classList.add('expanded');
                teamIndicator.classList.remove('shifted');
            } else {
                // Desktop behavior
                if (sidebarState.isOpen) {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                    teamIndicator.classList.add('shifted');
                } else {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                    teamIndicator.classList.remove('shifted');
                }
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }

            // Update toggle button icon
            const toggleIcon = sidebarToggle.querySelector('i');
            if (sidebarState.isOpen && !sidebarState.isMobile) {
                toggleIcon.className = 'fas fa-times';
            } else {
                toggleIcon.className = 'fas fa-bars';
            }
        }

        // Toggle sidebar
        function toggleSidebar() {
            sidebarState.isOpen = !sidebarState.isOpen;
            updateSidebarUI();
        }

        // Close sidebar
        function closeSidebar() {
            sidebarState.isOpen = false;
            updateSidebarUI();
        }

        // Event listeners
        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarClose.addEventListener('click', closeSidebar);

        // Close sidebar when clicking overlay (mobile)
        overlay.addEventListener('click', closeSidebar);

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (sidebarState.isMobile && sidebarState.isOpen) {
                if (!sidebar.contains(e.target) && 
                    !sidebarToggle.contains(e.target) && 
                    !e.target.closest('.sidebar')) {
                    closeSidebar();
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            updateSidebarState();
        });

        // Handle zoom changes
        window.addEventListener('resize', function() {
            // Debounce the resize handler
            clearTimeout(window.resizeTimeout);
            window.resizeTimeout = setTimeout(function() {
                updateSidebarState();
            }, 100);
        });

        // Keyboard accessibility
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebarState.isOpen && sidebarState.isMobile) {
                closeSidebar();
            }
        });

        // Navigation link interactions
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // e.preventDefault();
                
                // Remove active class from all links
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Close sidebar on mobile after navigation
                if (sidebarState.isMobile) {
                    setTimeout(() => {
                        closeSidebar();
                    }, 150);
                }
            });
        });

        // Initialize sidebar state
        updateSidebarUI();

        // Smooth scrolling for better UX
        document.documentElement.style.scrollBehavior = 'smooth';

        // Add loading animation for stats cards
        document.querySelectorAll('.stats-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Add focus management for accessibility
        sidebarToggle.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleSidebar();
            }
        });

        sidebarClose.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                closeSidebar();
            }
        });

        // Trap focus in sidebar when open on mobile
        function trapFocus(element) {
            const focusableElements = element.querySelectorAll(
                'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select'
            );
            const firstFocusableElement = focusableElements[0];
            const lastFocusableElement = focusableElements[focusableElements.length - 1];

            element.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    if (e.shiftKey) {
                        if (document.activeElement === firstFocusableElement) {
                            lastFocusableElement.focus();
                            e.preventDefault();
                        }
                    } else {
                        if (document.activeElement === lastFocusableElement) {
                            firstFocusableElement.focus();
                            e.preventDefault();
                        }
                    }
                }
            });
        }

        // Apply focus trap to sidebar
        trapFocus(sidebar);

        //  End Script Design Dashboard=================

        
            
