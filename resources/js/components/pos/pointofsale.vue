<template>
  <div>
      
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">POS</h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">POS</li>
        </ol>
      </div>

      <div class="row mb-3">
        <!-- Area Chart -->
        <div class="col-xl-5 col-lg-5">
          <div class="card mb-4">
            <div class=" card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Expense Insert</h6>
              <a href="./store-customer" class="btn btn-sm btn-info"><font color="#ffffff">Add Customer </font></a>
            </div>

            <div class="table-responsive" style="font-size: 12px">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Total</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="cart in carts" :key="cart.id">
                    <td>{{ cart.pro_name }}</td>
                    <td>
                      <input type="text" readonly="" style="width: 20px" :value="cart.pro_quantity"/>
                      <button @click.prevent="increment(cart.id)" class="btn btn-sm btn-success">+</button>
                      <button @click.prevent="decrement(cart.id)" class="btn btn-sm btn-danger" v-if="cart.pro_quantity >= 2">-</button>
                      <button class="btn btn-sm btn-danger" v-else-if="cart.pro_quantity <= 2" disabled="">-</button>
                    </td>
                    <td>{{ cart.product_price }}</td>
                    <td>{{ cart.sub_total }}</td>
                    <td>
                      <a @click="removeItem(cart.id)" class="btn btn-sm btn-danger"><font color="#ffffff"> X </font></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="card-footer">
              <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between  align-items-center">
                  Total quantity: <strong>{{ qty }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Sub Total: <strong>{{ subTotal }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Vat:
                  <strong>{{ vats.vat }}%</strong>
                </li>
                <li class=" list-group-item d-flex justify-content-between align-items-center">
                  Total : <strong>{{ (subTotal * vats.vat) / 100 + subTotal }}</strong>
                </li>
              </ul>

              <br/>

              <form @submit.prevent="orderdone">
                <label for="">Customer Name</label>
                <select class="form-control" v-model="customer_id">
                  <option :value="customer.id" v-for="customer in customers" :key="customer.id"> {{ customer.name }} </option>
                </select>

                <label for="">Pay</label>
                <input type="text" class="form-control" required="" v-model="pay"/>
                <br/>
                <label for="">Due</label>
                <!-- <input type="text" class="form-control" required="" v-model="due"> -->
                <h5>
                  <b>{{
                    (due = (subTotal * vats.vat) / 100 + subTotal - pay)
                  }}</b>
                </h5>

                <label for="">Pay By</label>
                <select class="form-control" v-model="payby">
                  <option value="Cash">Cash</option>
                  <option value="Checque">Cheque</option>
                  <option value="GiftCard">Gift Card</option>
                </select>

                <br />

                <button type="submit" class="btn btn-success">Submit</button>
              </form>
            </div>
          </div>
        </div>
        <!-- Pie Chart -->
        <div class="col-xl-7 col-lg-7">
          <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Products</h6>
              
            </div>

            <!-- Add to cart via Barcode -->
            <br>
            <h5 class="m-0 font-weight-bold text-primary">Scan Barcode to add to cart</h5>
            <br>
            <StreamBarcodeReader id="barcode_style"
                  @decode="(a, b, c) => onDecode(a, b, c)"
                  @loaded="() => onLoaded()"
            ></StreamBarcodeReader>

            Input Value: {{ text || "Nothing" }}
            <!-- Categorywise Product-->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All Product</a>
              </li>
              <li class="nav-item" role="presentation" v-for="category in categories" :key="category.id">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" @click="subproduct(category.id)" >{{ category.category_name }}</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card-body">
                  <input type="text" v-model="searchTerm" class="form-control" style="width: 300px" placeholder="Search Product"/>

                  <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="product in filterSearch" :key="product.id" v-show="product.product_quantity >= 1 ? true : false">
                      <button class="btn btn-sm" @click.prevent="AddToCart(product.id)">
                        <div class="card" id="card" style="width: 8.5rem; margin-bottom: 5px">
                          <img :src="product.image" id="em_photo" class="card-img-top"/>
                          <div class="card-body">
                            <h6 class="card-title"> {{ product.product_name }}</h6>
                            <span class="badge badge-success" v-if="product.product_quantity >= 1"> Available {{ product.product_quantity }}</span>
                            <span class="badge badge-danger" v-else-if="product.product_quantity < 1"> Stock Out </span>
                          </div>
                        </div>
                      </button>

                    </div>
                  </div>
                </div>
              </div>
              <!-- End of Tabs Home-->

              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card-body">
                  <input type="text" v-model="getsearchTerm" class="form-control" style="width: 300px" placeholder="Search Product"/>

                  <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="getproduct in getfilterSearch" :key="getproduct.id" v-show="getproduct.product_quantity >= 1 ? true : false">
                      <button class="btn btn-sm" @click.prevent="AddToCart(getproduct.id)">
                        <div class="card" id="card" style="width: 8.5rem; margin: 5px">
                          <img :src="getproduct.image" id="em_photo" class="card-img-top"/>
                          <div class="card-body">
                            <h6 class="card-title"> {{ getproduct.product_name }}</h6>
                            <span class="badge badge-success" v-if="getproduct.product_quantity >= 1"> Available {{ getproduct.product_quantity }}</span>
                            <span class="badge badge-danger" v-else-if="getproduct.product_quantity < 1"> Stock Out
                            </span>
                          </div>
                        </div>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End of Categorywise Product-->
          </div>
        </div>
      </div>
      <!-- Invoice Example -->
    </div>
    <!--Row-->
  </div>
  <!---Container Fluid-->
</template>


<script>
import { StreamBarcodeReader } from "vue-barcode-reader";
export default {
  components: {
StreamBarcodeReader
  },
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }
  },
  created() {
    this.allProduct();
    this.allCategory();
    this.allCustomer();
    this.cartProduct();
    this.vat();
    Reload.$on("AfterAdd", () => {
      this.cartProduct();
    });
  },




  data() {
    return {
      customer_id: "",
      pay: "",
      due: "",
      payby: "",
      products: [],
      categories: "",
      getproducts: [],
      searchTerm: "",
      getsearchTerm: "",
      customers: "",
      erroes: "",
      carts: [],
      vats: "",
      text: "",
      id: null,
    };
  },
  computed: {
    filterSearch() {
      return this.products.filter((product) => {
        return product.product_name.match(this.searchTerm) || product.product_code.match(this.searchTerm)
      });
    },
    getfilterSearch() {
      return this.getproducts.filter((getproduct) => {
        return getproduct.product_name.match(this.getsearchTerm);
      });
    },
    qty() {
      let sum = 0;
      for (let i = 0; i < this.carts.length; i++) {
        sum += parseFloat(this.carts[i].pro_quantity);
      }
      return sum;
    },
    subTotal() {
      let sum = 0;
      for (let i = 0; i < this.carts.length; i++) {
        sum +=
          parseFloat(this.carts[i].pro_quantity) *
          parseFloat(this.carts[i].product_price);
      }
      return sum;
    },
  },

  methods: {
    //Cart methods
    AddToCart(id) {
      console.log('add to cart', id)
      axios
        .get("/api/addToCart/" + id)
        .then(() => {
          Reload.$emit("AfterAdd");
          Notification.cart_success();
        })
        .catch();
    },

    onDecode(a, b, c) {
      console.log(a, b, c);
      axios
        .get("/api/barcode/product/" + a)
        .then((res) => {
          this.AddToCart(res.data[0].id)
          console.log(res.data)
        })
      console.log(a, b, c);
      this.text = a;
      if (this.id) clearTimeout(this.id);
      this.id = setTimeout(() => {
        if (this.text === a) {
          this.text = "";
        }
      }, 5000);
    },

    onLoaded() {
      console.log("load");
    },

    cartProduct() {
      axios
        .get("/api/cart/product/")
        .then(({ data }) => (this.carts = data))
        .catch();
    },

    removeItem(id) {
      axios
        .get("/api/remove/cart/" + id)
        .then(() => {
          Reload.$emit("AfterAdd");
          Notification.cart_delete();
        })
        .catch();
    },

    increment(id) {
      axios
        .get("/api/increment/" + id)
        .then(() => {
          Reload.$emit("AfterAdd");
          Notification.cart_success();
        })
        .catch();
    },

    decrement(id) {
      axios
        .get("/api/decrement/" + id)
        .then(() => {
          Reload.$emit("AfterAdd");
          Notification.cart_success();
        })
        .catch();
    },
    vat() {
      axios
        .get("/api/vats/")
        .then(({ data }) => (this.vats = data))
        .catch();
    },

    orderdone() {
      let total = (this.subTotal * this.vats.vat) / 100 + this.subTotal;
      var data = {
        qty: this.qty,
        subTotal: this.subTotal,
        customer_id: this.customer_id,
        pay: this.pay,
        payby: this.payby,
        due: this.due,
        vat: this.vats.vat,
        total: total,
      };
      axios.post("/api/orderdone", data).then(() => {
        Notification.success();
        this.$router.push({ name: "home" });
      });
    },

    //End of Cart methods
    allProduct() {
      axios
        .get("/api/product/")
        .then(({ data }) => (this.products = data))
        .catch();
    },

    allCategory() {
      axios
        .get("/api/category/")
        .then(({ data }) => (this.categories = data))
        .catch();
    },

    allCustomer() {
      axios
        .get("/api/customer/")
        .then(({ data }) => (this.customers = data))
        .catch(console.log("error"));
    },

    subproduct(id) {
      axios
        .get("/api/getting/product/" + id)
        .then(({ data }) => (this.getproducts = data))
        .catch();
    },
  },
};
</script>


<style scoped>
#em_photo {
  height: 100px;
  width: 135px;
}


#card {

  transition: transform .7s;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  border-radius: 500px;
  margin: auto;
  text-align: center;
  font-family: arial;
  background: white;
    
  
}
#card:hover{

   transform: scale(1.08);
   background-color: aquamarine;
   color: black;
}

#barcode_style{
  /* padding: 20px 20px; */
  margin: 40px 40px;
}

  
</style>