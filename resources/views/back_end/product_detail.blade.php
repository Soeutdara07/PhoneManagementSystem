@extends('back_end.components.master')
@section('contents')
    {{-- Modal create start --}}
    @include('back_end.page.product_detail.create')
    {{-- Modal create end --}}

    {{-- Modal edit start --}}
    @include('back_end.page.product_detail.edit')
    {{-- Modal edit start --}}



    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Product Detail</h5>
                    <p onclick="handleClickOnButtonNewProduct()" data-bs-toggle="modal"
                        data-bs-target="#modalCreateProduct_Detail" class="card-description btn btn-info text-light">
                        <i class="fa-solid fa-circle-plus" style="font-size:14px"></i>
                        Add Detail
                    </p>
                </div>
                <div class="table-responsive">
                    <table class="table mb-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Supplier</th>
                                <th>Indentifier</th>
                                <th>Condition</th>
                                <th>Description</th>
                                <th>Color</th>
                                <th>Cost</th>
                                <th>Sale Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody class="products_detail_list">

                        </tbody>

                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center">

                    <div class="show-page mt-3">

                    </div>

                    <button onclick="ProductRefresh()" class=" btn btn-outline-danger rounded-0 btn-sm">refresh</button>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
       $(document).ready(function() {

    // function init select2 for specific modal
    function initSelect2InModal(modalId) {
        $(modalId).on('shown.bs.modal', function() {
            $(this).find('.select2').select2({
                width: '100%',
                placeholder: 'Select option',
                allowClear: true,
                tags: true,
                dropdownParent: $(modalId)
            });
        });
    }

    // call for create modal
    initSelect2InModal('#modalCreateProduct');

    // call for edit modal
    initSelect2InModal('#modalUpdateProduct_Detail');
});


        // Product Detail List
        const ProductDetailList = (page = 1, search = null) => {

            $(".products_list").html(`
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="spinner-border text-primary" role="status"></div>
                        </td>
                    </tr>
                `);

            $.ajax({
                type: "POST",
                url: "{{ route('product_detail.list') }}",
                data: {
                    'page': page,
                    'search': search,
                    '_token': "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        let productDetails = response.product_details;
                        let tr = '';
                        $.each(productDetails, function(key, value) {

                            tr += `
                        <tr>
                            <td>PD${value.id}</td>
                            <td>
                                <img src="${value.images && value.images.length > 0
                                    ? '/uploads/product_image/' + value.images[0]
                                    : '/uploads/product_image/default.png'}"
                                    width="50" height="50" class="rounded me-2"/>
                            </td>
                            <td>${value.product ?? '-'}</td>
                            <td>${value.supplier ?? '-'}</td>
                            <td>${value.product_identifier}</td>
                            <td>${value.condition}</td>
                            <td>${value.description ?? '-'}</td>
                            <td>${value.color ?? '-'}</td>
                            <td>${value.cost}</td>
                            <td>${value.sale_price}</td>


                            <td><span class="${(value.sold_status == 1) ? 'badge bg-success' : 'badge bg-danger'}">
                                ${(value.status == 1) ? 'Active' : 'Inactive'}
                                 </span>
                            </td>

                            <td>
                                    <button data-bs-toggle="modal" data-bs-target="#modalUpdateProductDetail" type="button" onclick="Product_Detail_Edit(${value.id})" class="btn btn-sm border border-light-subtle text-info bg-transparent"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button type="button" onclick="ProductDetailDelete(${value.id})" class="btn btn-sm border border-light-subtle text-danger bg-transparent"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                    `;
                        });

                        $(".products_detail_list").html(tr);

                        // pagination
                        let pageHtml = ``;
                        let totalPage = response.page.totalPage;
                        let currentPage = response.page.currentPage;

                        pageHtml = `
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li onclick="PreviousPage(${currentPage})" class="page-item ${(currentPage == 1) ? 'd-none' : ''}">
                                        <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>`;

                        for (let i = 1; i <= totalPage; i++) {
                            pageHtml += `
                                <li onclick="ProductDetailPage(${i})" class="shadow-none page-item ${(i == currentPage) ? 'active' : ''}">
                                    <a class="page-link" href="javascript:void(0)">${i}</a>
                                </li>`;
                        }

                        pageHtml += `
                                <li onclick="NextPage(${currentPage})" class="page-item ${(currentPage == totalPage) ? 'd-none' : ''}">
                                    <a class="page-link" href="javascript:void(0)" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                </ul>
                            </nav>
                        `;

                        if (totalPage > 1) {
                            $(".show-page").html(pageHtml);
                        } else {
                            $('.show-page').html('');
                        }

                    } else {
                        $(".products_detail_list").html(
                            '<tr><td colspan="10" class="text-center text-danger">No Product Detail found.</td></tr>'
                        );
                    }
                },
                error: function() {
                    $(".products_detail_list").html(
                        '<tr><td colspan="10" class="text-center text-danger">Failed to load data.</td></tr>'
                    );
                }
            });
        }

        // load first page
        ProductDetailList();

        const handleClickOnButtonNewProduct = () => {
            $.ajax({
                type: "POST",
                url: "{{ route('product_detail.data') }}",
                dataType: "json",
                success: function(response) {
                    if (response.status === 200) {

                        //Categories start
                        let products = response.data.products;
                        let pro_option = `<option value=""></option>`;
                        $.each(products, function(key, value) {
                            pro_option += `
                            <option value="${value.id}">${value.product_name}</option>
                        `;
                        });

                        $('.product_add').html(pro_option);
                        //Categories end

                        //Brands Start
                        let suppliers = response.data.suppliers;
                        let supplier_option = `<option value=""></option>`;
                        $.each(suppliers, function(key, value) {
                            supplier_option += `
                            <option value="${value.id}">${value.supplier_name}</option>
                        `;
                        });
                        $('.supplier_add').html(supplier_option);
                        //Brands end

                        //Colors Start
                        let colors = response.data.colors;
                        let color_option = `<option value=""></option>`;
                        $.each(colors, function(key, value) {
                            color_option += `
                            <option value="${value.id}">${value.name}</option>
                        `;
                        });

                        $('.color_add').html(color_option);





                        //Colors end
                    }
                }
            });
        }

        //Brand Refresh page
        const ProductRefresh = () => {
            ProductList();
            $("#searchBox").val(" ");
        }


        //Color Page
        const ProductPage = (page) => {
            ProductList(page);
        }


        //Next Page
        const NextPage = (page) => {
            ProductList(page + 1);
        }


        //Previous Page
        const PreviousPage = (page) => {
            ProductList(page - 1);
        }

        //   Stat Function Store Prodcut Detail

        const Product_Detail_Store = (form) => {
            let payloads = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('product_detail.store') }}",
                data: payloads,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == 200) {
                        $(form).trigger("reset");
                        $('.show-images').html(" ");
                        $("#modalCreateProduct_Detail").modal('hide');
                        $('input').removeClass("is-invalid").siblings("p").removeClass('text-danger').text(
                            " ")

                        ProductDetailList();

                    } else {

                        let error = response.errors;

                        $(".product_add").addClass("is-invalid").siblings("p").addClass("text-danger").text(
                            error
                            .product_id);

                        $(".supplier_add").addClass("is-invalid").siblings("p").addClass("text-danger")
                            .text(error
                                .supplier_id);


                        $(".cost_add").addClass("is-invalid").siblings("p").addClass("text-danger").text(
                            error.cost);

                        $(".sale_price_add").addClass("is-invalid").siblings("p").addClass("text-danger")
                            .text(error.sale_price);

                        $(".product_indentifier_add").addClass("is-invalid").siblings("p").addClass(
                            "text-danger").text(error.product_identifier);

                        $(".color_add").addClass("is-invalid").siblings("p").addClass("text-danger").text(
                            error.color_id);

                        $(".condition_add").addClass("is-invalid").siblings("p").addClass("text-danger")
                            .text(error.condition);

                    }
                }
            });
        }

        //product_detial_edit
        const Product_Detail_Edit = (id) => {
            $.ajax({
                type: "POST",
                url: "{{ route('product_detail.edit') }}",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        const detail = response.data.detail;
                        const products = response.data.products;
                        const suppliers = response.data.suppliers;
                        const colors = response.data.colors;

                        // fill input fields
                        $('.product_detail_id').val(detail.id);
                        $("#edit_cost").val(detail.cost);
                        $("#edit_sale_price").val(detail.sale_price);
                        $("#edit_product_identifier").val(detail.product_identifier);
                        $("#edit_desc").val(detail.product_description);
                        $("#edit_condition").val(detail.condition);
                        $("#edit_status").val(detail.sold_status);

                        // fill selects
                        fillSelectOptions(products, detail.product_id, '#edit_product_id', 'product_name');
                        fillSelectOptions(suppliers, detail.supplier_id, '#edit_supplier_id',
                            'supplier_name');
                        fillSelectOptions(colors, detail.color_id, '#edit_color_id',
                            'name'); // <--- key fix

                        // open modal
                        $("#modalUpdateProduct_Detail").modal('show');
                    } else {
                        alert(response.message || 'Failed to fetch data.');
                    }
                },
                error: function(err) {
                    console.error(err);
                }
            });
        };

        const fillSelectOptions = (items, selectedId, selectId, textField) => {
            // textField: the property to display in the option (e.g., 'product_name', 'supplier_name', 'color_name')
            let options = '<option value=""></option>';
            items.forEach(v => {
                const text = v[textField] || ''; // fallback to empty string
                options += `<option value="${v.id}" ${v.id == selectedId ? 'selected' : ''}>${text}</option>`;
            });
            $(selectId).html(options).trigger('change');
        };

        //update product detail
        const Product_Detail_Update = (form) => {
            let payloads = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('product_detail.update') }}",
                data: payloads,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 200) {
                        $("#modalUpdateProduct_Detail").modal("hide");
                        $(form).trigger('reset');
                        $(form).removeClass("is-invalid").siblings("p").removeClass("text-danger").text("");
                        ProductDetailList();
                        Message(response.message, response.status);
                    } else {
                        let error = response.errors;
                        if (error.cost) {
                            $(".cost_edit")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("text-danger")
                                .text(error.cost);
                        }
                        if (error.sale_price) {
                            $(".sale_price_edit")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("text-danger")
                                .text(error.sale_price);
                        }
                         if (error.condition) {
                            $(".condition_edit")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("text-danger")
                                .text(error.condition);
                        }
                         if (error.product_identifier) {
                            $(".product_indentifier_edit")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("text-danger")
                                .text(error.product_identifier);
                        }
                    }
                }
            });
        }
    </script>
@endsection
