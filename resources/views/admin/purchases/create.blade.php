@extends('admin.layouts.main')

@push('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="pagetitle">
        <h1>Create Purchase</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
                <li class="breadcrumb-item active">Create Purchase</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Purchase</h5>

                        <form action="{{ route('purchases.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="supplier_id" class="form-label">Supplier</label>
                                <div class="d-flex">
                                    <select class="form-control me-2" id="supplier_id" name="supplier_id" required>
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                                        Add Supplier
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="products" class="form-label">Products</label>
                                <div id="products">
                                    <div class="row mb-2 product-row">
                                        <div class="col-md-4">
                                            <label for="product_id" class="form-label">Product</label>
                                            <select class="form-control" name="items[0][product_id]" required>
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" name="items[0][quantity]" placeholder="Quantity" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" class="form-control" name="items[0][price]" placeholder="Price" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove-product">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="addProduct" class="btn btn-primary">Add Another Product</button>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Purchase</button>
                            <a class="btn btn-primary" href="{{ route('purchases.index') }}" role="button">View Purchases</a>
                            <a class="btn btn-primary" href="{{ route('purchase_items.index') }}" role="button">View Purchase Items</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Supplier Modal -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="supplierForm">
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplier_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="supplier_address" name="supplier_address">
                        </div>
                        <div class="mb-3">
                            <label for="supplier_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="supplier_email" name="supplier_email">
                        </div>
                        <div class="mb-3">
                            <label for="supplier_phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="addSupplier">Add</button>
                    </form>
                    <hr>
                    <button type="button" id="loadSuppliers" class="btn btn-info">View Existing Suppliers</button>
                    <div id="existingSuppliers" class="mt-3" style="display:none;">
                        <h5>Existing Suppliers</h5>
                        <ul id="supplierList"></ul>
                        <ul id="supplierPagination" class="pagination"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Supplier Modal -->
    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSupplierForm">
                        <div class="mb-3">
                            <label for="edit_supplier_name" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" id="edit_supplier_name" name="supplier_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_supplier_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="edit_supplier_address" name="supplier_address">
                        </div>
                        <div class="mb-3">
                            <label for="edit_supplier_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_supplier_email" name="supplier_email">
                        </div>
                        <div class="mb-3">
                            <label for="edit_supplier_phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="edit_supplier_phone" name="supplier_phone" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="updateSupplier">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let productIndex = 1;

        // Add new product row
        document.getElementById('addProduct').addEventListener('click', function() {
            const productsDiv = document.getElementById('products');
            const newProductRow = `
                <div class="row mb-2 product-row">
                    <div class="col-md-4">
                        <select class="form-control" name="items[${productIndex}][product_id]" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="items[${productIndex}][quantity]" placeholder="Quantity" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="items[${productIndex}][price]" placeholder="Price" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-product">Remove</button>
                    </div>
                </div>
            `;
            productsDiv.insertAdjacentHTML('beforeend', newProductRow);
            productIndex++;
        });

        // Remove product row
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-product')) {
                e.target.closest('.product-row').remove();
            }
        });

        // Add Supplier Logic
        document.getElementById('addSupplier').addEventListener('click', function() {
            const supplierName = document.getElementById('supplier_name').value;
            const supplierAddress = document.getElementById('supplier_address').value;
            const supplierEmail = document.getElementById('supplier_email').value;
            const supplierPhone = document.getElementById('supplier_phone').value;

            fetch('{{ route("suppliers.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: supplierName,
                    address: supplierAddress,
                    email: supplierEmail,
                    phone: supplierPhone
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supplier added successfully
                    const supplierSelect = document.getElementById('supplier_id');
                    const newOption = document.createElement('option');
                    newOption.value = data.supplier.id;
                    newOption.text = data.supplier.name;
                    supplierSelect.appendChild(newOption);
                    supplierSelect.value = data.supplier.id;

                    // Reset the form and close the modal
                    document.getElementById('supplierForm').reset();
                    $('#addSupplierModal').modal('hide');
                } else if (data.errors) {
                    // Handle validation errors
                    console.error('Validation errors:', data.errors);
                    // Display the validation errors to the user (e.g., using alert or showing them in the form)
                } else {
                    console.error('Failed to add supplier:', data.message);
                }
            })
            .catch(error => console.error('Error adding supplier:', error));
        });

        // Load Existing Suppliers
        document.getElementById('loadSuppliers').addEventListener('click', function() {
            fetchSuppliers(1);  // Load the first page
        });

        function fetchSuppliers(page) {
            fetch(`/suppliers?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    const supplierList = document.getElementById('supplierList');
                    const pagination = document.getElementById('supplierPagination');

                    supplierList.innerHTML = '';
                    pagination.innerHTML = '';

                    data.suppliers.forEach(supplier => {
                        const listItem = document.createElement('li');
                        listItem.innerHTML = `${supplier.name} (${supplier.phone}) 
                            <button class="btn btn-sm btn-danger ms-2 delete-supplier" data-id="${supplier.id}">Delete</button>
                            <button class="btn btn-sm btn-warning ms-2 edit-supplier" data-id="${supplier.id}" data-name="${supplier.name}" data-email="${supplier.email}" data-phone="${supplier.phone}" data-address="${supplier.address}">Edit</button>`;
                        supplierList.appendChild(listItem);
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
                            fetchSuppliers(i);
                        });

                        pageItem.appendChild(pageLink);
                        pagination.appendChild(pageItem);
                    }

                    document.getElementById('existingSuppliers').style.display = 'block';
                })
                .catch(error => console.error('Error fetching suppliers:', error));
        }

        // Edit Supplier Logic
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('edit-supplier')) {
                const id = e.target.getAttribute('data-id');
                const name = e.target.getAttribute('data-name') || '';
                const email = e.target.getAttribute('data-email') || '';
                const phone = e.target.getAttribute('data-phone') || '';
                const address = e.target.getAttribute('data-address') || '';

                document.getElementById('edit_supplier_name').value = name !== 'null' ? name : '';
                document.getElementById('edit_supplier_email').value = email !== 'null' ? email : '';
                document.getElementById('edit_supplier_phone').value = phone !== 'null' ? phone : '';
                document.getElementById('edit_supplier_address').value = address !== 'null' ? address : '';

                updateSupplierButton.setAttribute('data-id', id);
                $('#editSupplierModal').modal('show');
            }
        });

        // Update Supplier Logic
        const updateSupplierButton = document.getElementById('updateSupplier');
        updateSupplierButton.addEventListener('click', function() {
            const supplierId = updateSupplierButton.getAttribute('data-id');
            const supplierName = document.getElementById('edit_supplier_name').value;
            const supplierAddress = document.getElementById('edit_supplier_address').value;
            const supplierEmail = document.getElementById('edit_supplier_email').value;
            const supplierPhone = document.getElementById('edit_supplier_phone').value;

            fetch(`/suppliers/${supplierId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: supplierName,
                    address: supplierAddress,
                    email: supplierEmail,
                    phone: supplierPhone
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const supplierSelect = document.getElementById('supplier_id');
                    const optionToUpdate = supplierSelect.querySelector(`option[value='${supplierId}']`);
                    if (optionToUpdate) {
                        optionToUpdate.textContent = `${data.supplier.name}`;
                    }

                    $('#editSupplierModal').modal('hide');
                } else {
                    console.error('Failed to update supplier:', data.message);
                }
            })
            .catch(error => console.error('Error updating supplier:', error));
        });

        // Reset the modals when hidden
        $('#addSupplierModal').on('hidden.bs.modal', function () {
            document.getElementById('supplierForm').reset();
        });

        $('#editSupplierModal').on('hidden.bs.modal', function () {
            document.getElementById('editSupplierForm').reset();
            updateSupplierButton.removeAttribute('data-id');
        });

    });
</script>
@endpush
