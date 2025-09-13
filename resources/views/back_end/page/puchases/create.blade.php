<div class="modal fade" id="modalCreate_Puchases" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">Create Purchase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form action="{{ route('purchases.store') }}" method="POST" class="formCreatePurchase">
                    @csrf
                    <div class="row g-3">
                        <!-- Purchase Date -->
                        <div class="col-md-6">
                            <label for="purchase_date" class="form-label">Purchase Date</label>
                            <input type="date" class="form-control" name="purchase_date" id="purchase_date" required>
                        </div>

                        <!-- Product Name -->
                        <div class="col-md-6">
                            <label for="product_name" class="form-label">Product</label>
                            <input type="text" id="product_name" class="form-control" readonly>
                            <input type="hidden" name="product_detail_id" id="product_detail_id_hidden">
                        </div>

                        <!-- Quantity -->
                        <div class="col-md-6">
                            <label for="purchase_qty" class="form-label">Quantity</label>
                            <input type="number" name="purchase_qty" id="purchase_qty" class="form-control" min="1" required>
                        </div>

                        <!-- Unit Price -->
                        <div class="col-md-6">
                            <label for="purchase_price" class="form-label">Unit Price</label>
                            <input type="number" step="0.01" name="purchase_price" id="purchase_price" class="form-control" required>
                        </div>

                        <!-- Note -->
                        <div class="col-12">
                            <label for="purchase_note" class="form-label">Note</label>
                            <textarea name="purchase_note" id="purchase_note" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="Purchase_Store('.formCreatePurchase')" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
