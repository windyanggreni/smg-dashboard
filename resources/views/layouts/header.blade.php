<!-- Main Header -->
<div class="main-header">
    <!-- Logo Header -->
    <div class="main-header-logo">
        <div class="logo-header" data-background-color="dark">
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
        </div>
    </div>

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <div class="header-datetime-badge">
                <i class="fas fa-clock"></i>
                <span id="currentDateTime"></span>
            </div>

            <!-- Topbar icons and dropdowns -->
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                        aria-expanded="false">
                        <div class="avatar-sm">
                            @if (Auth::user()->photo && file_exists(storage_path('app/public/' . Auth::user()->photo)))
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="..."
                                    class="avatar-img rounded-circle" />
                            @else
                                <i class="fas fa-user-circle fa-2x text-secondary ml-5 mt-2"></i>
                            @endif
                        </div>
                        <span class="profile-username">
                            <span class="op-7">Hi,</span>
                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box text-center">
                                    <div class="avatar-lg mb-2">
                                        @if (Auth::user()->photo && file_exists(storage_path('app/public/' . Auth::user()->photo)))
                                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="image profile"
                                                class="avatar-img rounded" />
                                        @else
                                            <i class="fas fa-user-circle fa-3x text-secondary"></i>
                                        @endif
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ Auth::user()->name }}</h4>
                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                        <a href="{{ route('users.show', Auth::user()->id) }}"
                                            class="btn btn-xs btn-secondary btn-sm">
                                            View Profile
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-primary fw-bold" href="{{ route('users.edit', Auth::user()->id) }}">
                                    Edit Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>

        </div>
    </nav>
</div>
<!-- End Main Header -->

<script>
    function updateDateTime() {
        const now = new Date();
        // Format tanggal: hari, tanggal bulan tahun jam:menit:detik
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const dateStr = now.toLocaleDateString('id-ID', options);
        const timeStr = now.toLocaleTimeString('id-ID');
        document.getElementById('currentDateTime').textContent = `${dateStr} - ${timeStr}`;
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>
