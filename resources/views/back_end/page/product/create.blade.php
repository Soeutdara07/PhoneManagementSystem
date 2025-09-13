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

<div class="modal fade" id="modalCreateProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="formCreateProduct" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label>Product Title</label>
                                <input type="text" class="title_add form-control" name="product_name">
                                <p></p>
                            </div>
                            <div class="d-flex">
                                <div class=" col-6 form-group mb-2 me-1">
                                    <label>Category</label>
                                    <select name="category" id="category_add" class="form-select category_add">
                                        <option value="">Select category</option>
                                    </select>
                                    <p></p>
                                </div>

                                <div class=" col-6 form-group mb-2">
                                    <label>Brand</label>
                                    <select name="brand" id="brand_add" class="form-select brand_add">
                                        <option value="">Select brand</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Product Image</label>
                            <input type="file" id="upload_image" class="image form-control" name="image[]">
                            <button type="button" onclick="ProductUpload('.formCreateProduct')"
                                class="btn btn-primary upload_images mt-2">Uploads</button>
                            <p></p>
                        </div>

                        <div class="show-images row"></div>
                        <div id="sectionsWrapper" class="py-3"></div>

                    </div>
                    {{-- Sections --}}
                    <div class="align-items-center mb-2 mt-3 w-100">
                        <button type="button" class="btn btn-sm btn-outline-primary w-100" id="btnAddSection">
                            + Add Section
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button onclick="storeProduct('.formCreateProduct')" type="button"
                    class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
