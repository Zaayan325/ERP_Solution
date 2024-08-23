@extends('admin.layouts.main')
@push('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush    
@section('content')
    <div class="pagetitle">
        <h1>Add Stock</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('warehouse_stock.index') }}">Warehouse Stocks</a></li>
                <li class="breadcrumb-item active">Add Stock</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Stock</h5>
                        <a href="{{ route('warehouse_stock.adjustments.create') }}" class="btn btn-primary mb-3">Add Stock Adjustment</a>

                        <form action="{{ route('warehouse_stock.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="warehouse_id" class="form-label">Warehouse</label>
                                <div class="d-flex">
                                    <select class="form-control me-2" id="warehouse_id" name="warehouse_id" required>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }} ({{ $warehouse->location }})</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWarehouseModal">
                                        Add Warehouse
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->model_no }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="batch_number" class="form-label">Batch Number</label>
                                <input type="text" class="form-control" id="batch_number" name="batch_number">
                            </div>
                            <div class="mb-3">
                                <label for="expiry_date" class="form-label">Expiry Date</label>
                                <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Warehouse Modal -->
    <div class="modal fade" id="addWarehouseModal" tabindex="-1" aria-labelledby="addWarehouseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWarehouseModalLabel">Add Warehouse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="warehouseForm">
                        <div class="mb-3">
                            <label for="warehouse_name" class="form-label">Warehouse Name</label>
                            <input type="text" class="form-control" id="warehouse_name" name="warehouse_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="warehouse_location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="warehouse_location" name="warehouse_location" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="addWarehouse">Add</button>
                    </form>
                    <hr>    
                    <button type="button" id="loadWarehouses" class="btn btn-info">View Existing Warehouses</button>
                    <div id="existingWarehouses" class="mt-3" style="display:none;">
                        <h5>Existing Warehouses</h5>
                        <div id="warehousePagination"></div>
                        <ul id="warehouseList"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Warehouse Modal -->
<div class="modal fade" id="editWarehouseModal" tabindex="-1" aria-labelledby="editWarehouseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWarehouseModalLabel">Edit Warehouse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editWarehouseForm">
                    <div class="mb-3">
                        <label for="edit_warehouse_name" class="form-label">Warehouse Name</label>
                        <input type="text" class="form-control" id="edit_warehouse_name" name="warehouse_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_warehouse_location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="edit_warehouse_location" name="warehouse_location" required>
                    </div>
                    <button type="button" class="btn btn-primary" id="updateWarehouse">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addWarehouseButton = document.getElementById('addWarehouse');
    const updateWarehouseButton = document.getElementById('updateWarehouse');


    if (!addWarehouseButton || !updateWarehouseButton) {
        console.error('Add Warehouse button not found');
        return;
    }

    // Event listener for the Add/Edit Warehouse button
    addWarehouseButton.addEventListener('click', function(e) {
        console.log('Button Clicked:', e.target);  // Log the button element itself

        // Check if e.target is the button and if it has the data-id attribute
        if (!e.target || !e.target.hasAttribute('data-id')) {
            console.log('No data-id attribute found on target:', e.target);
        }

        const warehouseId = e.target.getAttribute('data-id');
        console.log('Warehouse ID:', warehouseId);  // Debugging output

        const warehouseName = document.getElementById('warehouse_name').value;
        const warehouseLocation = document.getElementById('warehouse_location').value;

        if (!warehouseName || !warehouseLocation) {
            console.error('Required input fields are missing.');
            return;
        }

        let url, method;

        if (warehouseId) {
            console.log('Editing warehouse with ID:', warehouseId);
            url = `/warehouses/${warehouseId}`;
            method = 'PUT';
        } else {
            console.log('Adding a new warehouse...');
            url = '{{ route("warehouses.store") }}';
            method = 'POST';
        }

        fetch(url, {
    method: method,
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
        name: warehouseName,
        location: warehouseLocation
    })
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        const warehouseSelect = document.getElementById('warehouse_id');
        
        if (warehouseId !== null) { // Ensure warehouseId is not null
            const optionToUpdate = warehouseSelect.querySelector(`option[value='${warehouseId}']`);
            if (optionToUpdate) {
                optionToUpdate.textContent = `${data.warehouse.name} (${data.warehouse.location})`;
            }
        } else {
            // Add the new warehouse to the dropdown if creating
            const newOption = document.createElement('option');
            newOption.value = data.warehouse.id;
            newOption.text = `${data.warehouse.name} (${data.warehouse.location})`;
            warehouseSelect.appendChild(newOption);
        }

        // Reset form fields and remove the data-id attribute
        document.getElementById('warehouse_name').value = '';
        document.getElementById('warehouse_location').value = '';
        addWarehouseButton.removeAttribute('data-id');
        $('#addWarehouseModal').modal('hide');
    } else {
        console.error('Failed to save warehouse:', data.message);
    }
})
.catch(error => console.error('Error saving warehouse:', error));
  });

    // Load existing warehouses with pagination
    document.getElementById('loadWarehouses').addEventListener('click', function() {
        fetchWarehouses(1);  // Load the first page
    });

    function fetchWarehouses(page) {
        fetch(`/warehouses?page=${page}`)
            .then(response => response.json())
            .then(data => {
                const warehouseList = document.getElementById('warehouseList');
                const pagination = document.getElementById('warehousePagination');

                warehouseList.innerHTML = '';
                pagination.innerHTML = '';

                data.warehouses.forEach(warehouse => {
                    const listItem = document.createElement('li');
                    listItem.innerHTML = `${warehouse.name} (${warehouse.location}) 
                        <button class="btn btn-sm btn-danger ms-2 delete-warehouse" data-id="${warehouse.id}">Delete</button>
                        <button class="btn btn-sm btn-warning ms-2 edit-warehouse" data-id="${warehouse.id}" data-name="${warehouse.name}" data-location="${warehouse.location}">Edit</button>`;
                    warehouseList.appendChild(listItem);
                });

                // Pagination controls
                for (let i = 1; i <= data.pagination.last_page; i++) {
                    const pageItem = document.createElement('li');
                    pageItem.classList.add('page-item');
                    if (i === data.pagination.current_page) {
                        pageItem.classList.add('active');
                    }

                    const pageLink = document.createElement('a');
                    pageLink.classList.add('page-link');
                    pageLink.href = '#';
                    pageLink.textContent = i;

                    pageLink.addEventListener('click', (e) => {
                        e.preventDefault();
                        fetchWarehouses(i);
                    });

                    pageItem.appendChild(pageLink);
                    pagination.appendChild(pageItem);
                }

                document.getElementById('existingWarehouses').style.display = 'block';
            })
            .catch(error => console.error('Error fetching warehouses:', error));
    }

    // Event delegation for delete and edit actions
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-warehouse')) {
            const id = e.target.getAttribute('data-id');
            fetch(`/warehouses/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    e.target.parentElement.remove();
                    const warehouseSelect = document.getElementById('warehouse_id');
                    const optionToRemove = warehouseSelect.querySelector(`option[value='${id}']`);
                    if (optionToRemove) optionToRemove.remove();
                }
            })
            .catch(error => console.error('Error deleting warehouse:', error));
        }
// Edit Warehouse Logic
document.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-warehouse')) {
            const id = e.target.getAttribute('data-id');
            const name = e.target.getAttribute('data-name');
            const location = e.target.getAttribute('data-location');

            document.getElementById('edit_warehouse_name').value = name;
            document.getElementById('edit_warehouse_location').value = location;

            updateWarehouseButton.setAttribute('data-id', id);
            $('#editWarehouseModal').modal('show');
        }
    });


    if (updateWarehouseButton) {
        updateWarehouseButton.addEventListener('click', function() {
            const warehouseId = updateWarehouseButton.getAttribute('data-id');
            const warehouseName = document.getElementById('edit_warehouse_name').value;
            const warehouseLocation = document.getElementById('edit_warehouse_location').value;

            if (!warehouseName || !warehouseLocation) {
                console.error('Required input fields are missing.');
                return;
            }

            fetch(`/warehouses/${warehouseId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: warehouseName,
                    location: warehouseLocation
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const warehouseSelect = document.getElementById('warehouse_id');
                    const optionToUpdate = warehouseSelect.querySelector(`option[value='${warehouseId}']`);
                    if (optionToUpdate) {
                        optionToUpdate.textContent = `${data.warehouse.name} (${data.warehouse.location})`;
                    }

                    document.getElementById('edit_warehouse_name').value = '';
                    document.getElementById('edit_warehouse_location').value = '';
                    updateWarehouseButton.removeAttribute('data-id');
                    $('#editWarehouseModal').modal('hide');
                } else {
                    console.error('Failed to update warehouse:', data.message);
                }
            })
            .catch(error => console.error('Error updating warehouse:', error));
        });
    }

    // Reset the modals when hidden
    $('#addWarehouseModal').on('hidden.bs.modal', function () {
        document.getElementById('add_warehouse_name').value = '';
        document.getElementById('add_warehouse_location').value = '';
    });

    $('#editWarehouseModal').on('hidden.bs.modal', function () {
        document.getElementById('edit_warehouse_name').value = '';
        document.getElementById('edit_warehouse_location').value = '';
        updateWarehouseButton.removeAttribute('data-id');
    });
});
})
</script>
@endpush
