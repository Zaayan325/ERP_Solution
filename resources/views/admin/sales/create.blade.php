@extends('admin.layouts.main')
@push('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    <div class="pagetitle">
        <h1>Create Sale</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                <li class="breadcrumb-item active">Create Sale</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">New Sale</h5>

                        <form action="{{ route('sales.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer</label>
                                <div class="d-flex">
                                    <select class="form-control me-2" id="customer_id" name="customer_id">
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                                        Add Customer
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Products</label>
                                <table class="table" id="products-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-body">
                                        <tr>
                                            <td>
                                                <select name="items[0][product_id]" class="form-control" required>
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" name="items[0][quantity]" class="form-control" required></td>
                                            <td><input type="number" name="items[0][price]" class="form-control" required></td>
                                            <td><button type="button" class="btn btn-danger remove-product">Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" id="add-product">Add Product</button>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Sale</button>
                            <a class="btn btn-primary" href="{{ route('sales.index') }}" role="button">View Sales</a>
                            <br><br>
                            <a class="btn btn-primary" href="{{ route('sales_items.index') }}" role="button">View Sales Items</a>
                            <a class="btn btn-primary" href="{{ route('payments.index') }}" role="button">View Payments</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="customerForm">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="customer_address" name="customer_address">
                        </div>
                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="customer_email" name="customer_email">
                        </div>
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone">
                        </div>
                        <button type="button" class="btn btn-primary" id="addCustomer">Add</button>
                    </form>
                    <hr>
                    <button type="button" id="loadCustomers" class="btn btn-info">View Existing Customers</button>
                <div id="existingCustomers" class="mt-3" style="display:none;">
                    <h5>Existing Customers</h5>
                    <ul id="customerList"></ul>
                    <ul id="customerPagination" class="pagination"></ul>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Customer Modal -->
    <div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCustomerForm">
                        <div class="mb-3">
                            <label for="edit_customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="edit_customer_name" name="customer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_customer_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="edit_customer_address" name="customer_address">
                        </div>
                        <div class="mb-3">
                            <label for="edit_customer_email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="edit_customer_email" name="customer_email">
                        </div>
                        <div class="mb-3">
                            <label for="edit_customer_phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="edit_customer_phone" name="customer_phone">
                        </div>
                        <button type="button" class="btn btn-primary" id="updateCustomer">Update</button>
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

    // Add Product Row
    document.getElementById('add-product').addEventListener('click', function() {
        const productsTableBody = document.getElementById('products-body');
        const newRow = `
            <tr>
                <td>
                    <select name="items[${productIndex}][product_id]" class="form-control" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->brand->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="items[${productIndex}][quantity]" class="form-control" required></td>
                <td><input type="number" name="items[${productIndex}][price]" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger remove-product">Remove</button></td>
            </tr>
        `;
        productsTableBody.insertAdjacentHTML('beforeend', newRow);
        productIndex++;
    });

    // Remove Product Row
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-product')) {
            e.target.closest('tr').remove();
        }
    });

    // Add Customer Logic
    const addCustomerButton = document.getElementById('addCustomer');
    const updateCustomerButton = document.getElementById('updateCustomer');

    if (addCustomerButton) {
        addCustomerButton.addEventListener('click', function() {
            const customerName = document.getElementById('customer_name').value;
            const customerAddress = document.getElementById('customer_address').value;
            const customerEmail = document.getElementById('customer_email').value;
            const customerPhone = document.getElementById('customer_phone').value;

            fetch('{{ route("customers.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: customerName,
                    address: customerAddress,
                    email: customerEmail,
                    phone: customerPhone
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const customerSelect = document.getElementById('customer_id');
                    const newOption = document.createElement('option');
                    newOption.value = data.customer.id;
                    newOption.text = data.customer.name;
                    customerSelect.appendChild(newOption);
                    customerSelect.value = data.customer.id;

                    document.getElementById('customerForm').reset();
                    $('#addCustomerModal').modal('hide');
                } else {
                    console.error('Failed to add customer:', data.message);
                }
            })
            .catch(error => console.error('Error adding customer:', error));
        });
    }

    // Load Existing Customers
    document.getElementById('loadCustomers').addEventListener('click', function() {
    fetchCustomers(1); // Load the first page
});

function fetchCustomers(page) {
    fetch(`/customers?page=${page}`)
        .then(response => response.json())
        .then(data => {
            const customerList = document.getElementById('customerList');
            const pagination = document.getElementById('customerPagination');

            // Clear the existing customer list and pagination controls
            customerList.innerHTML = '';
            pagination.innerHTML = '';

            // Iterate over the fetched customers
            data.customers.forEach(customer => {
                // Handle null values, replace them with empty strings
                const phone = customer.phone !== null ? customer.phone : '';
                const email = customer.email !== null ? customer.email : '';

                const listItem = document.createElement('li');
                listItem.innerHTML = `
                    ${customer.name} (${phone}) 
                    <button class="btn btn-sm btn-danger ms-2 delete-customer" data-id="${customer.id}">Delete</button>
                    <button class="btn btn-sm btn-warning ms-2 edit-customer" data-id="${customer.id}" data-name="${customer.name}" data-email="${email}" data-phone="${phone}" data-address="${customer.address}">Edit</button>
                `;
                customerList.appendChild(listItem);
            });

            // Handle pagination controls
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
                    fetchCustomers(i); // Load the specific page when a pagination link is clicked
                });

                pageItem.appendChild(pageLink);
                pagination.appendChild(pageItem);
            }

            // Show the existing customers section
            document.getElementById('existingCustomers').style.display = 'block';
        })
        .catch(error => console.error('Error fetching customers:', error));
}


    // Edit Customer Logic
    document.addEventListener('click', function(e) {
    if (e.target.classList.contains('edit-customer')) {
        const id = e.target.getAttribute('data-id');
        
        // Use a ternary operator to set an empty string if the value is null or undefined
        const name = e.target.getAttribute('data-name') !== 'null' ? e.target.getAttribute('data-name') : '';
        const email = e.target.getAttribute('data-email') !== 'null' ? e.target.getAttribute('data-email') : '';
        const phone = e.target.getAttribute('data-phone') !== 'null' ? e.target.getAttribute('data-phone') : '';
        const address = e.target.getAttribute('data-address') !== 'null' ? e.target.getAttribute('data-address') : '';

        document.getElementById('edit_customer_name').value = name;
        document.getElementById('edit_customer_email').value = email;
        document.getElementById('edit_customer_phone').value = phone;
        document.getElementById('edit_customer_address').value = address;

        // Set the data-id attribute for the update button
        document.getElementById('updateCustomer').setAttribute('data-id', id);
        
        // Show the modal
        $('#editCustomerModal').modal('show');
    }
});


    // Update Customer Logic
    if (updateCustomerButton) {
        updateCustomerButton.addEventListener('click', function() {
            const customerId = updateCustomerButton.getAttribute('data-id');

            if (customerId) {
                const customerName = document.getElementById('edit_customer_name').value;
                const customerAddress = document.getElementById('edit_customer_address').value;
                const customerEmail = document.getElementById('edit_customer_email').value;
                const customerPhone = document.getElementById('edit_customer_phone').value;

                fetch(`/customers/${customerId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: customerName,
                        address: customerAddress,
                        email: customerEmail,
                        phone: customerPhone
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const customerSelect = document.getElementById('customer_id');
                        const optionToUpdate = customerSelect.querySelector(`option[value='${customerId}']`);
                        if (optionToUpdate) {
                            optionToUpdate.textContent = `${data.customer.name}`;
                        }

                        $('#editCustomerModal').modal('hide');
                    } else {
                        console.error('Failed to update customer:', data.message);
                    }
                })
                .catch(error => console.error('Error updating customer:', error));
            } else {
                console.error('Customer ID not found.');
            }
        });
    }

    // Reset the modals when hidden
    $('#addCustomerModal').on('hidden.bs.modal', function () {
        document.getElementById('customerForm').reset();
    });

    $('#editCustomerModal').on('hidden.bs.modal', function () {
        document.getElementById('editCustomerForm').reset();
        if (updateCustomerButton) {
            updateCustomerButton.removeAttribute('data-id');
        }
    });
});
</script>
@endpush
