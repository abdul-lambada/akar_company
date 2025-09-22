<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'collapsed' }}"
                href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-heading">Master Data</li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : 'collapsed' }}"
                href="{{ route('categories.index') }}">
                <i class="bi bi-tags"></i>
                <span>Categories</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : 'collapsed' }}"
                href="{{ route('services.index') }}">
                <i class="bi bi-briefcase"></i>
                <span>Services</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : 'collapsed' }}"
                href="{{ route('clients.index') }}">
                <i class="bi bi-people"></i>
                <span>Clients</span>
            </a>
        </li>

        <li class="nav-heading">Content</li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('posts.*') ? 'active' : 'collapsed' }}"
                href="{{ route('posts.index') }}">
                <i class="bi bi-journal-text"></i>
                <span>Posts</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('portfolio.*') ? 'active' : 'collapsed' }}"
                href="{{ route('portfolio.index') }}">
                <i class="bi bi-collection"></i>
                <span>Portfolio</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('testimonials.*') ? 'active' : 'collapsed' }}"
                href="{{ route('testimonials.index') }}">
                <i class="bi bi-chat-quote"></i>
                <span>Testimonials</span>
            </a>
        </li>

        <li class="nav-heading">Sales</li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : 'collapsed' }}"
                href="{{ route('orders.index') }}">
                <i class="bi bi-receipt"></i>
                <span>Orders</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : 'collapsed' }}"
                href="{{ route('invoices.index') }}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Invoices</span>
            </a>
        </li>

        <li class="nav-heading">Administration</li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : 'collapsed' }}"
                href="{{ route('users.index') }}">
                <i class="bi bi-person-gear"></i>
                <span>Users</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : 'collapsed' }}"
                href="{{ route('settings.index') }}">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : 'collapsed' }}"
                href="{{ route('profile.index') }}">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </a>
        </li>
    </ul>
</aside>
<!-- End Sidebar -->
