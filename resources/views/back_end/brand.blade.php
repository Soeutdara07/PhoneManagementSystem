@extends('back_end.components.master')
@section('contents')
    {{-- Modal create start --}}
    @include('back_end.page.brand.create')
    {{-- Modal create end --}}

    {{-- Modal edit start --}}
    @include('back_end.page.brand.edit')
    {{-- Modal edit end --}}

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card border border-light-subtle">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Brands</h5>
                    <p data-bs-toggle="modal" data-bs-target="#modalCreateBrand"
                        class="card-description btn btn-info text-white ">
                        <i class="fa-solid fa-circle-plus" style="font-size:14px"></i>
                        Add Brand
                    </p>
                </div>
                <div class="table-responsive-lg">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Brand ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Actionss</th>
                            </tr>
                        </thead>
                        <tbody class="brand_list">

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
        const Brandlist = (page = 1, search = '') => {
            $.ajax({
                type: "POST",
                url: "{{ route('brand.list') }}",
                data: {
                    "page": page,
                    "search": search,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === 200) {
                        let brands = response.brands;
                        let tr = ``;
                        $.each(brands, function(key, value) {
                            tr += `
                        <tr>
                            <td>B${value.id}</td>
                            <td>${value.brand_name}</td>
                            <td>
                                ${(value.status == 1) ? '<span class="text-success rounded-5 px-2 ">active</span>'
                                : ' <span class="text-danger rounded-5  px-2">Inactive</span>' }
                            </td>
                            <td>
                                <button data-bs-toggle="modal" data-bs-target="#modalUpdateBrand" type="button" onclick="BrandEdit(${value.id})" class="btn btn-sm border border-light-subtle text-info bg-transparent"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button type="button" onclick="BrandDelete(${value.id})" class="btn btn-sm border border-light-subtle text-danger bg-transparent"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                        `;
                        });

                        $(".brand_list").html(tr);

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
            Brandlist();
        });

        //Brand Refresh page
        const ButtonRefresh = () => {
            $("#searchBox").val("");
            $("#refresh-button-container").hide();
            Brandlist();
        }


        //search event
        $(document).on("click", '.searchBtn', function() {
            let searchValue = $("#searchBox").val();
            Brandlist(1, searchValue);

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
            Brandlist(page);
        }

        //Previous Page
        const NextPage = (page) => {
            Brandlist(page + 1);
        }

        //Previous Page
        const PreviousPage = (page) => {
            Brandlist(page - 1);
        }




        const BrandStore = (form) => {
            let payloads = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('brand.store') }}",
                data: payloads,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 200) {
                        $("#modalCreateBrand").modal("hide");
                        $(form).trigger('reset');
                        $(".brand_name").removeClass("is-invalid").siblings("p").removeClass("text-danger").text(
                            " ");
                        Brandlist();
                        Message(response.message);

                    } else {
                        let error = response.error;
                        $(".brand_name").addClass("is-invalid").siblings("p").addClass("text-danger").text(error
                            .brand_name);
                    }
                }
            });
        }

        //Brand Edit
        const BrandEdit = (id) => {
            $.ajax({
                type: "POST",
                url: "{{ route('brand.edit') }}",
                data: {
                    "id": id
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === 200) {
                        $(".brand_name_edit").val(response.brands.brand_name);
                        $(".status_edit").val(response.brands.status);
                        $("#brand_id").val(response.brands.id);
                    }
                }
            });
        }


        //Brand Update
        const BrandUpdate = (form) => {
            let payloads = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('brand.update') }}",
                data: payloads,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 200) {
                        $("#modalUpdateBrand").modal("hide");
                        $(form).trigger('reset');
                        $(".brand_name_edit").removeClass("is-invalid").siblings("p").removeClass("text-danger")
                            .text(
                                " ");
                        Brandlist();
                        Message(response.message);
                    }else if(response.status === 404){
                         Message(response.message);
                    }
                    else {
                        let error = response.error;
                        $(".brand_name_edit").addClass("is-invalid").siblings("p").addClass("text-danger").text(
                            error.brand_name);
                    }
                }
            });
        }


        //Brand Delete
        const BrandDelete = (id) => {
            if (confirm("Do you want to delete this ?")) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('brand.destroy') }}",
                    data: {
                        "id": id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 200) {
                            Brandlist();
                        }
                    }
                });
            }
        }
    </script>
@endsection
