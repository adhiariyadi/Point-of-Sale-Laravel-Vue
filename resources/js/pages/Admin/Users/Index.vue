<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="page-title m-0">Users</h4>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end page-title-box -->
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-8">
                                <h4 class="mt-0 header-title">
                                    List All User
                                </h4>
                            </div>
                            <div class="col-4">
                                <div class="float-right d-none d-md-block">
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-primary"
                                            type="button"
                                            data-toggle="modal"
                                            data-target="#modalAdd"
                                        >
                                            <i class="ti-plus mr-1"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-md-8 col-md-4 col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span
                                            class="input-group-text"
                                            id="basic-addon1"
                                            ><i class="fas fa-search"></i
                                        ></span>
                                    </div>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Cari Nama/Email Pengguna"
                                        aria-describedby="basic-addon1"
                                        v-model="search"
                                        @keyup="searchData"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table
                                class="table table-hover table-lg"
                                id="category-table"
                            >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No telepon</th>
                                        <th>Level</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="data in users"
                                        v-bind:key="data.id"
                                    >
                                        <td>{{ data.id }}</td>
                                        <td>
                                            <img
                                                :src="`${data.image}`"
                                                class="image-table-users"
                                            />
                                            {{ data.name }}
                                        </td>
                                        <td>{{ data.email }}</td>
                                        <td>{{ data.phone }}</td>
                                        <td>
                                            <div
                                                class="badge badge-primary"
                                                v-if="data.level == 'Admin'"
                                            >
                                                {{ data.level }}
                                            </div>
                                            <div
                                                class="badge badge-secondary"
                                                v-if="data.level == 'Kasir'"
                                            >
                                                {{ data.level }}
                                            </div>
                                        </td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn btn-primary"
                                                @click="detailUser(data.id)"
                                            >
                                                Detail
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-warning"
                                                @click="editUser(data.id)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                type="button"
                                                @click="deleteUser(data.id)"
                                                class="btn btn-danger"
                                            >
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav
                            aria-label="Page navigation example"
                            class="float-right"
                        >
                            <ul class="pagination">
                                <li class="page-item">
                                    <button
                                        class="page-link"
                                        href="#"
                                        v-if="
                                            this.current_page !==
                                                this.first_page
                                        "
                                        @click="prevPage"
                                    >
                                        Previous
                                    </button>
                                </li>
                                <li class="page-item">
                                    <button class="page-link" href="#">
                                        {{ this.current_page }}
                                    </button>
                                </li>
                                <li class="page-item">
                                    <button
                                        class="page-link"
                                        href="#"
                                        @click="nextPage"
                                        v-if="
                                            this.current_page !== this.last_page
                                        "
                                    >
                                        Next
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Modal -->
        <div
            class="modal fade"
            id="modalAdd"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Add User
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Tutup"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form
                        action=""
                        method="POST"
                        enctype="multipart/form-data"
                        @submit.prevent="addUser"
                    >
                        <div class="modal-body">
                            <div class="alert alert-danger" v-if="errors != ''">
                                <ul>
                                    <li
                                        v-for="error in errors"
                                        v-bind:key="error.id"
                                    >
                                        {{ error[0] }}
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap: </label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    v-model="add.name"
                                />
                            </div>
                            <div class="form-group">
                                <label>Username: </label>
                                <input
                                    type="text"
                                    name="username"
                                    class="form-control"
                                    v-model="add.username"
                                />
                            </div>
                            <div class="form-group">
                                <label>Email: </label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    v-model="add.email"
                                />
                            </div>
                            <div class="form-group">
                                <label>Password: </label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    v-model="add.password"
                                />
                            </div>
                            <div class="form-group">
                                <label>Nomor Telepon: </label>
                                <input
                                    type="tel"
                                    name="phone"
                                    class="form-control"
                                    v-model="add.phone"
                                />
                            </div>
                            <div class="form-group">
                                <label>Alamat: </label>
                                <textarea
                                    name="address"
                                    class="form-control"
                                    v-model="add.address"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label>Level User: </label>
                                <select
                                    name="level"
                                    v-model="add.level"
                                    class="form-control"
                                >
                                    <option value="">Pilih salah satu..</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Kasir">Kasir</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Foto: </label>
                                <input
                                    type="file"
                                    name="file"
                                    class="form-control-file"
                                    accept="image/*"
                                    @change="onChangePhotoAdd"
                                />
                                <img
                                    :src="`${add.image}`"
                                    class="image-table"
                                    id="add-category-image"
                                />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                                :disabled="addLoading == true"
                            >
                                <span
                                    class="spinner-border spinner-border-sm"
                                    role="status"
                                    aria-hidden="true"
                                    v-if="addLoading == true"
                                ></span>
                                Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Modal -->
        <div
            class="modal fade"
            id="modalEdit"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Edit User
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Tutup"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form
                        action=""
                        method="POST"
                        enctype="multipart/form-data"
                        @submit.prevent="updateUser"
                    >
                        <div class="modal-body">
                            <div class="alert alert-danger" v-if="errors != ''">
                                <ul>
                                    <li
                                        v-for="error in errors"
                                        v-bind:key="error.id"
                                    >
                                        {{ error[0] }}
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap: </label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    v-model="edit.name"
                                />
                            </div>
                            <div class="form-group">
                                <label>Username: </label>
                                <input
                                    type="text"
                                    name="username"
                                    class="form-control"
                                    v-model="edit.username"
                                    readonly
                                />
                            </div>
                            <div class="form-group">
                                <label>Email: </label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    v-model="edit.email"
                                    readonly
                                />
                            </div>
                            <div class="form-group">
                                <label>Password: </label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    v-model="edit.password"
                                    placeholder="ISI JIKA INGIN DIUBAH"
                                />
                            </div>
                            <div class="form-group">
                                <label>Nomor Telepon: </label>
                                <input
                                    type="tel"
                                    name="phone"
                                    class="form-control"
                                    v-model="edit.phone"
                                />
                            </div>
                            <div class="form-group">
                                <label>Alamat: </label>
                                <textarea
                                    name="address"
                                    class="form-control"
                                    v-model="edit.address"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label>Level User: </label>
                                <select
                                    name="level"
                                    v-model="edit.level"
                                    class="form-control"
                                >
                                    <option value="">Pilih salah satu..</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Kasir">Kasir</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Foto: </label>
                                <input
                                    type="file"
                                    name="file"
                                    class="form-control-file"
                                    accept="image/*"
                                    @change="onChangePhotoEdit"
                                />
                                <img
                                    :src="`${edit.image}`"
                                    class="image-table"
                                    id="edit-category-image"
                                />
                            </div>
                            <input
                                type="hidden"
                                name="id"
                                class="form-control"
                                v-model="edit.id"
                            />
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                                :disabled="addLoading == true"
                            >
                                <span
                                    class="spinner-border spinner-border-sm"
                                    role="status"
                                    aria-hidden="true"
                                    v-if="addLoading == true"
                                ></span>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Detail Modal -->
        <div
            class="modal fade"
            id="modalDetail"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Detail User
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Tutup"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"
                                >Nama Lengkap:
                            </label>
                            <div class="col-sm-8">
                                <input
                                    class="form-control-plaintext"
                                    type="text"
                                    v-model="detail.name"
                                    readonly
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"
                                >Email:
                            </label>
                            <div class="col-sm-8">
                                <input
                                    class="form-control-plaintext"
                                    type="email"
                                    v-model="detail.email"
                                    readonly
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"
                                >Nomor Telepon:
                            </label>
                            <div class="col-sm-8">
                                <input
                                    class="form-control-plaintext"
                                    type="tel"
                                    v-model="detail.phone"
                                    readonly
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"
                                >Alamat:
                            </label>
                            <div class="col-sm-8">
                                <textarea
                                    name="address"
                                    cols="30"
                                    rows="4"
                                    class="form-control-plaintext"
                                    v-model="detail.address"
                                    readonly
                                ></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"
                                >Level User:
                            </label>
                            <div class="col-sm-8">
                                <input
                                    name="level"
                                    class="form-control-plaintext"
                                    v-model="detail.level"
                                    readonly
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- container fluid -->
</template>

<script>
export default {
    mounted() {
        this.displayData(this.page, this.search);
    },

    data() {
        return {
            edit: {
                id: "",
                name: "",
                email: "",
                password: "",
                username: "",
                level: "",
                address: "",
                image: "",
                photo: ""
            },
            add: {
                name: "",
                email: "",
                password: "",
                username: "",
                level: "",
                address: "",
                image: "",
                photo: ""
            },
            errors: "",
            detail: {},
            search: "",
            users: [],
            photo: "",

            addLoading: false,
            page: 1,
            first_page: 1,
            last_page: null,
            current_page: this.$route.query.page || 1,
            next_page_url: "",
            prev_page_url: ""
        };
    },

    methods: {
        displayData(page = 1, search = "") {
            axios
                .get("/api/v1/user", {
                    params: { search: this.search, page: this.page }
                })
                .then(result => {
                    this.users = result.data.data;
                    this.last_page = result.data.meta.last_page;
                    this.current_page = result.data.meta.current_page;
                    this.next_page_url = result.data.links.next;
                    this.prev_page_url = result.data.links.prev;
                });
        },

        addUser() {
            this.addLoading = true;
            const formData = new FormData();
            formData.append("id", "");
            formData.append("name", this.add.name);
            formData.append("email", this.add.email);
            formData.append("password", this.add.password);
            formData.append("phone", this.add.phone);
            formData.append("address", this.add.address);
            formData.append("level", this.add.level);
            formData.append("username", this.add.username);
            formData.append("image", this.add.image);
            formData.append("photo", this.add.photo);
            axios
                .post("/api/v1/user", formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                })
                .then(res => {
                    this.addLoading = false;
                    this.errors = [];
                    $("#modalAdd").modal("toggle");
                    alertify.success("Success Create User!");
                    this.displayData();
                    this.add.name = "";
                    this.add.email = "";
                    this.add.password = "";
                    this.add.phone = "";
                    this.add.address = "";
                    this.add.level = "";
                    this.add.username = "";
                    this.add.photo = "";
                })
                .catch(error => {
                    this.addLoading = false;
                    const statusCode = error.response.status;
                    if (statusCode == 500) {
                        this.errors = { error: "Terjadi kesalahan sistem." };
                    } else if (statusCode == 400) {
                        this.errors = error.response.data.errors;
                    }
                });
        },

        detailUser(id) {
            axios.get(`/api/v1/user/${id}`).then(res => {
                this.detail = res.data;
                $("#modalDetail").modal("show");
            });
        },

        editUser(id) {
            axios.get(`/api/v1/user/${id}/edit`).then(res => {
                this.edit.id = res.data.id;
                this.edit.name = res.data.name;
                this.edit.username = res.data.username;
                this.edit.email = res.data.email;
                this.edit.password = res.data.password;
                this.edit.phone = res.data.phone;
                this.edit.address = res.data.address;
                this.edit.level = res.data.level;
                this.edit.image = res.data.image;
                $("#modalEdit").modal("show");
            });
        },

        updateUser() {
            const formData = new FormData();
            formData.append("id", this.edit.id);
            formData.append("name", this.edit.name);
            formData.append("email", this.edit.email);
            formData.append("password", this.edit.password);
            formData.append("phone", this.edit.phone);
            formData.append("address", this.edit.address);
            formData.append("level", this.edit.level);
            formData.append("username", this.edit.username);
            formData.append("image", this.edit.image);
            formData.append("photo", this.edit.photo);
            axios
                .post(`/api/v1/user`, formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                })
                .then(res => {
                    this.addLoading = false;
                    this.errors = [];
                    $("#modalEdit").modal("toggle");
                    alertify.success("Success Update User!");
                    this.displayData();
                })
                .catch(error => {
                    this.addLoading = false;
                    const statusCode = error.response.status;
                    if (statusCode == 500) {
                        this.errors = { error: "Terjadi kesalahan sistem." };
                    } else if (statusCode == 400) {
                        this.errors = error.response.data.errors;
                    }
                });
        },

        deleteUser(id) {
            const that = this;
            alertify.confirm(
                "Anda yakin ingin menghapus?",
                function(e) {
                    e.preventDefault();
                    axios.delete(`/api/v1/user/${id}`).then(res => {
                        alertify.success("Success Delete User!");
                        that.displayData();
                    });
                },
                function(e) {
                    e.preventDefault();
                    alertify.error("Berhasil membatalkan");
                }
            );
        },

        onChangePhotoAdd() {
            this.add.photo = event.target.files[0];
            $("#add-category-image").attr(
                "src",
                URL.createObjectURL(event.target.files[0])
            );
        },

        onChangePhotoEdit() {
            this.edit.photo = event.target.files[0];
            $("#edit-category-image").attr(
                "src",
                URL.createObjectURL(event.target.files[0])
            );
        },

        nextPage() {
            let nextPage = this.current_page + 1;
            window.history.replaceState(null, null, "?page=" + nextPage);
            this.displayData(this.current_page + 1, this.search);
        },

        prevPage() {
            let prevPage = this.current_page - 1;
            window.history.replaceState(null, null, "?page=" + prevPage);
            this.displayData(prevPage, this.search);
        },

        searchData() {
            this.displayData(1, this.search);
            window.history.replaceState(null, null, "?page=1");
        }
    }
};
</script>

<style>
.image-table {
    width: 80px;
}
.image-table-users {
    border-radius: 50%;
    width: 50px;
    height: 50px;
    margin-right: 10px;
    object-fit: cover;
}
</style>
