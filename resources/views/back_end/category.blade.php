@extends('back_end.components.master')
@section('contents')
    {{-- Modal create start --}}
    @include('back_end.page.category.create')
    {{-- Modal create end --}}

    {{-- Modal edit start --}}
    @include('back_end.page.category.edit')
    {{-- Modal edit start --}}

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card border border-light-subtle">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Category</h5>
                    <p data-bs-toggle="modal" data-bs-target="#modalCreateCategory" class="card-description btn btn-info text-light ">
                       <i class="fa-solid fa-circle-plus" style="font-size:14px"></i>
                        Add Category
                    </p>
                </div>
                <div class="table-responsive-lg">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="category_list">

                        </tbody>

                    </table>
                </div>
                {{-- page and refresh --}}
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
        const CategoryList = (page = 1, search = '') => {
            $.ajax({
                type: "POST",
                url: "{{ route('category.list') }}",
                 data: {
                    "page": page,
                    "search": search,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === 200) {
                        let categories = response.categories;
                        console.log(categories)
                        let tr = ``;
                        $.each(categories, function(key, value) {
                            tr += `
                             <tr>
                                <td>C00${value.id}</td>
                
                                <td>${value.category_name}</td>
                                <td>
                                    ${ (value.status == 1) ? '<span class="bg-success text-light px-1 rounded-1">active</span>' : 
                                                              '<span class="bg-danger text-light px-1 rounded-1">Inactive</span>'
                                    }
                                </td>
                                <td>
                                    <button data-bs-toggle="modal" data-bs-target="#modalUpdateCategory" type="button" onclick="CategoryEdit(${value.id})" class="btn btn-sm border border-light-subtle text-info bg-transparent"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button type="button" onclick="CategoryDestory(${value.id})" class="btn btn-sm border border-light-subtle text-danger bg-transparent"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                             </tr>
                            `;
                        });
                        $(".category_list").html(tr);

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
            CategoryList();
        });

        //Brand Refresh page
        const ButtonRefresh = () => {
            $("#searchBox").val("");
            $("#refresh-button-container").hide();
            CategoryList();
        }


        //search event 
        $(document).on("click", '.searchBtn', function() {
            let searchValue = $("#searchBox").val();
            CategoryList(1, searchValue);

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
            CategoryList(page);
        }

        //Previous Page
        const NextPage = (page) => {
            CategoryList(page + 1);
        }

        //Previous Page
        const PreviousPage = (page) => {
           CategoryList(page - 1);
        }



        const CategoryEdit = (id) => {
            $.ajax({
                type: "POST",
                url: "{{ route('category.edit') }}",
                data: {
                    "id": id
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === 200) {
                        $(".category_name_edit").val(response.category.category_name);
                        $(".status_edit").val(response.category.status);
                        $("#category_id").val(response.category.id);
                        // $(".show-image-category-edit").html(" ");
                        // if(response.category.image != null){
                        //     let img = `
                    //        <input type="hidden" name="cate_old_image" value="${response.category.image}">
                    //        <img style="width:400px;" src="{{ asset('uploads/category/${response.category.image}') }}">
                    //     `;
                        //     $(".show-image-category-edit").html(img);

                        // }
                    }
                }
            });
        }

        const StoreCategory = (form) => {
            let payloads = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('category.store') }}",
                data: payloads,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 200) {
                        $("#modalCreateCategory").modal("hide");
                        $(form).trigger("reset");
                        $(".category_name").removeClass("is-invalid").siblings("p").removeClass("text-danger").text(
                            "")

                        CategoryList();
                        Message(response.message);

                    } else {
                        $(".category_name").addClass("is-invalid").siblings("p").addClass("text-danger").text(
                            response.error.category_name);
                    }
                }
            });
        }

        const UpdateCategory = (form) => {
            let payloads = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('category.update') }}",
                data: payloads,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == 200) {
                        $("#modalUpdateCategory").modal("hide");
                        $(form).trigger("reset");
                        $(".category_name_edit").removeClass("is-invalid").siblings("p").removeClass("text-danger").text(
                            "")
                        CategoryList();

                    } else {
                        $(".category_name_edit").addClass("is-invalid").siblings("p").addClass("text-danger").text(
                            response.error.category_name);
                    }
                }
            });
        }   

        const CategoryDestory = (id) => {
            if (confirm("Do you want to delete this ?")) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('category.destroy') }}",
                    data: {
                        "id": id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            CategoryList();
                            Message(response.message);
                        }
                    }
                });
            }
        }
    </script>
@endsection
