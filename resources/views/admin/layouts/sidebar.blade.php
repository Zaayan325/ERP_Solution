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
  </li><!-- End Products Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>Warehouse</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      
      <li>
        <a href="{{ route('warehouse_stock.index') }}">
          <i class="bi bi-circle"></i><span>View Warehouse Stock</span>
        </a>
      </li>
      <li>
        <a href="{{ route('warehouse_stock.create') }}">
          <i class="bi bi-circle"></i><span>Add Warehouse Stock</span>
        </a>
      </li>
      <li>
        <a href="{{ route('warehouse_stock_out.create') }}">
          <i class="bi bi-circle"></i><span>Stock Out</span>
        </a>
      </li>
      <li>
        <a href="{{ route('warehouse_stock.adjustments') }}">
          <i class="bi bi-circle"></i><span>View Stock Adjustments</span>
        </a>
      </li>
      <li>
        <a href="{{ route('warehouse_stock.current_stock') }}">
          <i class="bi bi-circle"></i><span>View Current Stock</span>
        </a>
      </li>
    </ul>
  </li><!-- End Warehouse Nav -->

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
  </li><!-- End Suppliers Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#icons-customers-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-people"></i><span>Customers</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="icons-customers-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="{{ route('customers.index') }}">
          <i class="bi bi-circle"></i><span>View Customers</span>
        </a>
      </li>
      <li>
        <a href="{{ route('customers.create') }}">
          <i class="bi bi-circle"></i><span>Add Customers</span>
        </a>
      </li>
    </ul>
  </li><!-- End Customers Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#icons-inventory-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-box-seam"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="icons-inventory-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
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
  </li><!-- End Inventory Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#icons-sales-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-cash"></i><span>Sales</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="icons-sales-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
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
      <li>
        <a href="{{ route('sales_returns.index') }}">
          <i class="bi bi-circle"></i><span>View Sale Returns</span>
        </a>
      </li>
    </ul>
  </li><!-- End Sales Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#icons-purchases-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-bag"></i><span>Purchases</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="icons-purchases-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
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
      <li>
        <a href="{{ route('purchase_items.index') }}">
          <i class="bi bi-circle"></i><span>View Purchase Items</span>
        </a>
      </li>
      <li>
        <a href="{{ route('purchase_returns.index') }}">
          <i class="bi bi-circle"></i><span>View Purchase Returns</span>
        </a>
      </li>
    </ul>
  </li><!-- End Purchases Nav -->

  <li class="nav-heading">Reports</li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('reports.index') }}">
      <i class="bi bi-file-earmark-text"></i>
      <span>Reports</span>
    </a>
  </li><!-- End Reports Nav -->

  <li class="nav-heading">Pages</li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="">
      <i class="bi bi-person"></i>
      <span>Profile</span>
    </a>
  </li><!-- End Profile Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="">
      <i class="bi bi-question-circle"></i>
      <span>F.A.Q</span>
    </a>
  </li><!-- End F.A.Q Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="">
      <i class="bi bi-envelope"></i>
      <span>Contact</span>
    </a>
  </li><!-- End Contact Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="">
      <i class="bi bi-card-list"></i>
      <span>Register</span>
    </a>
  </li><!-- End Register Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="">
      <i class="bi bi-box-arrow-in-right"></i>
      <span>Login</span>
    </a>
  </li><!-- End Login Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="">
      <i class="bi bi-dash-circle"></i>
      <span>Error 404</span>
    </a>
  </li><!-- End Error 404 Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="">
      <i class="bi bi-file-earmark"></i>
      <span>Blank</span>
    </a>
  </li><!-- End Blank Page Nav -->

</ul>

</aside><!-- End Sidebar -->
