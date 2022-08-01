<template>
  <div>
    <div class="row">
      <router-link to="/order" class="btn btn-primary">Go Back</router-link>
    </div>
    
    <div class="row justify-content-center print" id="printMe">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Cash Memo</h1>
                  </div>

                  <div class="row">
                    <div class="col-lg-12 mb-4">
                      <!-- Simple Tables -->
                      <div class="card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                          <div>
                          <div class="table-responsive">
                          <ul class="list-group">
                            <li class="list-group-item">
                              <b>Customer Name:</b> {{ orders.name }}
                            </li>
                            <li class="list-group-item">
                              <b>Phone:</b> {{ orders.phone }}
                            </li>
                            <li class="list-group-item">
                              <b>Address:</b> {{ orders.address }}
                            </li>
                            <li class="list-group-item">
                              <b>Date:</b> {{ orders.order_date }}
                            </li>
                          </ul>
                        </div>
                        </div>
                        <div class="col-lg -6">
                          <h2>Inventory Management</h2>
                        </div>

                        </div>
                        <div class="table-responsive">
                          <table class="table align-items-center table-flush">
                            <thead style="background-color: lightblue" >
                              <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Price</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="detail in details" :key="detail.id">
                                <td>{{ detail.product_name }}</td>
                                <td>{{ detail.pro_quantity }}</td>
                                <td>{{ detail.product_price }}</td>
                                <td>{{ detail.pro_quantity * detail.product_price }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div><hr>
                        
                        <div class="row">
                          <div class="col-md-8"></div>
                          
                          <div class="col-md-4">
                            <ul>
                              <ul>
                                <b>Vat:</b> {{ orders.total - orders.sub_total }}
                              </ul>
                              <ul>
                                <b>Total:</b> {{ orders.total }}
                              </ul>
                              <ul>
                                <b>Due:</b> {{ orders.due }}
                              </ul>
                              <ul>
                                <b>Paid:</b> {{ orders.total - orders.due }}
                              </ul>
                          </ul>
                          </div>
                        </div>
                        <div class="card-footer">
                        </div>

                      </div>
                      
                    </div>
                  </div>
                  
                  <hr/>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Print Specific part  -->
    <button @click="print">Print</button>
    
  </div>
</template>


<script>

// Print Specific part
import Vue from 'vue';
import VueHtmlToPaper from 'vue-html-to-paper';
const options = {
  name: '',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    'https://unpkg.com/kidlat-css/css/kidlat.css'
  ]
}

Vue.use(VueHtmlToPaper, options);

// End of Print Specific part


export default {
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }
  },

  data() {
    return {
      errors: {},
      orders: {},
      details: {},
      output: null,
    };
  },

  created() {
    let id = this.$route.params.id;
    axios
      .get("/api/order/details/" + id)
      .then(({ data }) => (this.orders = data))
      .catch(console.log("error"));

    axios
      .get("/api/order/orderdetails/" + id)
      .then(({ data }) => (this.details = data))
      .catch(console.log("error"));
  },

  methods: {
    print () {
      this.$htmlToPaper('printMe');
    }
  },
};


</script>


<style scoped>

#em_photo {
  height: 40px;
  width: 40px;
}

button{
background-color: black;
color: white;
width:100px;
height: 50px;
border-radius: 10px;

}

</style>