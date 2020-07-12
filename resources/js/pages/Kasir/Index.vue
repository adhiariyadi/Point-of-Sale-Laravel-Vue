<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="page-title m-0">Transaksi</h4>
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
            <div class="col-md-4">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-8">
                                <h4 class="mt-0 header-title">
                                    Transaksi Baru
                                </h4>
                            </div>
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
                                        @click="addProductToCart(data)"
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
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div
                            class="alert alert-success"
                            v-if="successMsg !== ''"
                            v-html="successMsg"
                        ></div>
                        <div class="row mb-3">
                            <div class="col-8">
                                <h4 class="mt-0 header-title">
                                    Daftar Pembelian
                                </h4>
                            </div>
                        </div>
                        <div class="float-right mb-2">
                            <h5>
                                Total Harga:
                                <span id="rp"
                                    >Rp
                                    <span id="total-price" data-value="0">{{
                                        formatPrice(totalPrice)
                                    }}</span></span
                                >
                            </h5>
                        </div>
                        <form action="" method="post" id="form-transaction">
                            <div class="table-responsive">
                                <table
                                    class="table table-striped"
                                    id="table-transaction"
                                >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah</th>
                                            <th>Sisa Stok</th>
                                            <th>Harga</th>
                                            <th>PPN</th>
                                            <th>Total Harga</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(product, index) in cart"
                                            :key="product.id"
                                        >
                                            <td class="product_id">
                                                {{ index + 1 }}
                                            </td>
                                            <td>
                                                <b>{{
                                                    product.code.toUpperCase()
                                                }}</b>
                                                - {{ product.name }}
                                            </td>
                                            <td>
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    @keyup="
                                                        changeQuantity(index)
                                                    "
                                                    v-model="qty[index]"
                                                    value="1"
                                                />
                                            </td>
                                            <td>
                                                {{ product.stock }}
                                            </td>
                                            <td>
                                                <span
                                                    v-if="
                                                        product.discount ===
                                                            null
                                                    "
                                                >
                                                    Rp
                                                    {{
                                                        formatPrice(
                                                            product.realPrice
                                                        )
                                                    }}
                                                </span>
                                                <span
                                                    v-if="
                                                        product.discount !==
                                                            null
                                                    "
                                                >
                                                    <del>
                                                        Rp
                                                        {{
                                                            formatPrice(
                                                                product.realPrice
                                                            )
                                                        }} </del
                                                    ><br />
                                                    Rp
                                                    {{
                                                        formatPrice(
                                                            product.realPrice -
                                                                (product
                                                                    .discount
                                                                    .amount /
                                                                    100) *
                                                                    product.realPrice
                                                        )
                                                    }} </span
                                                ><br />
                                                <span
                                                    class="text-success"
                                                    v-if="
                                                        product.discount !==
                                                            null
                                                    "
                                                    >DISKON!</span
                                                >
                                            </td>
                                            <td>
                                                Rp
                                                {{
                                                    product.discount !== null
                                                        ? formatPrice(
                                                              0.1 *
                                                                  (product.realPrice -
                                                                      (product
                                                                          .discount
                                                                          .amount /
                                                                          100) *
                                                                          product.realPrice)
                                                          )
                                                        : formatPrice(
                                                              0.1 *
                                                                  product.realPrice
                                                          )
                                                }}
                                            </td>
                                            <td>
                                                Rp
                                                {{
                                                    product.discount !== null
                                                        ? formatPrice(
                                                              product.price -
                                                                  (product
                                                                      .discount
                                                                      .amount /
                                                                      100) *
                                                                      product.price +
                                                                  0.1 *
                                                                      (product.price -
                                                                          (product
                                                                              .discount
                                                                              .amount /
                                                                              100) *
                                                                              product.price)
                                                          )
                                                        : formatPrice(
                                                              product.price +
                                                                  0.1 *
                                                                      product.price
                                                          )
                                                }}
                                            </td>
                                            <td>
                                                <button
                                                    type="button"
                                                    @click="deleteCart(index)"
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <div class="row" v-if="this.cart.length >= 1">
                                    <div class="col-md-6 offset-md-6">
                                        <div class="form-group  mt-3">
                                            <label>Nominal Bayar</label>
                                            <input
                                                type="number"
                                                :class="{
                                                    'form-control': true,
                                                    'is-invalid': this.error
                                                }"
                                                id="nomi  nal-bayar"
                                                name="nominal_bayar"
                                                @keyup="hitungKembalian()"
                                                v-model="bayar"
                                            />
                                            <div
                                                class="invalid-feedback"
                                                v-if="this.error"
                                            >
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="form-group  mt-3">
                                            <label>Kembalian</label>
                                            <input
                                                type="number"
                                                class="form-control"
                                                id="kembalian"
                                                name="kembalian"
                                                readonly
                                                v-model="kembalian"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <button
                                    class="btn btn-primary float-right"
                                    type="button"
                                    v-if="this.cart.length >= 1"
                                    @click="showKeteranganModal()"
                                >
                                    Proses
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- KETERANGAN MODAL -->
        <div
            class="modal fade"
            id="keteranganModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Isi Data
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" @submit.prevent="processTransaction()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Customer: </label>
                                <select
                                    name=""
                                    id=""
                                    class="form-control"
                                    v-model="customer"
                                >
                                    <option value="">Pilih customer..</option>
                                    <option
                                        v-for="customer in this.customers"
                                        :key="customer.id"
                                        :value="customer.id"
                                        >{{ customer.name }}</option
                                    >
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Metode Pembayaran: </label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    v-model="payment_method"
                                    readonly
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
                            <button type="submit" class="btn btn-primary">
                                Selesai
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
        $(
            ".button-menu-mobile.open-left.waves-effect:not(.button-menu-mobile-topbar)"
        ).click();
    },

    data() {
        return {
            search: "",
            cart: [],
            productSearch: [],
            totalPrice: 0,
            kembalian: 0,
            bayar: 0,
            error: false,
            successMsg: "",
            customers: [],
            customer: "",
            payment_method: "Uang Cash",
            qty: []
        };
    },

    methods: {
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

        addProductToCart(array) {
            let product_id = array.id;
            array.quantity = 1;
            array.realPrice = array.price;
            this.qty.push(1);
            let obj = this.cart.find(o => o.id === array.id);
            if (obj !== undefined) {
                alertify.error("Barang sudah ditambahkan");
            } else {
                this.cart.push(array);
            }
            this.productSearch = "";
            this.countTotalPrice();
        },

        changeQuantity(index) {
            let qty = this.qty[index];
            let price = this.cart[index].realPrice;
            let stock = this.cart[index].stock;
            if (qty > stock) {
                this.qty[index] = stock;
            } else {
                this.cart[index].quantity = qty;
                let newPrice = price * qty;
                this.cart[index].price = newPrice;
            }
            this.countTotalPrice();
        },

        countTotalPrice() {
            this.totalPrice = 0;
            let totalPrice = 0;
            this.cart.forEach((data_cart, index) => {
                if (data_cart.discount !== null) {
                    var realPrice = parseInt(
                        data_cart.realPrice -
                            (data_cart.discount.amount / 100) *
                                data_cart.realPrice +
                            0.1 *
                                (data_cart.realPrice -
                                    (data_cart.discount.amount / 100) *
                                        data_cart.realPrice)
                    );
                } else {
                    var realPrice = parseInt(
                        data_cart.realPrice + 0.1 * data_cart.realPrice
                    );
                }
                let quantity = parseInt(data_cart.quantity);
                let total = realPrice * quantity;
                totalPrice += total;
            });
            this.totalPrice = totalPrice;
            this.hitungKembalian();
        },

        deleteCart(index) {
            this.cart.splice(index, 1);
            this.qty.splice(index, 1);
            this.countTotalPrice();
            console.log(this.cart);
        },

        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(".", ",");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },

        processTransaction() {
            this.addLoading = true;
            let cart = this.cart;
            let bayar = this.bayar;
            let kembalian = this.kembalian;
            let payment_method = this.payment_method;
            let customer = this.customer;
            axios
                .post(`/api/v1/transaction/new`, {
                    kembalian,
                    bayar,
                    cart,
                    customer,
                    payment_method
                })
                .then(res => {
                    if (res.data.status == true) {
                        this.addLoading = false;
                        this.errors = [];
                        $("#keteranganModal").modal("toggle");
                        alertify.success("Transaksi SUccess!");
                        this.cart = [];
                        this.kembalian = 0;
                        this.totalPrice = 0;
                        this.bayar = 0;
                        this.successMsg = res.data.message;
                    }
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

        hitungKembalian() {
            let totalPrice = this.totalPrice;
            let bayar = this.bayar;
            let kembalian = bayar - totalPrice;
            if (this.bayar >= this.totalPrice) {
                this.error = false;
            }
            this.kembalian = kembalian;
        },

        showKeteranganModal() {
            if (this.bayar < this.totalPrice) {
                this.error = `Minimal bayar adalah Rp ${this.totalPrice}`;
                return;
            }
            axios.get("/api/v1/customer/all").then(res => {
                this.customers = res.data.data;
            });
            $("#keteranganModal").modal("show");
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

#rp {
    color: #d35400;
}
</style>
