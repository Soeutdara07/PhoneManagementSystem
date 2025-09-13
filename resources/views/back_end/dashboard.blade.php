@extends('back_end.components.master')

@section('contents')
    <div class="content-area">
            <!-- Stats Cards Row -->
            <div class="row mb-4">
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="stats-card-header">
                            <div class="stats-card-left">
                                <div class="stats-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="fas fa-chart-line text-white"></i>
                                </div>
                                <div>
                                    <h6 class="stats-card-title">Page Views</h6>
                                </div>
                            </div>
                            <i class="fas fa-info-circle text-muted"></i>
                        </div>
                        <div class="stats-card-value">12,450</div>
                        <div class="stats-card-change change-positive">
                            <i class="fas fa-trending-up me-1"></i> 15.8%
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="stats-card-header">
                            <div class="stats-card-left">
                                <div class="stats-card-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <i class="fas fa-dollar-sign text-white"></i>
                                </div>
                                <div>
                                    <h6 class="stats-card-title">Total Revenue</h6>
                                </div>
                            </div>
                            <i class="fas fa-info-circle text-muted"></i>
                        </div>
                        <div class="stats-card-value">$363.95</div>
                        <div class="stats-card-change change-negative">
                            <i class="fas fa-trending-down me-1"></i> 34.0%
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="stats-card-header">
                            <div class="stats-card-left">
                                <div class="stats-card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                    <i class="fas fa-mouse-pointer text-white"></i>
                                </div>
                                <div>
                                    <h6 class="stats-card-title">Bounce Rate</h6>
                                </div>
                            </div>
                            <i class="fas fa-info-circle text-muted"></i>
                        </div>
                        <div class="stats-card-value">86.5%</div>
                        <div class="stats-card-change change-positive">
                            <i class="fas fa-trending-up me-1"></i> 24.2%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mb-4">
                <div class="col-lg-8 mb-4">
                    <div class="chart-container">
                        <div class="chart-header">
                            <div>
                                <h5 class="chart-title">Sales Overview</h5>
                                <p class="text-muted mb-0">$9,257.51 
                                    <span class="text-success">15.8% <i class="fas fa-arrow-up"></i></span>
                                    +$143.50 Increased
                                </p>
                            </div>
                            <div class="chart-controls">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-sort-amount-down me-1"></i> Sort
                                </button>
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </div>
                        <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px;">
                            <span class="text-muted">Sales Chart Placeholder</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="chart-container">
                        <div class="chart-header">
                            <div>
                                <h5 class="chart-title">
                                    <i class="fas fa-users me-2 text-primary"></i>
                                    Total Subscriber
                                </h5>
                                <select class="form-select form-select-sm mt-2" style="width: auto;">
                                    <option>Weekly</option>
                                    <option>Monthly</option>
                                    <option>Yearly</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-center">
                            <h2 class="fw-bold">24,473</h2>
                            <p class="text-success">
                                <i class="fas fa-arrow-trend-up me-1"></i>
                                5.3% +749 increased
                            </p>
                        </div>
                        <div style="height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px;">
                            <span class="text-muted">Subscriber Chart Placeholder</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Row -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="chart-container">
                        <div class="chart-header">
                            <h5 class="chart-title">
                                <i class="fas fa-chart-pie me-2 text-primary"></i>
                                Sales Distribution
                            </h5>
                            <select class="form-select form-select-sm" style="width: auto;">
                                <option>Monthly</option>
                                <option>Weekly</option>
                                <option>Yearly</option>
                            </select>
                        </div>
                        
                        <div class="row text-center mb-4">
                            <div class="col-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class="fas fa-globe me-2 text-primary"></i>
                                    <h6 class="text-muted mb-0">Website</h6>
                                </div>
                                <h5 class="fw-bold">$374.82</h5>
                            </div>
                            <div class="col-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class="fas fa-mobile-alt me-2 text-success"></i>
                                    <h6 class="text-muted mb-0">Mobile App</h6>
                                </div>
                                <h5 class="fw-bold">$241.60</h5>
                            </div>
                            <div class="col-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class="fas fa-ellipsis-h me-2 text-info"></i>
                                    <h6 class="text-muted mb-0">Other</h6>
                                </div>
                                <h5 class="fw-bold">$213.42</h5>
                            </div>
                        </div>
                        
                        <div class="donut-chart">
                            <div style="height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 50%;">
                                <span class="text-muted">Distribution Chart</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="chart-container">
                        <div class="chart-header">
                            <h5 class="chart-title">
                                <i class="fas fa-plug me-2 text-primary"></i>
                                List of Integration
                            </h5>
                            <a href="#" class="text-primary">
                                <i class="fas fa-external-link-alt me-1"></i>
                                See All
                            </a>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="text-muted">
                                        <th>
                                            <i class="fas fa-cube me-1"></i>
                                            APPLICATION
                                        </th>
                                        <th>
                                            <i class="fas fa-tag me-1"></i>
                                            TYPE
                                        </th>
                                        <th>
                                            <i class="fas fa-percentage me-1"></i>
                                            RATE
                                        </th>
                                        <th>
                                            <i class="fas fa-dollar-sign me-1"></i>
                                            PROFIT
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="integration-icon" style="background: linear-gradient(135deg, #635bff 0%, #4f46e5 100%);">
                                                    <i class="fab fa-stripe text-white"></i>
                                                </div>
                                                <span class="fw-semibold">Stripe</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-university me-1"></i>
                                                Finance
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress progress-custom me-2" style="width: 60px;">
                                                    <div class="progress-bar bg-primary" style="width: 40%"></div>
                                                </div>
                                                <span class="fw-semibold">40%</span>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-success">
                                            <i class="fas fa-arrow-up me-1"></i>
                                            $650.00
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="integration-icon" style="background: linear-gradient(135deg, #ff6154 0%, #ff4757 100%);">
                                                    <i class="fas fa-bolt text-white"></i>
                                                </div>
                                                <span class="fw-semibold">Zapier</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-users-cog me-1"></i>
                                                CRM
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress progress-custom me-2" style="width: 60px;">
                                                    <div class="progress-bar bg-success" style="width: 80%"></div>
                                                </div>
                                                <span class="fw-semibold">80%</span>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-success">
                                            <i class="fas fa-arrow-up me-1"></i>
                                            $720.60
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="integration-icon" style="background: linear-gradient(135deg, #95bf47 0%, #7fb069 100%);">
                                                    <i class="fab fa-shopify text-white"></i>
                                                </div>
                                                <span class="fw-semibold">Shopify</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-store me-1"></i>
                                                Marketplace
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress progress-custom me-2" style="width: 60px;">
                                                    <div class="progress-bar bg-warning" style="width: 20%"></div>
                                                </div>
                                                <span class="fw-semibold">20%</span>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-success">
                                            <i class="fas fa-arrow-up me-1"></i>
                                            $432.25
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection