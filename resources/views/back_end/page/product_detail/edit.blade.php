<style>
    /* Custom height for a Select2 dropdown */
    .select2-container--default .select2-selection--single {
        background-color: var(--card-bg);
        padding: 1.5rem;
        border-radius: 1rem;
        /* box-shadow: var(--shadow-heavy); */
        border: 1px solid var(--border-color);
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
    }

    /* Custom height for the text inside the box */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 15px;
        /* Ensures text is vertically centered */
        width: 100%;
        justify-content: space-between;
        padding-inline: 0;
    }

    /* Custom height for the arrow */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 45px;
        /* Adjusts the arrow's height to match the box */
    }

    .select2-container--default .select2-dropdown--below {
        border-radius: 0px 0 20px 20px;
    }

    .select2-container--default .select2-dropdown--below .select2-search--dropdown .select2-search__field {
        background-color: var(--card-bg);
        padding: 0.50rem;
        border-radius: 1rem;
        /* box-shadow: var(--shadow-heavy); */
        border: 1px solid var(--border-color);
        outline: none;
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
    }

    .select2-container--open {
        z-index: 9999 !important;
        /* Ensure dropdown is above everything */
    }

    .btnRemoveSection:hover,
    .btnRemoveSection:focus,
    .btnRemoveSection:active {
        background-color: transparent !important;
        color: inherit !important;
        box-shadow: none !important;
    }
</style>

<div class="modal fade" id="modalUpdateProduct_Detail" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Product</h1>
            </div>
            <div class="modal-body">
                <form class="formUpdateProduct_Detail" method="POST" enctype="multipart/form-data" data-id="">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Product</label>
                                <input type="hidden" name="id" class="product_detail_id" value="">
                                <select name="product_id" class="product_edit form-control select2" id="edit_product_id"></select>
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Cost</label>
                                <input type="text" class="cost_edit form-control" name="cost" id="edit_cost">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Sale Price</label>
                                <input type="text" class="sale_price_edit form-control" name="sale_price" id="edit_sale_price">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Identifier</label>
                                <input type="text" class="product_indentifier_edit form-control" name="product_identifier" id="edit_product_identifier">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="product_description" id="edit_desc" class="desc_edit form-control" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Supplier</label>
                                <select name="supplier_id" class="supplier_edit form-control select2" id="edit_supplier_id"></select>
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Color</label>
                                <select name="color_id" id="edit_color_id" style="width: 100%" class="color_edit form-control select2"></select>
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Condition</label>
                                <input type="text" class="condition_edit form-control select2" name="condition" id="edit_condition">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label>Sold Status</label>
                                <select name="sold_status" id="edit_status" class="status_edit form-control select2">
                                    <option value="1">available</option>
                                    <option value="2">sold</option>
                                    <option value="3">reserved</option>
                                    <option value="0"></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button onclick="Product_Detail_Update('.formUpdateProduct_Detail')" type="button"
                    class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
