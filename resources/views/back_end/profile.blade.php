@extends('back_end.components.master')

@section('contents')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm rounded">
                <div class="card-body text-center">
                    <!-- Sidebar/Profile Summary Placeholder -->

                    <div class="d-inline-block p-1 mb-3 rounded-circle"
                        style="background: linear-gradient(135deg, #0d6efd, #6610f2);">
                        @if (Auth::user()->image != null)
                            <img src="{{ asset('uploads/user/' . Auth::user()->image) }}" alt="Profile Image"
                                class="rounded-circle shadow border border-white border-2" width="180" height="180">
                        @else
                            <img src="https://placehold.co/150x150/e5e7eb/4b5563?text=JR" alt="Default Profile Image"
                                class="rounded-circle shadow border border-white border-2" width="180" height="180">
                        @endif
                    </div>
                    <div class="d-none d-lg-block navbar-user-info p-0">
                        <span class="d-block fw-bold text-dark "
                            style="font-size:30px">{{ Auth::check() ? Auth::user()->name : 'KOK' }}</span>
                        <span class="d-block text-secondary small"
                            style="font-size:20px">{{ Auth::check() ? Auth::user()->email : 'KOK' }}</span>
                    </div>
                    <hr>
                    <div class="social-icons">
                        <a href="#"><i class="icon-contacts text-secondary  fab fa-twitter"></i></a>
                        <a href="#"><i class="icon-contacts text-secondary  fab fa-facebook-f"></i></a>
                        <a href="#"><i class="icon-contacts text-secondary  fab fa-instagram"></i></a>
                        <a href="#"><i class="icon-contacts text-secondary  fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center px-3 py-2"
                            role="alert">
                            <strong>{{ Session::get('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @php
                        $activeTab = 'overview';
                        if (Session::has('password')) {
                            $activeTab = 'change-password';
                        } elseif (Session::has('profile')) {
                            $activeTab = 'overview';
                        }
                    @endphp

                    <ul class="nav nav-tabs mb-3" id="profileTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link {{ $activeTab == 'overview' ? 'active' : '' }}" id="overview-tab"
                                data-bs-toggle="tab" data-bs-target="#overview" type="button"
                                role="tab">Overview</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link {{ $activeTab == 'edit-profile' ? 'active' : '' }}"
                                id="edit-profile-tab" data-bs-toggle="tab" data-bs-target="#edit-profile" type="button"
                                role="tab">Edit Profile</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link {{ $activeTab == 'saling' ? 'active' : '' }}" id="saling-tab"
                                data-bs-toggle="tab" data-bs-target="#saling" type="button" role="tab">Saling</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link {{ $activeTab == 'change-password' ? 'active' : '' }}"
                                id="change-password-tab" data-bs-toggle="tab" data-bs-target="#change-password"
                                type="button" role="tab">Change Password</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="profileTabsContent">
                        <!-- Overview -->
                        <div class="tab-pane fade {{ $activeTab == 'overview' ? 'show active' : '' }}" id="overview"
                            role="tabpanel">
                            <div class="container mt-5">
                                <!-- About Section -->
                                <h5 class="text-primary fw-bold">About</h5>
                                <p class="text-secondary">
                                    Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus.
                                    Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae
                                    quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea sequi et unde.
                                </p>

                                <!-- Profile Details -->
                                <h5 class="text-primary fw-bold mt-4">Profile Details</h5>
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-semibold text-secondary">Full Name</div>
                                    <div class="col-md-9">{{ Auth::check() ? Auth::user()->name : 'KOK' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-semibold text-secondary">Company</div>
                                    <div class="col-md-9">Lueilwitz, Wisoky and Leuschke</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-semibold text-secondary">Job</div>
                                    <div class="col-md-9">Web Designer</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-semibold text-secondary">Country</div>
                                    <div class="col-md-9">USA</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-semibold text-secondary">Address</div>
                                    <div class="col-md-9">A108 Adam Street, New York, NY 535022</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-semibold text-secondary">Phone</div>
                                    <div class="col-md-9">(436) 486-3538 x29071</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-semibold text-secondary">Email</div>
                                    <div class="col-md-9">{{ Auth::check() ? Auth::user()->email : 'KOK' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Profile -->
                        <div class="tab-pane fade {{ $activeTab == 'edit-profile' ? 'show active' : '' }}"
                            id="edit-profile" role="tabpanel">
                            <form method="POST" action="{{ route('profile.update') }}" class="p-3 formUpdateProfile"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="image_name" id="image_name">
                                <div class="show-profile mb-3 text-center">
                                    <div class="position-relative d-inline-block">
                                        <div class="d-inline-block p-1 rounded-circle"
                                            style="background: linear-gradient(135deg, #0d6efd, #6610f2);">
                                            @if (Auth::user()->image != null)
                                                <img class="img-md rounded-circle"
                                                    src="{{ asset('uploads/user/' . $user->image) }}" alt="Profile image"
                                                    width="150" height="150">
                                            @else
                                                <img src="https://placehold.co/150x150/e5e7eb/4b5563?text=JR"
                                                    alt="Default Profile Image"
                                                    class="rounded-circle shadow border border-white border-2"
                                                    width="150" height="150">
                                            @endif
                                        </div>

                                        {{-- Optional hover overlay for styling --}}
                                        <div class="position-absolute bottom-0  end-0 translate-middle-x bg-white  rounded-circle shadow-sm border border-secondary border-3"
                                            style="padding:0px 5px ">
                                            <label for="image" class="mb-0" data-bs-toggle="tooltip"
                                                title="Edit Image">
                                                <i class="bi bi-pen fs-5 text-primary" style="cursor: pointer;"></i>
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Action buttons --}}
                                    <div class="d-flex justify-content-center mt-3 gap-2">
                                        <button onclick="changeImageProfile('.formUpdateProfile')" type="button"
                                            class=" btn btn-info btn-sm"><i class="bi bi-upload"></i></button>
                                        <button type="button" class=" btn btn-danger btn-sm"><i
                                                class="bi bi-trash3"></i></button>
                                        <input type="file" name="image" id="image" class="d-none">
                                    </div>


                                </div>


                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ Auth::user()->name != null ? Auth::user()->name : '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ Auth::user()->email != null ? Auth::user()->email : '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control"
                                        value="{{ $address != null ? $address->address : '' }}" name="address"
                                        id="address">
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', $contacts['phone'] ?? '') }}" placeholder="Phone">
                                </div>

                                <div class="mb-3">
                                    <label for="facebook" class="form-label">Facebook URL</label>
                                    <input type="text" class="form-control" id="facebook" name="facebook"
                                        value="{{ old('facebook', $contacts['facebook'] ?? '') }}"
                                        placeholder="Facebook URL">
                                </div>

                                <div class="mb-3">
                                    <label for="telegram" class="form-label">Telegram URL</label>
                                    <input type="text" class="form-control" id="telegram" name="telegram"
                                        value="{{ old('telegram', $contacts['telegram'] ?? '') }}"
                                        placeholder="Telegram URL">
                                </div>


                                <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                            </form>
                        </div>

                        <!-- Saling -->
                        <div class="tab-pane fade {{ $activeTab == 'saling' ? 'show active' : '' }}" id="saling"
                            role="tabpanel">...</div>

                        <!-- Change Password -->
                        <div class="tab-pane fade {{ $activeTab == 'change-password' ? 'show active' : '' }}"
                            id="change-password" role="tabpanel">
                            <form action="{{ route('profile.change.password') }}" class="p-3" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="current_pass" class="form-label">Current Password</label>
                                    <input type="password"
                                        class="form-control @error('current_pass') is-invalid @enderror" id="current_pass"
                                        name="current_pass">
                                    @error('current_pass')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="new_pass" class="form-label">New Password</label>
                                    <input type="password" class="form-control @error('new_pass') is-invalid @enderror"
                                        id="new_pass" name="new_pass">
                                    @error('new_pass')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="c_password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control @error('c_password') is-invalid @enderror"
                                        id="c_password" name="c_password">
                                    @error('c_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const changeImageProfile = (form) => {
            let payloads = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('profile.change.image') }}",
                data: payloads,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 200) {
                        $(".show-profile img").attr('src', `/uploads/temp/${response.image}`);
                        $("#image_name").val(response.image);
                        $("#image").val('');
                        Message(response.message);
                    } else {
                        Message(response.message, false);
                    }
                }
            });
        };
    </script>


    <script>
        // Enable tooltips globally
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endsection
