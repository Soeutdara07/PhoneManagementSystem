@extends('back_end.components.master')
@section('contents')
    {{-- Modal create start --}}
    @include('back_end.page.puchases.create')
    {{-- Modal create end --}}

    {{-- Modal edit start --}}
    @include('back_end.page.puchases.edit')
    {{-- Modal edit start --}}



    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Purchase</h5>   
                    <p onclick="handleClickOnButtonNewPurchases()" data-bs-toggle="modal"
                        data-bs-target="#modalCreate_Puchases" class="card-description btn btn-info text-light "><i class="fa-solid fa-circle-plus" style="font-size:14px"></i>Add purchase</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped mb-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Description</th>

                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody class="products_list">

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

        // // Product Rendering
        // const ProductList = (page = 1, search = null) => {

        //     $(".products_list").html(`
    //         <tr>
    //             <td colspan="5" class="text-center">
    //                 <div class="spinner-border text-primary" role="status">hello</div>
    //             </td>
    //         </tr>
    //     `);

        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('product.list') }}",
        //         data: {
        //             'page': page,
        //             'search': search
        //         },
        //         dataType: "json",
        //         success: function(response) {
        //             if (response.status == 200) {
        //                 let products = response.products;
        //                 let tr = '';
        //                 $.each(products, function(key, value) {
        //                     tr += `
    //                         <tr>
    //                             <td>P${value.id}</td>
    //                             <td>
    //                             `;
        //                                     if (value.images.length > 0) {
        //                                         tr +=
        //                                             `<img  src='{{ asset('uploads/product/${value.images[0].image}') }}'/>`;
        //                                     }
        //                                     tr += ` 
    //                             </td>
    //                             <td>${value.name}</td>
    //                             <td>${value.categories.name}</td>
    //                             <td>${value.brands.name}</td>
    //                             <td>$${value.price}</td>
    //                             <td>${value.qty}</td>
    //                             <td>
    //                             <span class='text-light p-1 badge ${value.qty > 1 ? 'bg-success' : 'bg-danger'}'>
    //                                 ${value.qty > 1? 'In Stock' : 'Out Stock' }
    //                             </span> 
    //                         </td>
    //                             <td>
    //                                 <span class="text-light badge ${(value.status == 1)  ? 'bg-success' : 'bg-danger' }  p-1">
    //                                 ${(value.status == 1) ? 'Active' : 'Inactive' }
    //                                 </span>
    //                             </td>
    //                             <td>
    //                                 <button onclick="edit(${value.id})" type="button" class=" btn btn-info  btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdateProduct">Edit</button>
    //                                 <button onclick="ProductDelete(${value.id})" type="button" class="btn btn-danger btn-sm">Delete</button>
    //                             </td>
    //                         </tr>
    //                     `;
        //                 })

        //                 $(".products_list").html(tr);

        //                 //pagination
        //                 let page = ``;
        //                 let totalPage = response.page.totalPage;
        //                 let currentPage = response.page.currentPage;
        //                 page = `
    //                     <nav aria-label="Page navigation example">
    //                         <ul class="pagination">
    //                             <li onclick="PreviousPage(${currentPage})" class="page-item ${(currentPage == 1) ? 'd-none' : 'd-block' }">
    //                             <a class="page-link" href="javascript:void()" aria-label="Previous">
    //                                 <span aria-hidden="true">&laquo;</span>
    //                             </a>
    //                             </li>`;

        //                             for (let i = 1; i <= totalPage; i++) {
        //                                 page += `
    //                                     <li onclick="ProductPage(${i})" class="shadow-none page-item ${(i == currentPage) ? 'active' : '' }">
    //                                         <a class="page-link" href="javascript:void()">${i}</a>
    //                                     </li>`;
        //                             }

        //                             page += `<li onclick="NextPage(${currentPage})" class="page-item ${( currentPage == totalPage ) ? 'd-none' : 'd-block'}">
    //                             <a class="page-link" href="javascript:void()" aria-label="Next">
    //                                 <span aria-hidden="true">&raquo;</span>
    //                             </a>
    //                             </li>
    //                         </ul>
    //                     </nav>
    //                 `;

        //                 if (totalPage > 1) {
        //                     $(".show-page").html(page);
        //                 } else {
        //                     $('.show-page').html('');
        //                 }


        //             }else{
        //                 $(".products_list").html('<tr><td colspan="5" class="text-center text-danger">No Product found.</td></tr>'); 
        //             }
        //         },
        //         error: function() {
        //             $(".products_list").html('<tr><td colspan="5" class="text-center text-danger">Failed to load data.</td></tr>');
        //         }
        //     });



        // }

        // ProductList();


        // //search event 
        // $(document).on("click", '.searchBtn', function() {
        //     let searchValue = $("#searchBox").val();
        //     ProductList(1, searchValue);

        //     //close modal
        //     $("#modalSearch").modal('hide');
        // });

      const handleClickOnButtonNewPurchases = () => {
    $.ajax({
        type: "POST",
        url: "{{ route('purchases.data') }}",
        dataType: "json",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.status === 200) {
                let product_details = response.data.product_details;

                if (product_details.length > 0) {
                    let firstProduct = product_details[0];

                    // Set product name in the textbox
                    $('#product_name').val(`${firstProduct.product.product_name} (${firstProduct.product_identifier})`);

                    // Store the product_detail.id in the hidden input
                    $('#product_detail_id_hidden').val(firstProduct.id);
                } else {
                    $('#product_name').val('No product available');
                    $('#product_detail_id_hidden').val('');
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
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

        const Purchase_Store = (form) => {
            let payloads = new FormData($(form)[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('purchases.store') }}",
                data: payloads,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == 200) {
                        $(form).trigger("reset");
                        $("#modalCreate_Puchases").modal('hide');
                        $('input').removeClass("is-invalid").siblings("p").removeClass('text-danger').text(" ")
                        ProductList();

                    } else {
                        // Message(response.message, false);

                        // if (response.errors.title) {
                        //     $('.title_add').addClass("is-invalid").siblings("p").addClass('text-danger')
                        //         .text(response.errors.title)
                        // } else {
                        //     $('.title_add').removeClass("is-invalid").siblings("p").removeClass(
                        //         'text-danger').text("")
                        // }

                        // if (response.errors.price) {
                        //     $('.price_add').addClass("is-invalid").siblings("p").addClass('text-danger')
                        //         .text(response.errors.price)
                        // } else {
                        //     $('.price_add').removeClass("is-invalid").siblings("p").removeClass(
                        //         'text-danger').text("")

                        // }

                        // if (response.errors.qty) {
                        //     $('.qty_add').addClass("is-invalid").siblings("p").addClass('text-danger').text(
                        //         response.errors.qty)
                        // } else {
                        //     $('.qty_add').removeClass("is-invalid").siblings("p").removeClass('text-danger')
                        //         .text("")
                        // }
                    }
                }
            });
        }
    </script>
@endsection
