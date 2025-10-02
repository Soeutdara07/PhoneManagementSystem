<nav class="sidebar" id="sidebar" style="background-color: rgb(12, 135, 184)">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <i class="fas fa-cube"></i>
            BLUE APPLE
        </a>
        <button class="sidebar-close d-lg-none d-md-none" id="sidebarClose" aria-label="Close sidebar">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="sidebar-nav">
        <div class="nav-section">
            <a href="{{ route('dashboard.index') }}" class="nav-link">
                <i class="fas fa-home"></i>
                ទំព័រដើម
            </a>
            <a href="{{ route('supplier.index') }}" class="nav-link">
                <i class="fa-solid fa-building"></i>
                អ្នកផ្គត់ផ្គង់
            </a>
            <!-- Product Dropdown -->
            <div class="nav-dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="collapse"
                    data-bs-target="#productDropdown">
                    <i class="fas fa-box "></i>
                    ផលិតផល
                    <i class="fas fa-chevron-down ms-auto " style="visibility: hidden"></i>
                </a>
                <div class="collapse dropdown-menu-custom" id="productDropdown">
                    <a href="{{ route('brand.index') }}" class="dropdown-item-custom">
                        <i class="fa-solid fa-bandage"></i>
                        ម៉ាក
                    </a>
                    <a href="{{ route('category.index') }}" class="dropdown-item-custom">
                        <i class="fa-solid fa-layer-group"></i>
                        ប្រភេទ
                    </a>
                    <a href="{{ route('product.index') }}" class="dropdown-item-custom">
                        <i class="fas fa-list"></i>
                        ផលិតផលទាំងអស់
                    </a>
                    <a href="{{ route('product_detail.index') }}" class="dropdown-item-custom">
                        <i class="fas fa-info-circle"></i>
                        ព័ត៌មានលម្អិត
                    </a>
                </div>
            </div>

            <a href="#" class="nav-link">
                <i class="fas fa-users"></i>
                អតិថិជន
            </a>

        </div>

        <div class="nav-section">
            <div class="nav-section-title">Tools</div>


            <a href="{{ route('purchases.index') }}" class="nav-link">
                <i class="fas fa-shopping-cart"></i>
                ទិញចូល
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-file-invoice"></i>
                វិកយបត្រ
            </a>

            <a href="#" class="nav-link">
                <i class="fas fa-credit-card"></i>
                Payment
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-envelope"></i>
                Message
                <span class="badge bg-primary rounded-pill">8</span>
            </a>

            <!-- Analytics Dropdown -->
            <div class="nav-dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="collapse"
                    data-bs-target="#analyticsDropdown">
                    <i class="fas fa-chart-bar"></i>
                    Analytics
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse dropdown-menu-custom" id="analyticsDropdown">
                    <a href="#" class="dropdown-item-custom">
                        <i class="fas fa-chart-line"></i>
                        Sales Report
                    </a>
                    <a href="#" class="dropdown-item-custom">
                        <i class="fas fa-chart-pie"></i>
                        Inventory Report
                    </a>
                    <a href="#" class="dropdown-item-custom">
                        <i class="fas fa-chart-area"></i>
                        Performance
                    </a>
                </div>
            </div>

            <a href="#" class="nav-link">
                <i class="fas fa-robot"></i>
                Automation
                <span class="badge bg-info rounded-pill">BETA</span>
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Support</div>

            <!-- Settings Dropdown -->
            <div class="nav-dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="collapse"
                    data-bs-target="#settingsDropdown">
                    <i class="fas fa-cog"></i>
                    Settings
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse dropdown-menu-custom" id="settingsDropdown">
                    <a href="#" class="dropdown-item-custom">
                        <i class="fas fa-user-cog"></i>
                        Profile Settings
                    </a>
                    <a href="#" class="dropdown-item-custom">
                        <i class="fas fa-palette"></i>
                        Appearance
                    </a>
                    <a href="#" class="dropdown-item-custom">
                        <i class="fas fa-bell"></i>
                        Notifications
                    </a>
                </div>
            </div>

            <a href="#" class="nav-link">
                <i class="fas fa-shield-alt"></i>
                Security
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-question-circle"></i>
                Help
            </a>
        </div>
    </div>
</nav>

<style>
    /* Dropdown Styles */
    .nav-dropdown {
        position: relative;
    }

    .dropdown-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dropdown-toggle .fa-chevron-down {
        transition: transform 0.3s ease;
        font-size: 0.75rem;
    }

    .dropdown-toggle[aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg);
    }

    .dropdown-menu-custom {
        padding-left: 0;
        margin-left: 0;
    }

    .dropdown-item-custom {
        display: flex;
        align-items: center;
        padding: 10px 20px 10px 45px;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .dropdown-item-custom i {
        margin-right: 10px;
        font-size: 0.85rem;
        width: 20px;
    }

    .dropdown-item-custom:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        padding-left: 50px;
    }

    .dropdown-item-custom:active,
    .dropdown-item-custom.active {
        background-color: rgba(255, 255, 255, 0.15);
        color: #ffffff;
    }
</style>

<script>
    // Optional: Add JavaScript for better control
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle dropdown icon rotation
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-bs-target');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', !isExpanded);
                }
            });
        });
    });
</script>
