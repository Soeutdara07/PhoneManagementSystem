<style>
    /* === Select2 Custom Styles (unchanged) === */
    .select2-container--default .select2-selection--single {
        background-color: var(--card-bg);
        padding: 1.5rem;
        border-radius: 1rem;
        border: 1px solid var(--border-color);
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 15px;
        width: 100%;
        justify-content: space-between;
        padding-inline: 0;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 45px;
    }

    .select2-container--default .select2-dropdown--below {
        border-radius: 0 0 20px 20px;
    }

    .select2-container--default .select2-dropdown--below .select2-search--dropdown .select2-search__field {
        background-color: var(--card-bg);
        padding: 0.50rem;
        border-radius: 1rem;
        border: 1px solid var(--border-color);
        outline: none;
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
    }

    .select2-container--open {
        z-index: 9999 !important;
    }

    .btnRemoveSection:hover,
    .btnRemoveSection:focus,
    .btnRemoveSection:active {
        background-color: transparent !important;
        color: inherit !important;
        box-shadow: none !important;
    }

    /* === Currency input styling === */
    .currency-wrapper {
        position: relative;
    }

    .currency-wrapper::before {
        content: '$';
        position: absolute;
        left: 12px;
        top: 65%;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
    }

    .currency-wrapper input {
        padding-left: 1.8rem;
        /* space for the $ */
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

                            <!-- Product -->
                            <div class="form-group">
                                <label for="product_add">Product</label>
                                <select name="product_id" class="product_add form-control" id="product_add"></select>
                            </div>

                            <!-- Cost -->
                            <div class="form-group currency-wrapper">
                                <label for="cost">Cost</label>
                                <input type="text" id="cost" class="form-control currency-input" name="cost"
                                    placeholder="0.00">
                            </div>

                            <!-- Sale Price -->
                            <div class="form-group currency-wrapper">
                                <label for="sale_price">Sale Price</label>
                                <input type="text" id="sale_price" class="form-control currency-input"
                                    name="sale_price" placeholder="0.00">
                            </div>

                            <!-- Identifier -->
                            <div class="form-group">
                                <label for="product_identifier">Identifier</label>
                                <input type="text" class="product_indentifier_add form-control"
                                    name="product_identifier" id="product_identifier">
                            </div>

                        </div>

                        <div class="col-lg-6">
                            <!-- Supplier -->
                            <div class="form-group">
                                <label for="supplier_add">Supplier</label>
                                <select name="supplier_id" class="supplier_add form-control" id="supplier_add"></select>
                            </div>

                            <!-- Color -->
                            <div class="form-group">
                                <label for="color_add">Color</label>
                                <select name="color_id" id="color_add" style="width: 100%"
                                    class="color_add form-control"></select>
                            </div>

                            <!-- Condition -->
                            <div class="form-group">
                                <label for="condition">Condition</label>
                                <input type="text" class="condition_add form-control" name="condition"
                                    id="condition">
                            </div>

                            <!-- Sold Status -->
                            <div class="form-group">
                                <label for="status">Sold Status</label>
                                <select name="sold_status" id="status" class="status_add form-control">
                                    <option value="1">available</option>
                                    <option value="2">sold</option>
                                    <option value="3">reserved</option>
                                    <option value="0"></option>
                                </select>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea name="product_description" id="desc" class="desc form-control" rows="2"></textarea>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.currency-input');

        inputs.forEach(input => {
            input.addEventListener('input', () => {
                // Keep only digits and a single decimal
                let raw = input.value.replace(/[^0-9.]/g, '');
                if (raw.includes('.')) {
                    const [intPart, decPart] = raw.split('.');
                    raw = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '.' + decPart;
                } else {
                    raw = raw.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                }
                input.value = raw; // no '$' so placeholder works
            });

            // Before submit, strip commas
            input.form?.addEventListener('submit', () => {
                input.value = input.value.replace(/,/g, '');
            });
        });
    });
</script>
