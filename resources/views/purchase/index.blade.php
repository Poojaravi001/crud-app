@extends('layouts.app')

@section('main')
<div class="container my-5">
    <h2 class="text-center mb-4 animate-header"><i class="bi bi-bag"></i> Purchase</h2>
{{-- 
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}

    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf

        <!-- Supplier and Invoice Details -->
        <div class="row mb-3">
            <div class="col-md-2">
                <label for="receiptNo" class="form-label">Receipt No</label>
                <input type="text" class="form-control" name="receipt_no" value="{{ old('receipt_no', $newReceiptNo ?? '') }}" readonly>
            </div>
            <div class="col-md-2">
                <label for="receiptDate" class="form-label">Receipt Date</label>
                <input type="date" class="form-control" name="receipt_date" value="{{ now()->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-3">
                <label for="supplierName" class="form-label">Supplier Name</label>
                <select class="form-control" name="supplier_id" required>
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="invoiceNo" class="form-label">Invoice No</label>
                <input type="text" class="form-control" name="invoice_no" required>
            </div>
            <div class="col-md-3">
                <label for="invoiceDate" class="form-label">Invoice Date</label>
                <input type="date" class="form-control" name="invoice_date"value="{{ now()->format('Y-m-d') }}" required>
            </div>
        </div>

        <!-- Items Container -->
        <div id="items-container">
            <div class="row mb-3 item-row align-items-center">
                <div class="col-md-3">
                    <label for="product0" class="form-label">Product</label>
                    <select class="form-control product-select" name="products[0]" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                data-price="{{ $product->price }}" 
                                data-purchase-cost="{{ $product->purchase_cost }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <label for="quantity0" class="form-label">Quantity</label>
                    <input type="number" class="form-control quantity-input" name="quantities[0]" min="1" required>
                </div>
                <div class="col-md-2">
                    <label for="price0" class="form-label">Price</label>
                    <input type="number" class="form-control price-input" name="prices[0]" readonly>
                </div>
                <div class="col-md-2">
                    <label for="cost0" class="form-label">Purchase Cost</label>
                    <input type="number" class="form-control cost-input" name="costs[0]" readonly>
                </div>
                <div class="col-md-2">
                    <label for="total0" class="form-label">Total (₹)</label>
                    <input type="number" class="form-control total-input" name="totals[0]" readonly>
                </div>
                <div class="col-md-2 text-end">
    <button type="button" class="btn btn-danger removeItemButton mt-4">
        <i class="bi bi-trash"></i> <!-- Bootstrap Trash Icon -->
    </button>
</div>

            </div>
        </div>

        <!-- Add Item Button -->
        <div class="row mb-3">
            <div class="col-md-6">
                <button type="button" class="btn btn-secondary" id="addItemButton">Add Item</button>
            </div>
        </div>

        <!-- Tax and Grand Total -->
        <div class="row mb-3 align-items-center justify-content-between">
            <div class="col-md-2">
                <label for="tax_percentage" class="form-label">Tax (%)</label>
                <input type="number" class="form-control" id="tax_percentage" name="tax_percentage" value="0" min="0">
            </div>
            <div class="col-md-2">
                <label for="taxAmount" class="form-label">Tax Amount (₹)</label>
                <input type="number" class="form-control" id="taxAmount" name="tax_amount" readonly>
            </div>
            <div class="col-md-3">
                <label for="grandTotal">Grand Total (₹):</label>
                <input type="number" class="form-control" id="grandTotal" name="grand_total" readonly>
            </div>
            <div class="col-md-3 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<script>
let itemCount = document.querySelectorAll('.item-row').length; // Initialize based on existing rows

// Add New Item Row
document.getElementById('addItemButton').addEventListener('click', function () {
    addItemRow(); // Call function to add a new item row
});

// Function to Add a New Item Row
function addItemRow() {
    const newRow = document.createElement('div');
    newRow.classList.add('row', 'mb-3', 'item-row', 'align-items-center');
    newRow.innerHTML = `
        <div class="col-md-3">
            <select class="form-control product-select" name="products[${itemCount}]" required>
                ${document.querySelector('.product-select').innerHTML}
            </select>
        </div>
        <div class="col-md-1">
            <input type="number" class="form-control quantity-input" name="quantities[${itemCount}]" min="1" required>
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control price-input" name="prices[${itemCount}]" readonly>
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control cost-input" name="costs[${itemCount}]" readonly>
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control total-input" name="totals[${itemCount}]" readonly>
        </div>
        <div class="col-md-2 text-end">
            <button type="button" class="btn btn-danger removeItemButton mt-4">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    document.getElementById('items-container').appendChild(newRow);
    itemCount++; // Increment the item count for future rows
}

// Event Delegation for Remove Item Button
document.getElementById('items-container').addEventListener('click', function (e) {
    if (e.target.closest('.removeItemButton')) {
        if (confirm('Are you sure you want to remove this item?')) {
            e.target.closest('.item-row').remove();
            updateItemCount(); // Update item count after removing a row
            calculateGrandTotal(); // Recalculate total after row removal
        }
    }
});

// Update Item Count Based on Remaining Rows
function updateItemCount() {
    itemCount = document.querySelectorAll('.item-row').length;
}

// Update Price and Cost when Product Changes
document.addEventListener('change', function (e) {
    if (e.target.classList.contains('product-select')) {
        const selectedOption = e.target.selectedOptions[0];
        const row = e.target.closest('.item-row');
        row.querySelector('.price-input').value = selectedOption.dataset.price;
        row.querySelector('.cost-input').value = selectedOption.dataset.purchaseCost;
        calculateRowTotal(row);
    }
});

// Calculate Row Total when Quantity Changes
document.addEventListener('input', function (e) {
    if (e.target.classList.contains('quantity-input')) {
        const row = e.target.closest('.item-row');
        calculateRowTotal(row);
    }
});

// Calculate Row Total and Grand Total
function calculateRowTotal(row) {
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
    const subtotal = price * quantity;

    row.querySelector('.total-input').value = subtotal.toFixed(2);
    calculateGrandTotal(); // Update grand total
}

// Calculate Grand Total and Tax Amount
function calculateGrandTotal() {
    let grandTotal = 0;
    let totalSubtotal = 0;

    document.querySelectorAll('.total-input').forEach(input => {
        const subtotal = parseFloat(input.value) || 0;
        totalSubtotal += subtotal;
    });

    const taxPercentage = parseFloat(document.getElementById('tax_percentage').value) || 0;
    const taxAmount = (totalSubtotal * taxPercentage) / 100;
    grandTotal = totalSubtotal + taxAmount;

    document.getElementById('taxAmount').value = taxAmount.toFixed(2);
    document.getElementById('grandTotal').value = grandTotal.toFixed(2);
}


document.getElementById('tax_percentage').addEventListener('input', function () {
    calculateGrandTotal();
});

</script>

<style>
/* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa; /* Light background color */
    color: #343a40; /* Dark text color */
}

.container {
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
    background-color: #ffffff; /* White background for the form */
}

/* Header Styles */
h2 {
    font-size: 1.75rem;
    color: #007bff; /* Bootstrap primary color */
}

.animate-header {
    transition: color 0.5s ease; /* Smooth transition for color change */
}

/* Form Input Styles */
.form-label {
    font-weight: bold;
}

.form-control {
    border-radius: 4px;
    border: 1px solid #ced4da;
    transition: border-color 0.3s; /* Smooth border transition */
}

.form-control:focus {
    border-color: #007bff; /* Focus border color */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Focus shadow effect */
}

/* Button Styles */
.btn {
    border-radius: 4px;
    transition: background-color 0.3s, transform 0.2s; /* Smooth transition for buttons */
}

.btn:hover {
    background-color: #0056b3; /* Darker shade for hover */
    transform: translateY(-2px); /* Lift effect on hover */
}

.btn-danger {
    background-color: #dc3545; /* Red color for remove button */
}

.btn-danger:hover {
    background-color: #c82333; /* Darker shade for hover */
}

/* Item Row Styles */
.item-row {
    border-bottom: 1px solid #e9ecef; /* Separator for rows */
    padding: 10px 0; /* Vertical padding */
}

.item-row:last-child {
    border-bottom: none; /* Remove border for last row */
}

/* Aligning Elements */
.align-items-center {
    align-items: center; /* Center align items vertically */
}

.text-end {
    text-align: end; /* Align text to the right */
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-control {
        font-size: 0.9rem; /* Smaller font on mobile */
    }

    .btn {
        font-size: 0.9rem; /* Smaller button on mobile */
    }

    .item-row {
        flex-direction: column; /* Stack items vertically */
    }
}

/* Animation for Add Item Button */
#addItemButton {
    margin-top: 20px;
    animation: fadeIn 0.5s; /* Fade in effect */
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Total and Tax Styles */
#taxAmount, #grandTotal {
    font-weight: bold;
}

</style>
@endsection
