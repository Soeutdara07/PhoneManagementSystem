@extends('back_end.components.master')
@section('contents')
    {{-- Modal create start --}}
    @include('back_end.page.supplier.create')
    {{-- Modal create end --}}

    {{-- Modal edit start --}}
    @include('back_end.page.supplier.edit')
    {{-- Modal edit start --}}

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card border border-light-subtle">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Supplier</h5>
                    <p data-bs-toggle="modal" data-bs-target="#modalCreateSupplier" class="card-description btn btn-info text-light">
                        <i class="fa-solid fa-circle-plus" style="font-size:14px"></i>
                        Add Supplier</p>
                </div>
                <div class="table-responsive-lg">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Supplier Name</th>
                                    <th>Type</th>
                                    <th>Address</th>
                                    <th>Contect</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="supplier_list">

                            </tbody>
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
        const SupplierList = (page = 1, search = '') => {
            $.ajax({
                type: "POST",
                url: "{{ route('supplier.list') }}",
                data: {
                    "page": page,
                    "search": search,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {    
                    if (response.status === 200) {
                        let suppliers = response.suppliers;

                        let tr = ``;
                        $.each(suppliers, function(key, value) {
                            tr += `
                             <tr>
                                <td>S00${value.id}</td>
                                <td>${value.supplier_name}</td>
                                <td>${value.type}</td>
                                <td>${value.address}</td>
                                <td>${value.contact_info}</td>

                                <td>
                                    <button data-bs-toggle="modal" data-bs-target="#modalUpdateSupplier" type="button" onclick="SupplierEdit(${value.id})" class="btn btn-sm border border-light-subtle text-info bg-transparent"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button type="button" onclick="SupplierDestroy(${value.id})" class="btn btn-sm border border-light-subtle text-danger bg-transparent"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                             </tr>
                            `;
                        });
                        $(".supplier_list").html(tr);


                         //pagination
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
                        }

                    }
                }
            });
        }

      
        $(document).ready(function() {
            SupplierList();
        });

        //Brand Refresh page
        const ButtonRefresh = () => {
            $("#searchBox").val("");
            $("#refresh-button-container").hide();
           SupplierList();
        }


        //search event 
        $(document).on("click", '.searchBtn', function() {
            let searchValue = $("#searchBox").val();
            SupplierList(1, searchValue);

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
            SupplierList(page);
        }

        //Previous Page
        const NextPage = (page) => {
            SupplierList(page + 1);
        }

        //Previous Page
        const PreviousPage = (page) => {
            SupplierList(page - 1);
        }

       

        const StoreSupplier = (form) => {
            let payloads = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('supplier.store') }}",
                data: payloads,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 200) {
                        $("#modalCreateSupplier").modal("hide");
                        $(form).trigger("reset");
                        $(".name").removeClass("is-invalid").siblings("p").removeClass("text-danger").text(
                            "")

                        SupplierList();
                        Message(response.message);

                    } else {
                        $(".name").addClass("is-invalid").siblings("p").addClass("text-danger").text(
                            response.error.name);
                    }
                }
            });
        }

        const SupplierEdit = (id) => {
            $.ajax({
                type: "POST",
                url: "{{ route('supplier.edit') }}",
                data: {
                    "id": id
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === 200) {
                        $(".name_edit").val(response.supplier.name);
                        $("#supplier_id").val(response.supplier.id);
                        $(".type_edit").val(response.supplier.type);
                        $(".address_edit").val(response.supplier.address);
                        $(".contact_info_edit").val(response.supplier.contact_info);
                    }
                }
            });
        }

        const UpdateSupplier = (form) => {
            let payloads = new FormData($(form)[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('supplier.update') }}",
                data: payloads,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 200) {
                        $("#modalUpdateSupplier").modal("hide");
                        $(form).trigger("reset");
                        $(".name_edit").removeClass("is-invalid").siblings("p").removeClass("text-danger")
                            .text("");
                        SupplierList(); // ✅ Correct function to reload table
                        Message(response.message);
                    } else {
                        $(".name_edit").addClass("is-invalid").siblings("p").addClass("text-danger").text(
                            response.error.name);
                    }
                }
            });
        }

        const SupplierDestroy = (id) => {
            if (confirm("Do you want to delete this ?")) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('supplier.destroy') }}",
                    data: {
                        "id": id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 200) {
                            SupplierList();
                            Message(response.message);
                        }
                    }
                });
            }
        }
    </script>
@endsection
