@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Create Product</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item active">Create Product</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Product</h5>

                        <form action="{{ route('products.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <div class="d-flex">
                                    <select class="form-control me-2" id="category_id" name="category_id" required>
                                        @foreach ($productCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                        Add Category
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="brand_id" class="form-label">Brand</label>
                                <div class="d-flex">
                                    <select class="form-control me-2" id="brand_id" name="brand_id" required>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#brandModal">
                                        Add Brand
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="uom_id" class="form-label">Unit of Measurement</label>
                                <div class="d-flex">
                                    <select class="form-control me-2" id="uom_id" name="uom_id" required>
                                        @foreach ($uoms as $uom)
                                            <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uomModal">
                                        Add UOM
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryForm">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="addCategory">Add</button>
                    </form>
                    <hr>
                    <h5>Existing Categories</h5>
                    <ul id="categoryList">
                        @foreach ($productCategories as $category)
                            <li>
                                {{ $category->name }}
                                <button class="btn btn-sm btn-danger ms-2 delete-category" data-id="{{ $category->id }}">Delete</button>
                                <button class="btn btn-sm btn-warning ms-2 edit-category" data-id="{{ $category->id }}" data-name="{{ $category->name }}">Edit</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        <div class="mb-3">
                            <label for="edit_category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="edit_category_name" name="edit_category_name" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="updateCategory">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Brand Modal -->
    <div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="brandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="brandModalLabel">Add Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="brandForm">
                        <div class="mb-3">
                            <label for="brand_name" class="form-label">Brand Name</label>
                            <input type="text" class="form-control" id="brand_name" name="brand_name" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="addBrand">Add</button>
                    </form>
                    <hr>
                    <h5>Existing Brands</h5>
                    <ul id="brandList">
                        @foreach ($brands as $brand)
                            <li>
                                {{ $brand->name }}
                                <button class="btn btn-sm btn-danger ms-2 delete-brand" data-id="{{ $brand->id }}">Delete</button>
                                <button class="btn btn-sm btn-warning ms-2 edit-brand" data-id="{{ $brand->id }}" data-name="{{ $brand->name }}">Edit</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Brand Modal -->
    <div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBrandForm">
                        <div class="mb-3">
                            <label for="edit_brand_name" class="form-label">Brand Name</label>
                            <input type="text" class="form-control" id="edit_brand_name" name="edit_brand_name" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="updateBrand">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- UOM Modal -->
    <div class="modal fade" id="uomModal" tabindex="-1" aria-labelledby="uomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uomModalLabel">Add Unit of Measurement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uomForm">
                        <div class="mb-3">
                            <label for="uom_name" class="form-label">UOM Name</label>
                            <input type="text" class="form-control" id="uom_name" name="uom_name" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="addUom">Add</button>
                    </form>
                    <hr>
                    <h5>Existing UOMs</h5>
                    <ul id="uomList">
                        @foreach ($uoms as $uom)
                            <li>
                                {{ $uom->name }}
                                <button class="btn btn-sm btn-danger ms-2 delete-uom" data-id="{{ $uom->id }}">Delete</button>
                                <button class="btn btn-sm btn-warning ms-2 edit-uom" data-id="{{ $uom->id }}" data-name="{{ $uom->name }}">Edit</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit UOM Modal -->
    <div class="modal fade" id="editUomModal" tabindex="-1" aria-labelledby="editUomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUomModalLabel">Edit Unit of Measurement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUomForm">
                        <div class="mb-3">
                            <label for="edit_uom_name" class="form-label">UOM Name</label>
                            <input type="text" class="form-control" id="edit_uom_name" name="edit_uom_name" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="updateUom">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = '{{ csrf_token() }}';

        // Add Category
        document.getElementById('addCategory').addEventListener('click', function() {
            const categoryName = document.getElementById('category_name').value;
            if (categoryName) {
                fetch('{{ route("product_categories.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ name: categoryName })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const categoryList = document.getElementById('categoryList');
                        const newCategory = document.createElement('li');
                        newCategory.innerHTML = `${data.category.name} 
                            <button class="btn btn-sm btn-danger ms-2 delete-category" data-id="${data.category.id}">Delete</button>
                            <button class="btn btn-sm btn-warning ms-2 edit-category" data-id="${data.category.id}" data-name="${data.category.name}">Edit</button>`;
                        categoryList.appendChild(newCategory);

                        const categorySelect = document.getElementById('category_id');
                        const newOption = document.createElement('option');
                        newOption.value = data.category.id;
                        newOption.text = data.category.name;
                        categorySelect.appendChild(newOption);

                        document.getElementById('category_name').value = '';
                    }
                });
            }
        });

        // Add Brand
        document.getElementById('addBrand').addEventListener('click', function() {
            const brandName = document.getElementById('brand_name').value;
            if (brandName) {
                fetch('{{ route("brands.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ name: brandName })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const brandList = document.getElementById('brandList');
                        const newBrand = document.createElement('li');
                        newBrand.innerHTML = `${data.brand.name} 
                            <button class="btn btn-sm btn-danger ms-2 delete-brand" data-id="${data.brand.id}">Delete</button>
                            <button class="btn btn-sm btn-warning ms-2 edit-brand" data-id="${data.brand.id}" data-name="${data.brand.name}">Edit</button>`;
                        brandList.appendChild(newBrand);

                        const brandSelect = document.getElementById('brand_id');
                        const newOption = document.createElement('option');
                        newOption.value = data.brand.id;
                        newOption.text = data.brand.name;
                        brandSelect.appendChild(newOption);

                        document.getElementById('brand_name').value = '';
                    }
                });
            }
        });

        // Add UOM
        document.getElementById('addUom').addEventListener('click', function() {
            const uomName = document.getElementById('uom_name').value;
            if (uomName) {
                fetch('{{ route("uoms.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ name: uomName })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const uomList = document.getElementById('uomList');
                        const newUom = document.createElement('li');
                        newUom.innerHTML = `${data.uom.name} 
                            <button class="btn btn-sm btn-danger ms-2 delete-uom" data-id="${data.uom.id}">Delete</button>
                            <button class="btn btn-sm btn-warning ms-2 edit-uom" data-id="${data.uom.id}" data-name="${data.uom.name}">Edit</button>`;
                        uomList.appendChild(newUom);

                        const uomSelect = document.getElementById('uom_id');
                        const newOption = document.createElement('option');
                        newOption.value = data.uom.id;
                        newOption.text = data.uom.name;
                        uomSelect.appendChild(newOption);

                        document.getElementById('uom_name').value = '';
                    }
                });
            }
        });

        // Delete Category
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('delete-category')) {
                const id = e.target.getAttribute('data-id');
                fetch(`/product_categories/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        e.target.parentElement.remove();
                        const categorySelect = document.getElementById('category_id');
                        const optionToRemove = categorySelect.querySelector(`option[value='${id}']`);
                        if (optionToRemove) optionToRemove.remove();
                    }
                });
            }
        });

        // Delete Brand
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('delete-brand')) {
                const id = e.target.getAttribute('data-id');
                fetch(`/brands/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        e.target.parentElement.remove();
                        const brandSelect = document.getElementById('brand_id');
                        const optionToRemove = brandSelect.querySelector(`option[value='${id}']`);
                        if (optionToRemove) optionToRemove.remove();
                    }
                });
            }
        });

        // Delete UOM
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('delete-uom')) {
                const id = e.target.getAttribute('data-id');
                fetch(`/uoms/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        e.target.parentElement.remove();
                        const uomSelect = document.getElementById('uom_id');
                        const optionToRemove = uomSelect.querySelector(`option[value='${id}']`);
                        if (optionToRemove) optionToRemove.remove();
                    }
                });
            }
        });

        // Edit Category
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('edit-category')) {
                const id = e.target.getAttribute('data-id');
                const name = e.target.getAttribute('data-name');
                document.getElementById('edit_category_name').value = name;
                document.getElementById('updateCategory').setAttribute('data-id', id);
                $('#editCategoryModal').modal('show');
            }
        });

        document.getElementById('updateCategory').addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = document.getElementById('edit_category_name').value;
            if (name) {
                fetch(`/product_categories/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ name: name })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const categoryList = document.getElementById('categoryList');
                        const listItem = categoryList.querySelector(`button[data-id='${id}']`).parentElement;
                        listItem.firstChild.textContent = name;
                        const categorySelect = document.getElementById('category_id');
                        const optionToUpdate = categorySelect.querySelector(`option[value='${id}']`);
                        if (optionToUpdate) optionToUpdate.textContent = name;
                        $('#editCategoryModal').modal('hide');
                    }
                });
            }
        });

        // Edit Brand
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('edit-brand')) {
                const id = e.target.getAttribute('data-id');
                const name = e.target.getAttribute('data-name');
                document.getElementById('edit_brand_name').value = name;
                document.getElementById('updateBrand').setAttribute('data-id', id);
                $('#editBrandModal').modal('show');
            }
        });

        document.getElementById('updateBrand').addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = document.getElementById('edit_brand_name').value;
            if (name) {
                fetch(`/brands/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ name: name })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const brandList = document.getElementById('brandList');
                        const listItem = brandList.querySelector(`button[data-id='${id}']`).parentElement;
                        listItem.firstChild.textContent = name;
                        const brandSelect = document.getElementById('brand_id');
                        const optionToUpdate = brandSelect.querySelector(`option[value='${id}']`);
                        if (optionToUpdate) optionToUpdate.textContent = name;
                        $('#editBrandModal').modal('hide');
                    }
                });
            }
        });

        // Edit UOM
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('edit-uom')) {
                const id = e.target.getAttribute('data-id');
                const name = e.target.getAttribute('data-name');
                document.getElementById('edit_uom_name').value = name;
                document.getElementById('updateUom').setAttribute('data-id', id);
                $('#editUomModal').modal('show');
            }
        });

        document.getElementById('updateUom').addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = document.getElementById('edit_uom_name').value;
            if (name) {
                fetch(`/uoms/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ name: name })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const uomList = document.getElementById('uomList');
                        const listItem = uomList.querySelector(`button[data-id='${id}']`).parentElement;
                        listItem.firstChild.textContent = name;
                        const uomSelect = document.getElementById('uom_id');
                        const optionToUpdate = uomSelect.querySelector(`option[value='${id}']`);
                        if (optionToUpdate) optionToUpdate.textContent = name;
                        $('#editUomModal').modal('hide');
                    }
                });
            }
        });
    });
</script>
@endsection
