@extends('back_end.components.master')
@section('contents')
    <div class="row">
        {{-- Modal start --}}
        @include('back_end.page.user.create')
        {{-- Modal end --}}
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card border border-light-subtle">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Users</h5>
                        <p data-bs-toggle="modal" data-bs-target="#modalCreateUser"
                            class="card-description btn btn-info text-white">
                            <i class="fa-solid fa-circle-plus" style="font-size:14px"></i>
                            Add User
                        </p>
                    </div>
                    <div class="table-responsive-lg">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>USER NAME</th>
                                    <th>EMAIL</th>
                                    <th>ROLE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="users_list">
                                {{-- Dynamic data will be inserted here --}}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const UserList = () => {

            $(".users_list").html(`
        <tr>
          <td colspan="5" class="text-center">
            <div class="spinner-border text-primary" role="status">  
            </div>
          </td>
        </tr>
      `);

            $.ajax({
                type: "POST",
                url: "{{ route('user.list') }}",
                dataType: "json",
                success: function(response) {
                    if (response.status === 200) {
                        let users = response.users;
                        let tr = '';
                        $.each(users, function(key, value) {
                            tr += `
                    <tr>
                      <td>${value.id}</td>
                      <td>${value.name}</td>
                      <td>${value.email}</td>
                      <td>${ (value.role == 1) ? 'Admin' : 'User' }</td>
                      <td>
                        <a href="javascript:void()" onclick="DeleteUser(${value.id})" class="btn btn-sm border border-light-subtle text-danger bg-transparent"><i class="fa-solid fa-trash-can"></i></a>
                      </td>
                    </tr>
                  `;
                        });
                        $(".users_list").html(tr);
                    } else {
                        $(".users_list").html(
                            '<tr><td colspan="5" class="text-center text-danger">No users found.</td></tr>'
                            );
                    }
                },
                error: function() {
                    // In case of an error, show a failure message
                    $(".users_list").html(
                        '<tr><td colspan="5" class="text-center text-danger">Failed to load data.</td></tr>'
                        );
                }
            });
        }

        // Initialize user list on page load
        UserList();

        // Function to store users
        const StoreUser = (form) => {
            let payloads = new FormData($(form)[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('user.store') }}",
                data: payloads,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 200) {
                        $("#modalCreateUser").modal("hide");
                        $("input").removeClass("is-invalid").siblings("p").removeClass("text-danger").text(
                            "");
                        $(form).trigger("reset");

                        UserList();
                        Message(response.message);
                    } else {
                        let errors = response.errors;

                        if (errors.name) {
                            $(".name").addClass('is-invalid').siblings('p').addClass("text-danger").text(
                                errors.name);
                        } else {
                            $(".name").removeClass('is-invalid').siblings('p').removeClass("text-danger")
                                .text("");
                        }

                        if (errors.email) {
                            $(".email").addClass('is-invalid').siblings('p').addClass("text-danger").text(
                                errors.email);
                        } else {
                            $(".email").removeClass('is-invalid').siblings('p').removeClass("text-danger")
                                .text("");
                        }

                        if (errors.password) {
                            $(".password").addClass('is-invalid').siblings('p').addClass("text-danger")
                                .text(errors.password);
                        } else {
                            $(".password").removeClass('is-invalid').siblings('p').removeClass(
                                "text-danger").text("");
                        }
                    }
                }
            });
        }

        // Function to delete users
        const DeleteUser = (id) => {
            if (confirm("Do you want to delete this user?")) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.destroy') }}",
                    data: {
                        "id": id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            UserList();
                            Message(response.message);
                        } else {
                            Message(response.message);
                        }
                    }
                });
            }
        }
    </script>
@endsection
