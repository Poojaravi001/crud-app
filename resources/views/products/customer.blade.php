@extends('layouts.app')
@section('main')
<h2 class="text-center mb-4 animate-header">Sales</h2>


<form action="{{ route('customers.store') }}" method="POST" class="sales-form p-4 border rounded bg-light shadow animate-form">
    @csrf


    <div class="row mb-3">
        
        <div class="col-md-4">
            <label for="billNo" class="form-label">Bill No</label>
            <input type="text" class="form-control animated-input" id="billNo" name="bill_no" value="{{ $newBillNo }}" readonly>
        </div>

     
<div class="col-md-4">
    <label for="billDate" class="form-label">Bill Date</label>
    <input type="date" class="form-control animated-input" id="billDate" name="bill_date" value="{{ now()->format('Y-m-d') }}" required>
</div>


       
        <div class="col-md-4">
            <label for="customerName" class="form-label">Customer Name</label>
            <select class="form-control animated-input" id="customerName" name="customer_name" required>
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->name }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

   
    <div id="items-container">
        <div class="row mb-3 item-row">
            <!-- Product -->
            <div class="col-md-3">
                <label for="product0" class="form-label">Product</label>
                <select class="form-control animated-input" id="product0" name="products[0]" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Quantity -->
            <div class="col-md-1">
                <label for="quantity0" class="form-label">Quantity</label>
                <input type="number" class="form-control animated-input" id="quantity0" name="quantities[0]" required>
            </div>

            <!-- MRP -->
            <div class="col-md-2">
                <label for="mrp0" class="form-label">MRP</label>
                <input type="number" class="form-control animated-input" id="mrp0" name="mrps[0]" required>
            </div>

            <!-- Rate -->
            <div class="col-md-2">
                <label for="rate0" class="form-label">Selling Price</label>
                <input type="number" class="form-control animated-input" id="rate0" name="rates[0]" required>
            </div>

            <!-- Discount -->
            <div class="col-md-2">
                <label for="discount0" class="form-label">Discount</label>
                <input type="number" class="form-control animated-input" id="discount0" name="discounts[0]" required>
            </div>

            <!-- Total -->
            <div class="col-md-2">
                <label for="total0" class="form-label">Total</label>
                <input type="number" class="form-control animated-input" id="total0" name="totals[0]" readonly style="background-color: #f9f9f9;">
            </div>

            <!-- Remove Item Button with Icon -->
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-danger removeItemButton" style="margin-top: 30px;">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>

   
    <div class="row mb-3 align-items-center">
        <!-- Add Item Button -->
        <div class="col-md-4 text-center">
            <button type="button" class="btn btn-secondary" id="addItemButton">
                <i class="bi bi-plus"></i> Add Item
            </button>
        </div>

        <!-- Submit Button -->
        <div class="col-md-4 text-center">
            <button type="submit" class="btn btn-primary animated-btn">Submit</button>
        </div>

        <!-- Grand Total -->
        <div class="col-md-4 text-end">
            <span class="grand-total-text">Grand Total:</span>
            <input type="number" class="form-control d-inline-block small-input" id="grandTotal" name="grand_total" readonly style="width: 150px; display: inline-block;">
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const itemsContainer = document.getElementById('items-container');
    const grandTotalInput = document.getElementById('grandTotal');
    let itemCount = 1;

    function calculateTotal(row) {
        const quantity = parseFloat(row.querySelector('input[name^="quantities"]').value) || 0;
        const rate = parseFloat(row.querySelector('input[name^="rates"]').value) || 0;
        const totalInput = row.querySelector('input[name^="totals"]');
        const total = quantity * rate;
        totalInput.value = total.toFixed(2);
        return total;
    }

    function calculateDiscount(row) {
        const mrp = parseFloat(row.querySelector('input[name^="mrps"]').value) || 0;
        const rate = parseFloat(row.querySelector('input[name^="rates"]').value) || 0;
        const quantity = parseFloat(row.querySelector('input[name^="quantities"]').value) || 0;
        const discountInput = row.querySelector('input[name^="discounts"]');
        
        // Calculate total discount for the quantity
        const discountPerItem = mrp - rate;
        const totalDiscount = discountPerItem * quantity;
        
        discountInput.value = totalDiscount.toFixed(2);
    }

    function calculateGrandTotal() {
        let grandTotal = 0;
        const itemRows = itemsContainer.getElementsByClassName('item-row');
        for (let row of itemRows) {
            grandTotal += calculateTotal(row);
        }
        grandTotalInput.value = grandTotal.toFixed(2);
    }

    // Recalculate totals and discounts on input change
    itemsContainer.addEventListener('input', function(event) {
        const row = event.target.closest('.item-row');
        if (row) {
            calculateTotal(row);
            calculateDiscount(row);
        }
        calculateGrandTotal();
    });

    // Handle product selection change
    itemsContainer.addEventListener('change', function (event) {
        if (event.target.tagName === 'SELECT' && event.target.name.startsWith('products')) {
            const productId = event.target.value;
            const row = event.target.closest('.item-row');
            const mrpInput = row.querySelector('input[name^="mrps"]');
            const rateInput = row.querySelector('input[name^="rates"]');

            if (productId) {
                // Make an AJAX request to get the product details
                fetch(`/product-details/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.mrp && data.rate) {
                            mrpInput.value = data.mrp;
                            rateInput.value = data.rate;
                            calculateDiscount(row);
                        } else {
                            mrpInput.value = '';
                            rateInput.value = '';
                        }
                        calculateGrandTotal();
                    })
                    .catch(error => {
                        console.error('Error fetching product details:', error);
                        mrpInput.value = '';
                        rateInput.value = '';
                    });
            } else {
                mrpInput.value = '';
                rateInput.value = '';
            }
        }
    });

    // Add more items dynamically
    document.getElementById('addItemButton').addEventListener('click', function () {
        const newRow = document.createElement('div');
        newRow.className = 'row mb-3 item-row';

        let productOptions = '';
        @json($products).forEach(product => {
            productOptions += `<option value="${product.id}">${product.name}</option>`;
        });

        newRow.innerHTML = `
            <div class="col-md-3">
                <label for="product${itemCount}" class="form-label">Product</label>
                <select class="form-control animated-input" id="product${itemCount}" name="products[${itemCount}]" required>
                    <option value="">Select Product</option>
                    ${productOptions}
                </select>
            </div>
            <div class="col-md-1">
                <label for="quantity${itemCount}" class="form-label">Quantity</label>
                <input type="number" class="form-control animated-input" id="quantity${itemCount}" name="quantities[${itemCount}]" required>
            </div>
            <div class="col-md-2">
                <label for="mrp${itemCount}" class="form-label">MRP</label>
                <input type="number" class="form-control animated-input" id="mrp${itemCount}" name="mrps[${itemCount}]" required>
            </div>
            <div class="col-md-2">
                <label for="rate${itemCount}" class="form-label">Selling Price</label>
                <input type="number" class="form-control animated-input" id="rate${itemCount}" name="rates[${itemCount}]" required>
            </div>
            <div class="col-md-2">
                <label for="discount${itemCount}" class="form-label">Discount</label>
                <input type="number" class="form-control animated-input" id="discount${itemCount}" name="discounts[${itemCount}]" required>
            </div>
            <div class="col-md-2">
                <label for="total${itemCount}" class="form-label">Total</label>
                <input type="number" class="form-control animated-input" id="total${itemCount}" name="totals[${itemCount}]" readonly style="background-color: #f9f9f9;">
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-danger removeItemButton" style="margin-top: 30px;">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        itemsContainer.appendChild(newRow);
        itemCount++;
    });

    // Remove item row with confirmation
    itemsContainer.addEventListener('click', function (event) {
        if (event.target.closest('.removeItemButton')) {
            const row = event.target.closest('.item-row');
            if (confirm('Are you sure you want to remove this item?')) {
                if (row) {
                    itemsContainer.removeChild(row);
                    calculateGrandTotal();
                }
            }
        }
    });
});
</script>





<style>
/* General animation for header */
@keyframes slideIn {
    0% {
        opacity: 0;
        transform: translateY(-50px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-header {
    animation: slideIn 1s ease-in-out;
}

/* Fade-in form on load */
.animate-form {
    animation: fadeIn 1.2s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Styling for form */
.sales-form {
    background-color: #f7f9fc;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
}

/* Styling form labels */
.sales-form .form-label {
    font-weight: bold;
    font-size: 1.1rem;
    color: #555;
}

/* Style for form inputs */
.sales-form .form-control {
    border-radius: 8px;
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #ced4da;
    background-color: #fff;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.sales-form .form-control:focus {
    background-color: #e9f7ff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
    border-color: #007bff;
}

/* Button styles */
.animated-btn {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    color: #fff;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 1rem;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.animated-btn:hover {
    background: linear-gradient(45deg, #0056b3, #003d7f);
    transform: translateY(-3px);
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
}

/* Add Item Button */
#addItemButton {
    background-color: #28a745;
    border-radius: 8px;
    color: #fff;
    padding: 10px 15px;
    font-size: 1rem;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

#addItemButton:hover {
    background-color: #218838;
    transform: translateY(-3px);
}

/* Remove Item Button */
/* .removeItemButton {
    background-color: #dc3545;
    border-radius: 8px;
    color: #fff;
    padding: 10px 15px;
    font-size: 1rem;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.removeItemButton:hover {
    background-color: #c82333;
    transform: translateY(-3px);
} */

/* Styling for grand total input */
.grand-total-text {
    font-size: 1rem;
    font-weight: bold;
    color: #333;
}

.small-input {
    border-radius: 8px;
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ced4da;
    background-color: #f1f3f5;
}

/* Form container and input spacing */
.sales-form .row {
    margin-bottom: 15px;
}

.sales-form .form-control {
    box-shadow: none;
    transition: all 0.3s ease-in-out;
}

.sales-form .form-control:hover {
    background-color: #f8f9fa;
}

</style>

@endsection