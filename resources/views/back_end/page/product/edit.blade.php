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

<div class="modal fade" id="modalUpdateProduct" tabindex="-1" aria-hidden="true" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" style="max-width: 50%;">
        <div class="modal-content">
            <form id="formUpdateProduct" class="formUpdateProduct" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" class="product_id" value="">
                    <div class="mb-3">
                        <label>Product Name</label>
                        <input type="text" class="form-control title_edit" name="product_name" required>
                        <p class="text-danger mt-1"></p>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-lg-6">
                            <label>Category</label>
                            <select id="category_edit" name="category_id" class="form-select" required></select>
                        </div>
                        <div class="col-lg-6">
                            <label>Brand</label>
                            <select id="brand_edit" name="brand_id" class="form-select" required></select>
                        </div>
                    </div>

                    <input type="hidden" name="remove_image_ids" id="remove_image_ids_edit">

                    <div class="form-group">
                        <label for="">Product Image</label>
                        <input type="file" id="image" class="image form-control" multiple name="image[]"
                            accept="image/*">
                        <p></p>
                        <button type="button" onclick="ProductUpload('.formUpdateProduct')"
                            class=" btn btn-primary upload_images">Uploads</button>
                    </div>

                    {{-- show image after uploads --}}
                    <div class="show-images-edit d-flex flex-wrap mb-2"></div>




                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <h6>Sections & Specifications</h6>
                        <button type="button" id="btnAddSectionEdit" class="btn btn-outline-secondary btn-sm">
                            + Add Section
                        </button>
                    </div>



                    <div id="sectionsWrapperEdit"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateProduct('#formUpdateProduct')">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
