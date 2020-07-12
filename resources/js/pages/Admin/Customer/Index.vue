<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="page-title m-0">Customer</h4>
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
                                    List All Customer
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
                                        placeholder="Cari Nama"
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
                                        <th>No. telepon</th>
                                        <th>Level</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="data in customers"
                                        v-bind:key="data.id"
                                    >
                                        <td>{{ data.id }}</td>
                                        <td>
                                            <img
                                                :src="`${data.image}`"
                                                class="image-table-customers"
                                                v-if="data.image !== ''"
                                            />
                                            {{ data.name }}
                                        </td>
                                        <td>{{ data.email }}</td>
                                        <td>{{ data.phone }}</td>
                                        <td>
                                            <div class="badge badge-primary">
                                                {{ data.level }}
                                            </div>
                                        </td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn btn-primary"
                                                @click="detailCustomer(data.id)"
                                            >
                                                Detail
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-warning"
                                                @click="editCustomer(data.id)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                type="button"
                                                @click="deleteCustomer(data.id)"
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
            level="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" level="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Add Customer
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
                        @submit.prevent="addCustomer"
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
                                <label>Nama Customer: </label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    v-model="add.name"
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
                                <label>Nomor Telepon: </label>
                                <input
                                    type="tel"
                                    name="phone"
                                    class="form-control"
                                    v-model="add.phone"
                                />
                            </div>
                            <div class="form-group">
                                <label>Level Customer: </label>
                                <select
                                    name="level"
                                    v-model="add.level"
                                    class="form-control"
                                >
                                    <option value="">Pilih salah satu</option>
                                    <option value="Retail">Retail</option>
                                    <option value="Grosir">Grosir</option>
                                    <option value="Dropshipper"
                                        >Dropshipper</option
                                    >
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Provinsi: </label>
                                <input
                                    type="text"
                                    name="provinsi"
                                    v-model="add.provinsi"
                                    class="form-control"
                                />
                            </div>
                            <div class="form-group">
                                <label>Kota: </label>
                                <input
                                    type="text"
                                    name="kota"
                                    v-model="add.kota"
                                    class="form-control"
                                />
                            </div>
                            <div class="form-group">
                                <label>Alamat: </label>
                                <textarea
                                    name="alamat"
                                    cols="30"
                                    rows="10"
                                    v-model="add.alamat"
                                    class="form-control"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label>Foto: </label>
                                <input
                                    type="file"
                                    name="photo"
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
            level="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" level="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Edit Customer
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
                        @submit.prevent="updateCustomer"
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
                                <label>Nama Customer: </label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    v-model="edit.name"
                                />
                            </div>
                            <div class="form-group">
                                <label>Email: </label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    v-model="edit.email"
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
                                    name="alamat"
                                    class="form-control"
                                    v-model="edit.alamat"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label>Level Customer: </label>
                                <select
                                    name="level"
                                    v-model="edit.level"
                                    class="form-control"
                                >
                                    <option value="">Pilih salah satu</option>
                                    <option value="Retail">Retail</option>
                                    <option value="Grosir">Grosir</option>
                                    <option value="Dropshipper"
                                        >Dropshipper</option
                                    >
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Foto: </label>
                                <input
                                    type="file"
                                    name="photo"
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
            level="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" level="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Detail Customer
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
                                >Nama Customer:
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
                                    name="alamat"
                                    cols="30"
                                    rows="4"
                                    class="form-control-plaintext"
                                    v-model="detail.alamat"
                                ></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"
                                >Level Customer:
                            </label>
                            <div class="col-sm-8">
                                <input
                                    type="text"
                                    name="level"
                                    class="form-control-plaintext"
                                    v-model="detail.level"
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
                phone: "",
                level: "",
                alamat: "",
                kota: "",
                provinsi: "",
                photo: "",
                image: ""
            },
            add: {
                name: "",
                email: "",
                phone: "",
                level: "",
                alamat: "",
                kota: "",
                provinsi: "",
                photo: "",
                image: ""
            },
            errors: "",
            detail: {},
            search: "",
            customers: [],
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
                .get("/api/v1/customer", {
                    params: { search: this.search, page: this.page }
                })
                .then(result => {
                    this.customers = result.data.data;
                    this.last_page = result.data.meta.last_page;
                    this.current_page = result.data.meta.current_page;
                    this.next_page_url = result.data.links.next;
                    this.prev_page_url = result.data.links.prev;
                });
        },

        addCustomer() {
            this.addLoading = true;
            const formData = new FormData();
            formData.append("id", "");
            formData.append("name", this.add.name);
            formData.append("email", this.add.email);
            formData.append("phone", this.add.phone);
            formData.append("alamat", this.add.alamat);
            formData.append("level", this.add.level);
            formData.append("kota", this.add.kota);
            formData.append("provinsi", this.add.provinsi);
            formData.append("image", this.add.image);
            formData.append("photo", this.add.photo);
            axios
                .post("/api/v1/customer", formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                })
                .then(res => {
                    this.addLoading = false;
                    this.errors = [];
                    $("#modalAdd").modal("toggle");
                    alertify.success("Success Create Customer!");
                    this.displayData();
                    this.add.name = "";
                    this.add.email = "";
                    this.add.phone = "";
                    this.add.alamat = "";
                    this.add.level = "";
                    this.add.kota = "";
                    this.add.provinsi = "";
                    this.add.photo = "";
                })
                .catch(error => {
                    this.addLoading = false;
                    let statusCode = error.response.status;
                    if (statusCode == 500) {
                        this.errors = { error: "Terjadi kesalahan sistem." };
                    } else if (statusCode == 400) {
                        this.errors = error.response.data.errors;
                    }
                });
        },

        detailCustomer(id) {
            axios.get(`/api/v1/customer/${id}`).then(res => {
                this.detail = res.data;
                $("#modalDetail").modal("show");
            });
        },

        editCustomer(id) {
            axios.get(`/api/v1/customer/${id}/edit`).then(res => {
                this.edit.id = res.data.id;
                this.edit.name = res.data.name;
                this.edit.email = res.data.email;
                this.edit.phone = res.data.phone;
                this.edit.alamat = res.data.alamat;
                this.edit.kota = res.data.kota;
                this.edit.provinsi = res.data.provinsi;
                this.edit.level = res.data.level;
                this.edit.image = res.data.image;
                $("#modalEdit").modal("show");
            });
        },

        updateCustomer() {
            this.addLoading = true;
            const formData = new FormData();
            formData.append("id", this.edit.id);
            formData.append("name", this.edit.name);
            formData.append("email", this.edit.email);
            formData.append("phone", this.edit.phone);
            formData.append("alamat", this.edit.alamat);
            formData.append("level", this.edit.level);
            formData.append("kota", this.edit.kota);
            formData.append("provinsi", this.edit.provinsi);
            formData.append("image", this.edit.image);
            formData.append("photo", this.edit.photo);
            axios
                .post("/api/v1/customer", formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                })
                .then(res => {
                    this.addLoading = false;
                    this.errors = [];
                    $("#modalEdit").modal("toggle");
                    alertify.success("Success Update Customer!");
                    this.displayData();
                })
                .catch(error => {
                    let statusCode = error.response.status;
                    if (statusCode == 500) {
                        this.errors = { error: "Terjadi kesalahan sistem." };
                    } else if (statusCode == 400) {
                        console.log(error.response.data);
                        this.errors = error.response.data;
                    }
                });
        },

        deleteCustomer(id) {
            const that = this;
            alertify.confirm(
                "Anda yakin ingin menghapus?",
                function(e) {
                    e.preventDefault();
                    axios.delete(`/api/v1/customer/${id}`).then(res => {
                        alertify.success("Success Delete Customer!");
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
.image-table-customers {
    border-radius: 50%;
    width: 50px;
    height: 50px;
    margin-right: 10px;
    object-fit: cover;
}
</style>
