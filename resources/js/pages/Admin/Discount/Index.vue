<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="page-title m-0">Discount</h4>
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
                                    List All Discount
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
                        <div class="table-responsive">
                            <table
                                class="table table-hover table-lg"
                                id="transaction-table"
                            >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Discount</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="discount in discounts">
                                        <td>{{ discount.id }}</td>
                                        <td>{{ discount.product.name }}</td>
                                        <td>{{ discount.amount }}%</td>
                                        <td>
                                            <div
                                                :class="{
                                                    badge: true,
                                                    'badge-danger':
                                                        discount.status ==
                                                        false,
                                                    'badge-success':
                                                        discount.status == true
                                                }"
                                            >
                                                {{
                                                    discount.status
                                                        ? "Aktif"
                                                        : "Tidak Aktif"
                                                }}
                                            </div>
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-danger"
                                                @click="
                                                    deleteDiscount(discount.id)
                                                "
                                            >
                                                Delete
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
        <!-- end row -->
        <!-- Modal -->
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
                            Add Discount
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
                        @submit.prevent="addDiscount"
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
                                <label>Nama/Kode Product: </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Cari Kode Atau Nama Product"
                                    v-model="search"
                                    @keyup="searchProduct"
                                />
                                <div class="dropdown-search">
                                    <ul>
                                        <li
                                            v-for="data in productSearch"
                                            :key="data.id"
                                            @click="addProduct(data)"
                                        >
                                            <img
                                                :src="`${data.image}`"
                                                alt=""
                                                class="dropdown-image"
                                            /><span
                                                ><b>{{
                                                    data.code.toUpperCase()
                                                }}</b>
                                                - {{ data.name }}</span
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Discount (Dalam %): </label>
                                <input
                                    type="number"
                                    name="amount"
                                    class="form-control"
                                    v-model="amount"
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
    </div>
    <!-- container fluid -->
</template>

<script>
export default {
    mounted() {
        this.displayData();
    },

    data() {
        return {
            products: [],
            discounts: [],
            productSearch: [],
            search: "",
            amount: "",
            errors: [],

            addLoading: false,
            first_page: 1,

            page: 1,
            search: "",
            last_page: null,
            current_page: this.$route.query.page || 1,
            next_page_url: "",
            prev_page_url: ""
        };
    },

    methods: {
        displayData(page = 1) {
            axios
                .get("/api/v1/discount", {
                    params: { page: this.page }
                })
                .then(result => {
                    this.discounts = result.data.data;
                    this.last_page = result.data.meta.last_page;
                    this.current_page = result.data.meta.current_page;
                    this.next_page_url = result.data.links.next;
                    this.prev_page_url = result.data.links.prev;
                });
        },

        searchProduct() {
            let searchProduct = this.search;
            if (this.search == "") {
                this.productSearch = [];
            } else {
                axios
                    .get("/api/v1/product/search", {
                        params: { search: searchProduct }
                    })
                    .then(res => {
                        this.productSearch = res.data;
                    });
            }
        },

        addProduct(data) {
            const productCode = data.code;
            this.search = productCode;
        },

        addDiscount() {
            var formData = new FormData();
            formData.append("product", this.search);
            formData.append("amount", this.amount);
            axios
                .post("/api/v1/discount", formData)
                .then(res => {
                    this.addLoading = false;
                    this.errors = [];
                    $("#modalAdd").modal("toggle");
                    alertify.success("Success Add Discount!");
                    this.displayData();
                    this.search = "";
                    this.amount = "";
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

        deleteDiscount(id) {
            const that = this;
            alertify.confirm(
                "Anda yakin ingin menghapus?",
                function(e) {
                    e.preventDefault();
                    axios.delete(`/api/v1/discount/${id}`).then(res => {
                        alertify.success("Success Delete Discount!");
                        that.displayData();
                    });
                },
                function(e) {
                    e.preventDefault();
                    alertify.error("Berhasil membatalkan");
                }
            );
        }
    }
};
</script>

<style>
.dropdown-search {
    background-color: #fdfdfd;
    border: 1px solid #eee;
    box-shadow: 2px 5px 10px #ccc;
}

.dropdown-search ul {
    list-style: none;
    margin-bottom: 0;
    padding-left: 0;
}

.dropdown-search ul li {
    padding: 10px 0 10px 10px;
    cursor: pointer;
}

.dropdown-search ul li:hover {
    background-color: #eee;
}

.dropdown-search ul li span {
    margin-left: 10px;
}

.dropdown-image {
    width: 40px;
    height: 40px;
    object-fit: cover;
}
</style>
