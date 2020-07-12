<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="page-title m-0">Product</h4>
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
                                    List All Product
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
                                        placeholder="Cari Nama Category"
                                        aria-label="Cari Nama Category"
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
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="product in products"
                                        v-bind:key="product.id"
                                    >
                                        <td>{{ product.id }}</td>
                                        <td>
                                            <b>{{ product.code }}</b>
                                        </td>
                                        <td>
                                            <img
                                                :src="`${product.image}`"
                                                alt="Gambar"
                                                class="image-table"
                                            />
                                            <span>{{ product.name }}</span>
                                        </td>
                                        <td>{{ product.stock }}</td>
                                        <td>
                                            Rp {{ formatPrice(product.price) }}
                                        </td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn btn-warning"
                                                @click="editProduct(product.id)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                type="button"
                                                @click="
                                                    deleteProduct(product.id)
                                                "
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
                            Add Product
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
                        @submit.prevent="addProduct"
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
                                <label>Nama Product: </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    placeholder="Nama product"
                                    v-model="add.name"
                                />
                            </div>
                            <div class="form-group">
                                <label>Category: </label>
                                <select
                                    name="category"
                                    class="form-control"
                                    v-model="add.category"
                                >
                                    <option value="">Pilih salah satu..</option>
                                    <option
                                        :value="category.id"
                                        v-for="category in this.categories"
                                        :key="category.id"
                                        >{{ category.name }}</option
                                    >
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi: </label>
                                <textarea
                                    name="description"
                                    cols="30"
                                    rows="5"
                                    class="form-control"
                                    v-model="add.description"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label>Harga: </label>
                                <input
                                    type="number"
                                    class="form-control"
                                    name="price"
                                    placeholder="Harga"
                                    v-model="add.price"
                                />
                            </div>
                            <div class="form-group">
                                <label>Stock: </label>
                                <input
                                    type="number"
                                    class="form-control"
                                    name="stock"
                                    placeholder="Stok barang"
                                    v-model="add.stock"
                                />
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
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Update Product
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
                        @submit.prevent="updateProduct"
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
                                <label>Nama Product: </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    placeholder="Nama product"
                                    v-model="edit.name"
                                />
                            </div>
                            <div class="form-group">
                                <label>Category: </label>
                                <select
                                    name="category"
                                    class="form-control"
                                    v-model="edit.category"
                                >
                                    <option value="">Pilih salah satu..</option>
                                    <option
                                        :value="category.id"
                                        v-for="category in this.categories"
                                        :key="category.id"
                                        >{{ category.name }}</option
                                    >
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi: </label>
                                <textarea
                                    name="description"
                                    cols="30"
                                    rows="5"
                                    class="form-control"
                                    v-model="edit.description"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label>Harga: </label>
                                <input
                                    type="number"
                                    class="form-control"
                                    name="price"
                                    placeholder="Harga"
                                    v-model="edit.price"
                                />
                            </div>
                            <div class="form-group">
                                <label>Stock: </label>
                                <input
                                    type="number"
                                    class="form-control"
                                    name="stock"
                                    placeholder="Stok barang"
                                    v-model="edit.stock"
                                />
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

        <!-- end row -->
    </div>
    <!-- container fluid -->
</template>

<script>
export default {
    mounted() {
        this.displayData(this.page, this.search);
        this.getCategories();
    },

    data() {
        return {
            edit: {
                id: "",
                name: "",
                category: "",
                code: "",
                price: "",
                description: "",
                image: "",
                photo: ""
            },
            add: {
                name: "",
                description: "",
                price: "",
                stock: "",
                category: "",
                photo: "",
                image: ""
            },
            search: "",
            products: [],
            categories: [],
            errors: [],

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
                .get("/api/v1/product", {
                    params: { search: this.search, page: this.page }
                })
                .then(result => {
                    this.products = result.data.data;
                    this.last_page = result.data.meta.last_page;
                    this.current_page = result.data.meta.current_page;
                    this.next_page_url = result.data.links.next;
                    this.prev_page_url = result.data.links.prev;
                });
        },

        addProduct() {
            this.addLoading = true;
            const formData = new FormData();
            formData.append("id", "");
            formData.append("name", this.add.name);
            formData.append("description", this.add.description);
            formData.append("category", this.add.category);
            formData.append("price", this.add.price);
            formData.append("stock", this.add.stock);
            formData.append("image", this.add.image);
            formData.append("photo", this.add.photo);
            axios
                .post("/api/v1/product", formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                })
                .then(res => {
                    this.addLoading = false;
                    this.errors = [];
                    $("#modalAdd").modal("toggle");
                    alertify.success("Success Create Product!");
                    this.displayData();
                    this.add.name = "";
                    this.add.description = "";
                    this.add.category = "";
                    this.add.price = "";
                    this.add.stock = "";
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

        editProduct(id) {
            axios.get(`/api/v1/product/${id}/edit`).then(res => {
                this.edit.id = res.data.id;
                this.edit.name = res.data.name;
                this.edit.category = res.data.category_id;
                this.edit.description = res.data.description;
                this.edit.price = res.data.price;
                this.edit.stock = res.data.stock;
                this.edit.image = res.data.image;
                this.edit.photo = res.data.image;
                $("#modalEdit").modal("show");
            });
        },

        updateProduct() {
            this.addLoading = true;
            const formData = new FormData();
            formData.append("id", this.edit.id);
            formData.append("name", this.edit.name);
            formData.append("description", this.edit.description);
            formData.append("category", this.edit.category);
            formData.append("price", this.edit.price);
            formData.append("stock", this.edit.stock);
            formData.append("image", this.edit.image);
            formData.append("photo", this.edit.photo);
            axios
                .post(`/api/v1/product`, formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                })
                .then(res => {
                    this.addLoading = false;
                    this.errors = [];
                    $("#modalEdit").modal("toggle");
                    alertify.success("Success Update Product!");
                    this.displayData();
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

        deleteProduct(id) {
            const that = this;
            alertify.confirm(
                "Anda yakin ingin menghapus?",
                function(e) {
                    e.preventDefault();
                    axios.delete(`/api/v1/product/${id}`).then(res => {
                        alertify.success("Success Delete Product!");
                        that.displayData();
                    });
                },
                function(e) {
                    e.preventDefault();
                    alertify.error("Berhasil membatalkan");
                }
            );
        },

        getCategories() {
            axios
                .get(`/api/v1/category`)
                .then(res => {
                    this.categories = res.data.data;
                })
                .catch(err => {
                    this.errors = err.response.data;
                });
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
        },

        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    }
};
</script>

<style>
.image-table {
    width: 40px;
    height: 40px;
    object-fit: cover;
    margin-right: 10px;
}
</style>
