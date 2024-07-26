<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="{{ route('dashboard') }}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
        <a href="{{ route('uoms.index') }}">
          <i class="bi bi-circle"></i><span>View Units</span>
        </a>
      </li>
    <li>
        <a href="{{ route('brands.index') }}">
          <i class="bi bi-circle"></i><span>View Brands</span>
        </a>
      </li>
      <li>
        <a href="{{ route('product_categories.index') }}">
          <i class="bi bi-circle"></i><span>View Categories</span>
        </a>
      </li>
      <li>
        <a href="{{ route('products.index') }}">
          <i class="bi bi-circle"></i><span>View Products</span>
        </a>
      </li>
      <li>
        <a href="{{ route('products.create') }}">
          <i class="bi bi-circle"></i><span>Add Products</span>
        </a>
      </li>
    </ul>
  </li><!-- End Components Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>Warehouse</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      
      <li>
        <a href="{{ route('warehouses.index') }}">
          <i class="bi bi-circle"></i><span>View Warehouse</span>
        </a>
      </li>
      <li>
        <a href="{{ route('warehouses.create') }}">
          <i class="bi bi-circle"></i><span>Add Warehouse</span>
        </a>
      </li>
      <li>
        <a href="{{ route('warehouse_stock.index') }}">
          <i class="bi bi-circle"></i><span>View Warehouse Stock</span>
        </a>
      </li>
    </ul>
  </li><!-- End Forms Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Stock</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="{{ route('stock_brands.index') }}">
          <i class="bi bi-circle"></i><span>View Stock Brands</span>
        </a>
      </li>
      <li>
        <a href="{{ route('stock_categories.index') }}">
          <i class="bi bi-circle"></i><span>View Stock Categories</span>
        </a>
      </li>
      <li>
        <a href="{{ route('stock_uoms.index') }}">
          <i class="bi bi-circle"></i><span>View Stock Unit</span>
        </a>
      </li>
    </ul>
  </li><!-- End Tables Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-bar-chart"></i><span>Suppliers</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
        <a href="{{ route('suppliers.index') }}">
          <i class="bi bi-circle"></i><span>View Suppliers</span>
        </a>
      </li>
      <li>
        <a href="{{ route('suppliers.create') }}">
          <i class="bi bi-circle"></i><span>Add Suppliers</span>
        </a>
      </li>
      
    </ul>
  </li><!-- End Charts Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-gem"></i><span>Customers</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
        <a href="{{ route('customers.index') }}">
          <i class="bi bi-circle"></i><span>View Customers</span>
        </a>
      </li>
      <li>
        <a href="{{ route('customers.index') }}">
          <i class="bi bi-circle"></i><span>Add Customers</span>
        </a>
      </li>
      
    </ul>
  </li><!-- End Icons Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-gem"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
        <a href="{{ route('inventory.index') }}">
          <i class="bi bi-circle"></i><span>View Inventory</span>
        </a>
      </li>
      <li>
        <a href="{{ route('inventory.create') }}">
          <i class="bi bi-circle"></i><span>Add Inventory</span>
        </a>
      </li>
    </ul>
      <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-gem"></i><span>Sales</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
        <a href="{{ route('sales.index') }}">
          <i class="bi bi-circle"></i><span>View Sales</span>
        </a>
      </li>
      <li>
        <a href="{{ route('sales.create') }}">
          <i class="bi bi-circle"></i><span>Add Sales</span>
        </a>
      </li>

      <li>
        <a href="{{ route('sales_items.index') }}">
          <i class="bi bi-circle"></i><span>View Sales Items</span>
        </a>
      </li>

      <li>
        <a href="{{ route('payments.index') }}">
          <i class="bi bi-circle"></i><span>View Payments</span>
        </a>
      </li>
      
    </ul>
  </li><!-- End Icons Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-gem"></i><span>Purchases</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
        <a href="{{ route('purchases.index') }}">
          <i class="bi bi-circle"></i><span>View Purchases</span>
        </a>
      </li>
      <li>
        <a href="{{ route('purchases.create') }}">
          <i class="bi bi-circle"></i><span>Add Purchase</span>
        </a>
      </li>
      
    </ul>
  </li><!-- End Icons Nav -->

  <li class="nav-heading">Pages</li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="users-profile.html">
      <i class="bi bi-person"></i>
      <span>Profile</span>
    </a>
  </li><!-- End Profile Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-faq.html">
      <i class="bi bi-question-circle"></i>
      <span>F.A.Q</span>
    </a>
  </li><!-- End F.A.Q Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-contact.html">
      <i class="bi bi-envelope"></i>
      <span>Contact</span>
    </a>
  </li><!-- End Contact Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-register.html">
      <i class="bi bi-card-list"></i>
      <span>Register</span>
    </a>
  </li><!-- End Register Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-login.html">
      <i class="bi bi-box-arrow-in-right"></i>
      <span>Login</span>
    </a>
  </li><!-- End Login Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-error-404.html">
      <i class="bi bi-dash-circle"></i>
      <span>Error 404</span>
    </a>
  </li><!-- End Error 404 Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-blank.html">
      <i class="bi bi-file-earmark"></i>
      <span>Blank</span>
    </a>
  </li><!-- End Blank Page Nav -->

</ul>

</aside><!-- End Sidebar-->
