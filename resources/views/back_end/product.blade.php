@extends('back_end.components.master')

@section('contents')
    {{-- Modal create start --}}
    @include('back_end.page.product.create')
    {{-- Modal create end --}}

    {{-- Modal edit start --}}
    @include('back_end.page.product.edit')
    {{-- Modal edit end --}}

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Products</h5>
                    <p onclick="handleNewProductClick()" data-bs-toggle="modal" data-bs-target="#modalCreateProduct"
                        class="card-description btn btn-info text-light"> <i class="fa-solid fa-circle-plus"
                            style="font-size:14px"></i>Add Product</p>

                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Photos</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="products_list"></tbody>
                    </table>
                </div>

                 {{-- page and buttion refresh --}}

                <div class="d-flex justify-content-between align-items-center">

                    <div class="show-page mt-3">

                    </div>

                    <div id="refresh-button-container" style="display: none;">
                        <button onclick="ButtonRefresh()" class="btn btn-outline-danger rounded-2 btn-sm">refresh</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let SECTION_IDX = 0;
        let SECTIONS_DATA = [];

        $(document).ready(function() {
            // Initialize main category and brand selects on modal open
            $('#modalCreateProduct').on('shown.bs.modal', function() {
                $('#category_add, #brand_add').select2({
                    width: '100%',
                    placeholder: 'Select option',
                    allowClear: true,
                    tags: true,
                    dropdownParent: $('#modalCreateProduct')
                });
            });
        });

        // Product List
        const ProductList = (page = 1, search = null) => {
            $(".products_list").html(`
                <tr>
                    <td colspan="9" class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                    </td>
                </tr>
            `);

            $.ajax({
                type: "POST",
                url: "{{ route('product.list') }}",
                data: {
                    page: page,
                    search: search,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status != 200) {
                        $(".products_list").html(
                            '<tr><td colspan="9" class="text-center text-danger">No products found.</td></tr>'
                        );
                        $(".show-page").html('');
                        return;
                    }

                    let products = response.products;
                    let tr = '';

                    if (products.length === 0) {
                        tr =
                            '<tr><td colspan="9" class="text-center text-danger">No products found.</td></tr>';
                    } else {
                        $.each(products, function(key, value) {
                            tr += `<tr>
                        <td>P${value.id}</td>
                        <td>${value.images.length > 0 ? `<img src="/uploads/product_image/${value.images[0]}" width="50" height="50">` : '-'}</td>
                        <td>${value.product_name}</td>
                        <td>${value.category ?? '-'}</td>
                        <td>${value.brand ?? '-'}</td>
                        <td>

                             <button type="button" onclick="product_edit(${value.id})" class="btn btn-sm border border-light-subtle text-info bg-transparent"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button type="button" onclick="ProductDelete(${value.id})" class="btn btn-sm border border-light-subtle text-danger bg-transparent"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </td>
                    </tr>`;
                        });
                    }

                    $(".products_list").html(tr);

                    // Pagination
                    let page = ``;
                    let totalPage = response.page.totalPage;
                    let currentPage = response.page.currentPage;
                    page = `
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li onclick="PreviousPage(${currentPage})" class="page-item ${(currentPage == 1) ? 'd-none' : 'd-block' }">
                                    <a class="page-link" href="javascript:void()" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                    </li>`;

                    for (let i = 1; i <= totalPage; i++) {
                        page += `
                            <li onclick="Page(${i})" class="page-item ${(i == currentPage) ? 'active' : '' }">
                                <a class="page-link" href="javascript:void()">${i}</a>
                            </li>`;
                        }

                    page += `<li onclick="NextPage(${currentPage})" class="page-item ${( currentPage == totalPage ) ? 'd-none' : 'd-block'}">
                                    <a class="page-link" href="javascript:void()" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                    </li>
                                </ul>
                            </nav>
                            `;

                    if (totalPage > 1) {
                        $(".show-page").html(page);

                    } else {
                        $(".show-page").html('');
                    }
                },
                error: function() {
                    $(".products_list").html(
                        '<tr><td colspan="9" class="text-center text-danger">Failed to load data.</td></tr>'
                    );
                    $(".show-page").html('');
                }
            });
        }

        // Handle page clicks
        $(document).ready(function() {
            ProductList();
        });

         //Brand Refresh page
        const ButtonRefresh = () => {
            $("#searchBox").val("");
            $("#refresh-button-container").hide();
            ProductList();
        }


        //search event 
        $(document).on("click", '.searchBtn', function() {
            let searchValue = $("#searchBox").val();
            ProductList(1, searchValue);

            //close modal
            $("#modalSearch").modal('hide');

            if (searchValue.length === 0) {
                $("#refresh-button-container").hide();
            } else {
                $("#refresh-button-container").show();
            }
        });



        //Pagination
        const Page = (page) => {
            ProductList(page);
        }

        //Previous Page
        const NextPage = (page) => {
            ProductList(page + 1);
        }

        //Previous Page
        const PreviousPage = (page) => {
            ProductList(page - 1);
        }

        // Open new product modal and fetch data
        const handleNewProductClick = () => {
            $.ajax({
                type: "POST",
                url: "{{ route('product.data') }}",
                dataType: "json",
                success: function(res) {
                    if (res.status === 200) {
                        // Save sections data globally
                        SECTIONS_DATA = res.data.sections || [];

                        // Categories
                        let cate_option = `<option value=""></option>`;
                        res.data.categories.forEach(v => cate_option +=
                            `<option value="${v.id}">${v.category_name}</option>`);
                        $('#category_add').html(cate_option).val(null).trigger('change');

                        // Brands
                        let brand_option = `<option value=""></option>`;
                        res.data.brands.forEach(v => brand_option +=
                            `<option value="${v.id}">${v.brand_name}</option>`);
                        $('#brand_add').html(brand_option).val(null).trigger('change');

                        // Reset sections
                        $('#sectionsWrapper').empty();
                        SECTION_IDX = 0;
                        addSectionBlock(true); // Add first section with one spec row
                    }
                }
            });
        };

        // Initialize a section <select> with options
        function refreshSectionOptions($select) {
            // Reset
            $select.empty().append('<option value="">Select Section</option>');

            // Add from global SECTIONS_DATA
            SECTIONS_DATA.forEach(v => {
                $select.append(`<option value="${v.id}">${v.name}</option>`);
            });

            // Re-init select2 only for this select
            if ($select.data('select2')) {
                $select.select2('destroy');
            }
            $select.select2({
                placeholder: "Select Section",
                width: "100%",
                allowClear: true,
                tags: true,
                dropdownParent: $('#modalCreateProduct')
            });
        }


        // Add new section block
        function addSectionBlock(withSpec = false) {
            const idx = SECTION_IDX++;

            // Build block
            const block = `
                <div class="card border-1 shadow-sm mb-3 section-block" data-sec-idx="${idx}">
                    <div class="col-lg-1 w-100 py-0 ">
                        <div class="text-end">
                            <button type="button" class="btn btnRemoveSection border-bottom border-start  ">
                                    <i class="fa-solid fa-trash-can text-danger"></i>
                            </button>
                        </div>

                    </div>
                    <div class="card-body pt-0">

                        <div class="row mb-3 position-relative">
                            <div class="col-lg-12">
                                <label>Section</label>
                                <select name="sections[${idx}][section_id]"
                                        class="form-select section_id" required></select>
                            </div>
                        </div>
                        <div class="specsWrapper"></div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2 btnAddSpec">
                            + Add Specification
                        </button>
                    </div>
                </div>`;

            // Append and keep reference
            const $block = $(block).appendTo('#sectionsWrapper');

            // Select inside this block only
            const $sel = $block.find('.section_id');

            // ✅ Populate dropdown immediately
            refreshSectionOptions($sel);

            if (withSpec) {
                addSpecRow($block);
            }
        }

        // Add specification row
        function addSpecRow($block) {
            const idx = $block.data('sec-idx');
            const count = $block.find('.spec-row').length;
            const row = `
            <div class="row g-2 align-items-center  spec-row mb-2">
                <div class="col-lg-5">
                     <label>Key</label>
                    <input type="text" name="sections[${idx}][specs][${count}][key]"
                        class="form-control" placeholder="Key" required>
                </div>
                <div class="col-lg-6">
                     <label>Value</label>
                    <input type="text" name="sections[${idx}][specs][${count}][value]"
                        class="form-control" placeholder="Value" required>
                </div>
                <div class="col-lg-1 text-end">
                    <button type="button" class="btn  mt-4 btn-danger btnRemoveSpec">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>`;
            $block.find('.specsWrapper').append(row);
        }

        // Dynamic actions for add/remove section/spec
        $('#btnAddSection').on('click', () => addSectionBlock(true));
        $('#sectionsWrapper').on('click', '.btnAddSpec', function() {
            addSpecRow($(this).closest('.section-block'));
        });
        $('#sectionsWrapper').on('click', '.btnRemoveSpec', function() {
            $(this).closest('.spec-row').remove();
        });
        $('#sectionsWrapper').on('click', '.btnRemoveSection', function() {
            $(this).closest('.section-block').remove();
        });

        // Store product
        const storeProduct = (formSelector) => {
            let form = document.querySelector(formSelector);
            let data = new FormData(form);

            $.ajax({
                type: "POST",
                url: "{{ route('product.store') }}",
                data: data,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.status == 200) {
                        // ✅ Success case
                        $(form).trigger("reset");
                        $('.show-images').html("");
                        $("#modalCreateProduct").modal('hide');

                        $('input').removeClass("is-invalid")
                            .siblings("p").removeClass("text-danger").text("");


                        ProductList();
                    } else {
                        // if you return some other custom response
                        Message(res.message, false);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        // Clear old errors
                        $('input, select, textarea').removeClass("is-invalid")
                            .siblings("p").removeClass("text-danger").text("");

                        // Show validation errors
                        if (errors.title) {
                            $('.title_add').addClass("is-invalid")
                                .siblings("p").addClass("text-danger")
                                .text(errors.title[0]);
                        }
                        if (errors.category) {
                            $('#category_add').addClass("is-invalid")
                                .siblings("p").addClass("text-danger")
                                .text(errors.category[0]);
                        }
                        if (errors.brand) {
                            $('#brand_add').addClass("is-invalid")
                                .siblings("p").addClass("text-danger")
                                .text(errors.brand[0]);
                        }
                    }
                }


            });
        };

        // Open modal and load product data for editing
        const product_edit = (id) => {
            $.ajax({
                type: "POST",
                url: "{{ route('product.edit') }}",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === 200) {
                        const product = res.data.product;
                        $('.title_edit').val(product.product_name);
                        $('.product_id').val(product.id);

                        // Categories
                        let cate_option = '<option value=""></option>';
                        res.data.categories.forEach(v => {
                            cate_option +=
                                `<option value="${v.id}" ${v.id == product.category_id ? 'selected' : ''}>${v.category_name}</option>`;
                        });
                        $('#category_edit').html(cate_option);

                        // Brands
                        let brand_option = '<option value=""></option>';
                        res.data.brands.forEach(v => {
                            brand_option +=
                                `<option value="${v.id}" ${v.id == product.brand_id ? 'selected' : ''}>${v.brand_name}</option>`;
                        });
                        $('#brand_edit').html(brand_option);

                        // Sections
                        SECTIONS_DATA = res.data.sections || [];
                        $('#sectionsWrapperEdit').empty();
                        SECTION_IDX = 0;
                        if (product.product_sections) {
                            product.product_sections.forEach(ps => {
                                addSectionBlock(false, '#sectionsWrapperEdit',
                                    '#modalUpdateProduct');
                                const $block = $('#sectionsWrapperEdit .section-block').last();
                                const $select = $block.find('.section_id');
                                refreshSectionOptions($select, '#modalUpdateProduct');
                                $select.val(ps.section_id).trigger('change');

                                if (ps.specifications) {
                                    ps.specifications.forEach(spec => {
                                        const count = $block.find('.spec-row').length;
                                        const row = `
                                    <div class="row g-2 align-items-center spec-row mb-2">
                                        <div class="col-lg-5">
                                            <label>Key</label>
                                            <input type="text" name="sections[${$block.data('sec-idx')}][specs][${count}][key]" class="form-control" value="${spec.key}" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Value</label>
                                            <input type="text" name="sections[${$block.data('sec-idx')}][specs][${count}][value]" class="form-control" value="${spec.value}" required>
                                        </div>
                                        <div class="col-lg-1 text-end">
                                            <button type="button" class="btn mt-4 btn-danger btnRemoveSpec"><i class="fa-solid fa-trash-can"></i></button>
                                        </div>
                                    </div>`;
                                        $block.find('.specsWrapper').append(row);
                                    });
                                }
                            });
                        }

                        // Display old images
                        $('.show-images-edit').empty();
                        if (product.images) {
                            product.images.forEach(img => {
                                const imgHtml = `
                                    <div class="img-wrapper position-relative">
                                        <input type="hidden" name="old_image_uploads[]" value="${img.id}">
                                        <img src="/uploads/product_image/${img.image_url}"
                                            class="img-thumbnail rounded"
                                            style="width: 80px; height: 80px; object-fit: cover;">

                                        <button type="button" class="btn btn-sm btn-danger  position-absolute top-0 end-0 btnRemoveOldImage"data-id="${img.id}">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>`;
                                $('.show-images-edit').append(imgHtml);
                            });
                        }

                        $('#modalUpdateProduct').modal('show');
                    }
                }
            });
        }

        // Function to handle removing old images
        const removeOldImage = () => {
            // Listen for click events on the remove button inside .show-images-edit
            $('.show-images-edit').on('click', '.btnRemoveOldImage', function() {
                // Option 1: Hide the image wrapper and mark it as removed
                $(this).closest('.img-wrapper').addClass('removed').hide();

                // Optionally, you can also update a hidden input for removed IDs
                // This can be read when submitting the form
                let removeIds = [];
                $('.show-images-edit .img-wrapper.removed').each(function() {
                    removeIds.push($(this).find('input[name="old_image_uploads[]"]').val());
                });
                $('#remove_image_ids_edit').val(removeIds.join(','));
            });
        }

        // Initialize the function
        removeOldImage();

        // Add Section block for edit
        function addSectionBlock(withSpec = false, wrapper = '#sectionsWrapper', modalId = '#modalCreateProduct') {
            const idx = SECTION_IDX++;
            const $wrapper = $(wrapper);

            const block = `
                <div class="card border-1 shadow-sm mb-3 section-block" data-sec-idx="${idx}">
                    <div class="col-lg-1 w-100 py-0 text-end">
                        <button type="button" class="btn btnRemoveSection border-bottom border-start">
                            <i class="fa-solid fa-trash-can text-danger"></i>
                        </button>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label>Section</label>
                                <select name="sections[${idx}][section_id]" class="form-select section_id" required></select>
                            </div>
                        </div>
                        <div class="specsWrapper"></div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2 btnAddSpec">+ Add Specification</button>
                    </div>
                </div>`;

            const $block = $(block).appendTo($wrapper);
            const $select = $block.find('.section_id');
            refreshSectionOptions($select, modalId);

            if (withSpec) addSpecRow($block);
        }

        // Refresh section dropdown
        function refreshSectionOptions($select, modalId = '#modalCreateProduct') {
            $select.empty().append('<option value="">Select Section</option>');
            SECTIONS_DATA.forEach(s => $select.append(`<option value="${s.id}">${s.name}</option>`));

            if ($select.data('select2')) $select.select2('destroy');
            $select.select2({
                placeholder: 'Select Section',
                width: '100%',
                allowClear: true,
                tags: true,
                dropdownParent: $(modalId)
            });
        }

        // Add spec row inside a section block
        function addSpecRow($block) {
            const idx = $block.data('sec-idx');
            const count = $block.find('.spec-row').length;
            const row = `
            <div class="row g-2 align-items-center spec-row mb-2">
                <div class="col-lg-5">
                    <label>Key</label>
                    <input type="text" name="sections[${idx}][specs][${count}][key]" class="form-control" placeholder="Key" required>
                </div>
                <div class="col-lg-6">
                    <label>Value</label>
                    <input type="text" name="sections[${idx}][specs][${count}][value]" class="form-control" placeholder="Value" required>
                </div>
                <div class="col-lg-1 text-end">
                    <button type="button" class="btn mt-4 btn-danger btnRemoveSpec">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>`;
            $block.find('.specsWrapper').append(row);
        }


        // Edit modal actions
        $('#sectionsWrapperEdit').on('click', '.btnAddSpec', function() {
            addSpecRow($(this).closest('.section-block'));
        });
        $('#sectionsWrapperEdit').on('click', '.btnRemoveSpec', function() {
            $(this).closest('.spec-row').remove();
        });
        $('#sectionsWrapperEdit').on('click', '.btnRemoveSection', function() {
            $(this).closest('.section-block').remove();
        });
        $('#btnAddSectionEdit').on('click', () => addSectionBlock(true, '#sectionsWrapperEdit', '#modalUpdateProduct'));

        // AJAX Update Product
        function updateProduct(formSelector) {
            let form = $(formSelector)[0];
            let data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "{{ route('product.update') }}", // Make sure your route exists
                data: data,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(res) {
                    if (res.status === 200) {
                        $(form).trigger('reset');
                        $("#modalUpdateProduct").modal('hide');
                        ProductList(); // refresh product table

                    } else {
                        alert(res.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        // Handle validation errors here
                    } else {
                        alert('Failed to update product');
                    }
                }
            });
        }

        //uploads image
        const ProductUpload = (form) => {
            let fileInput = $(form).find('.image');
            let errorMsg = fileInput.siblings("p");

            // Clear previous errors
            fileInput.removeClass("is-invalid");
            errorMsg.removeClass("text-danger").text("");

            let files = fileInput[0].files;
            if (!files.length) {
                fileInput.addClass("is-invalid");
                errorMsg.addClass("text-danger").text("Please select at least one image.");

                return;
            }

            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let allowedTypes = ['image/jpeg', 'image/jpg', , 'image/png'];
                let maxSize = 2 * 1024 * 1024; // 2MB

                if (!allowedTypes.includes(file.type)) {
                    fileInput.addClass("is-invalid");
                    errorMsg.addClass("text-danger").text("Only JPG or JPEG images are allowed.");

                    return;
                }

                if (file.size > maxSize) {
                    fileInput.addClass("is-invalid");
                    errorMsg.addClass("text-danger").text("Image size must not exceed 2MB.");

                    return;
                }
            }

            // If passed validation, proceed with AJAX upload
            let payloads = new FormData($(form)[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('product_image.uploads') }}",
                data: payloads,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == 200) {
                        let images = response.images;
                        let container = $(form).find('.show-images, .show-images-edit');
                        $.each(images, function(key, value) {
                            let img = `
                                <div class="img-wrapper position-relative">
                                    <input type="hidden" name="image_uploads[]" value="${value}">
                                    <img src="/uploads/temp/${value}" width="80" height="80"  class="img-thumbnail rounded"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                                    <button onclick="ProductCancelImage(this,'${value}')" type="button" class="btn btn-sm btn-danger  position-absolute top-0 end-0">cancel</button>
                                </div>
                            `;
                            container.append(img);
                        });
                        fileInput.val(""); // Reset file input
                    } else {
                        fileInput.addClass("is-invalid");
                        errorMsg.addClass("text-danger").text(response.message);
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    fileInput.addClass("is-invalid");
                    errorMsg.addClass("text-danger").text("Something went wrong!");
                    alert("Something went wrong!");
                }
            });
        }

        // Cancel Images Product
        const ProductCancelImage = (e, image) => {

            if (confirm("Do you want to cancel ?")) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('product_image.cancel') }}",
                    data: {
                        "image": image
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {

                            // Message(response.message);
                            $(e).parent().remove();

                        }
                    }
                });
            }

        }
    </script>
@endsection
