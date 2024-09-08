@extends('admin.layouts.main')
@push('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    <div class="pagetitle">
        <h1>Create Expense</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Expenses</a></li>
                <li class="breadcrumb-item active">Create Expense</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">New Expense</h5>

                        <form action="{{ route('expenses.store') }}" method="POST">
                            @csrf
                            <!-- Category Section -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Expense Category</label>
                                <div class="d-flex">
                                    <select class="form-control me-2" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                        Add Category
                                    </button>
                                </div>
                            </div>

                            <!-- Amount and Description -->
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="expense_date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="expense_date" name="expense_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Expense</button>
                            <a class="btn btn-primary" href="{{ route('expenses.index') }}" role="button">View Expenses</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
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
                    <button type="button" id="loadCategories" class="btn btn-info">View Existing Categories</button>
                    <div id="existingCategories" class="mt-3" style="display:none;">
                        <h5>Existing Categories</h5>
                        <ul id="categoryList"></ul>
                        <ul id="categoryPagination" class="pagination"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Add Category Logic
    const addCategoryButton = document.getElementById('addCategory');
    if (addCategoryButton) {
        addCategoryButton.addEventListener('click', function() {
            const categoryName = document.getElementById('category_name').value;

            if (categoryName) {
                fetch('{{ route("categories.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ name: categoryName })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add new category to the dropdown list
                        const categorySelect = document.getElementById('category_id');
                        const newOption = document.createElement('option');
                        newOption.value = data.category.id;
                        newOption.text = data.category.name;
                        categorySelect.appendChild(newOption);
                        categorySelect.value = data.category.id; // Set new category as selected

                        // Clear form and hide modal
                        document.getElementById('categoryForm').reset();
                        $('#addCategoryModal').modal('hide');
                    } else {
                        console.error('Failed to add category:', data.message);
                    }
                })
                .catch(error => console.error('Error adding category:', error));
            }
        });
    }

    // Load Existing Categories
    document.getElementById('loadCategories').addEventListener('click', function() {
        fetchCategories(1); // Load first page of categories
    });

    function fetchCategories(page) {
        fetch(`/categories?page=${page}`)
            .then(response => response.json())
            .then(data => {
                const categoryList = document.getElementById('categoryList');
                const pagination = document.getElementById('categoryPagination');
                categoryList.innerHTML = '';
                pagination.innerHTML = '';

                // Populate category list
                data.categories.forEach(category => {
                    const listItem = document.createElement('li');
                    listItem.textContent = category.name;
                    categoryList.appendChild(listItem);
                });

                // Handle pagination
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
                        fetchCategories(i);
                    });

                    pageItem.appendChild(pageLink);
                    pagination.appendChild(pageItem);
                }

                document.getElementById('existingCategories').style.display = 'block';
            })
            .catch(error => console.error('Error loading categories:', error));
    }

});
</script>
@endpush
