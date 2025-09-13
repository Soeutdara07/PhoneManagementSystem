<div class="top-bar">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="h4 mb-0 d-none d-sm-block">Dashboard</h1>
        </div>


        <!-- Search and User Profile -->
        <div class="d-flex align-items-center ms-auto">
            <!-- Button trigger modal -->
            <a href="#" class="btn-light rounded-circle  p-2 me-3 text-decoration-none  d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalSearch">
                <i class="fa-solid fa-magnifying-glass text-secondary fs-4"></i>
            </a> 


            <!-- Search and Notification Icons (Mobile & Desktop) -->

            <a href="#" class="btn btn-light rounded-circle  p-2 me-3 position-relative"
                aria-label="Notifications">
                <i class="fa-regular fa-bell fs-5 px-1"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
            </a>

            <!-- User Info Section with Dropdown -->
            <div class="dropdown">
                <a href="#" class="text-decoration-none dropdown-toggle d-flex align-items-center"
                    id="profile-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (Auth::user()->image != null)
                        <img class="img-xs rounded-circle border border-primary"
                            src="{{ asset('uploads/user/' . Auth::user()->image) }}" alt="Profile image" width="40"
                            height="40">
                    @else
                        <img class="rounded-circle me-md-2" src="https://placehold.co/40x40/e5e7eb/4b5563?text=JR"
                            alt="User Profile Picture" width="40" height="40">
                    @endif

                    {{-- <div class="d-none d-lg-block navbar-user-info p-0">
                                            <span class="d-block fw-bold text-dark">{{ (Auth::check()) ? Auth::user()->name : "KOK" }}</span>
                                            <span class="d-block text-secondary small">{{ (Auth::check()) ? Auth::user()->email : "KOK" }}</span>
                                        </div> --}}
                </a>

                <ul class="dropdown-menu dropdown-menu-end profile-dropdown-menu mt-3">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.index') }}">
                            <i class="fa-regular fa-user pe-4"></i>
                            My profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center dropdown-item-share" href="#">
                            <i class="fa-regular fa-share-from-square pe-4"></i>
                            Share & Grow
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="fa-solid fa-briefcase pe-4"></i>
                            How it works
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="fa-solid fa-gear pe-4"></i>
                            Account settings
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center logout" href="{{ route('auth.logout') }}">
                            <i class="fa-solid fa-arrow-right-from-bracket pe-4"></i>
                            Log out
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>

<!-- Modal Serch -->
<div class="modal fade" id="modalSearch" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
            <div class="modal-body ">
                 <div class="search-wrapper-light">
                <input type="text" name="search" placeholder="Search..." class="search-input-light" id="searchBox">
                <button type="submit" class="search-button-light searchBtn" id="searchBtn">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div> --}}
        </div>
    </div>
</div>
