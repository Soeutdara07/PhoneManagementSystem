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
                    Dashboard
                </a>
                <a href="{{ route('brand.index')}}" class="nav-link">
                   <i class="fa-solid fa-bandage"></i>
                    Brand
                </a>
                 <a href="{{ route('category.index')}}" class="nav-link">
                  <i class="fa-solid fa-layer-group"></i>
                    Category
                </a>
                 <a href="{{ route('supplier.index')}}" class="nav-link">
                   <i class="fa-solid fa-building"></i>
                    Supplier
                </a>
                 <a href="#" class="nav-link">
                    <i class="fas fa-credit-card"></i>
                    Payment
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-users"></i>
                    Customers
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-envelope"></i>
                    Message
                    <span class="badge bg-primary rounded-pill">8</span>
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Tools</div>
                <a href="{{route('product.index')}}" class="nav-link">
                    <i class="fas fa-box"></i>
                    Product
                </a>
                <a href="{{route('product_detail.index')}}" class="nav-link">
                    <i class="fas fa-box"></i>
                    Product_Detail
                </a>
                <a href="{{route('purchases.index')}}" class="nav-link">
                    <i class="fas fa-box"></i>
                    Purchase
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-file-invoice"></i>
                    Invoice
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    Analytics
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-robot"></i>
                    Automation
                    <span class="badge bg-info rounded-pill">BETA</span>
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Support</div>
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
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