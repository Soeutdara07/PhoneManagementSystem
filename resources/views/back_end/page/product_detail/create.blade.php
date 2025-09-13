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
<div class="modal fade" id="modalCreateProduct_Detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create Product</h1>
            </div>
            <div class="modal-body">
                <form class="formCreateProduct_Detail" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Product</label>
                                <select name="product_id" class="product_add form-control" id="product_add">
                                </select>
                                <p></p>
                            </div>
                            <div class="form-group">
                                <label for="price">Cost</label>
                                <input type="text" class="cost_add form-control" name="cost">
                                <p></p>
                            </div>

                            <div class="form-group">
                                <label for="price">Sale Price</label>
                                <input type="text" class="sale_price_add form-control" name="sale_price">
                                <p></p>
                            </div>

                            <div class="form-group">
                                <label for="qty">Indentifier</label>
                                <input type="text" class="product_indentifier_add form-control" name="product_identifier">
                                <p></p>
                            </div>


                            <div class="form-group">
                                <label for="name">Description</label>
                                <textarea name="product_description" id="desc" class="desc form-control" rows="2"></textarea>
                            </div>

                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Supplier</label>
                                <select name="supplier_id" class="supplier_add form-control" id="supplier_add">
                                </select>
                                <p></p>
                            </div>


                            <div class="form-group">
                                <label for="">Color</label>
                                <select name="color_id" id="color_add" style="width : 100%" class="color_add form-control">
                                </select>
                                <p></p>
                            </div>

                             <div class="form-group">
                                <label for="qty">Condition</label>
                                <input type="text" class="condition_add form-control" name="condition">
                                <p></p>
                            </div>

                            <div class="form-group">
                                <label for="">Sold Status</label>
                                <select name="sold_status" id="status" class="status_add form-control">
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
                <button onclick="Product_Detail_Store('.formCreateProduct_Detail')" type="button"
                    class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
