<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-heading">Master Data</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('categories.index') }}">
        <i class="bi bi-tags"></i>
        <span>Categories</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('services.index') }}">
        <i class="bi bi-briefcase"></i>
        <span>Services</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('clients.index') }}">
        <i class="bi bi-people"></i>
        <span>Clients</span>
      </a>
    </li>

    <li class="nav-heading">Content</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('posts.index') }}">
        <i class="bi bi-journal-text"></i>
        <span>Posts</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('portfolio.index') }}">
        <i class="bi bi-collection"></i>
        <span>Portfolio</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('testimonials.index') }}">
        <i class="bi bi-chat-quote"></i>
        <span>Testimonials</span>
      </a>
    </li>

    <li class="nav-heading">Sales</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('orders.index') }}">
        <i class="bi bi-receipt"></i>
        <span>Orders</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('invoices.index') }}">
        <i class="bi bi-file-earmark-text"></i>
        <span>Invoices</span>
      </a>
    </li>

    <li class="nav-heading">Administration</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('users.index') }}">
        <i class="bi bi-person-gear"></i>
        <span>Users</span>
      </a>
    </li>
  </ul>
</aside>
<!-- End Sidebar -->