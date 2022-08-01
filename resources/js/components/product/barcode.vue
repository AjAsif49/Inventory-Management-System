<template>
    <div>

        <div class="row">
            <router-link to="/store-product" class="btn btn-primary">Add Product</router-link>
        </div>

  <br>
    <input type="text" v-model="searchTerm" class="form-control" style="width:300px;" placeholder="Search Product">
  <br>

          <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Product Barcodes</h6>
                </div>
                <div class="table-responsive">
                  <table class="table  table-flush">
                    <thead class="thead-light col-lg-6">
                      <tr>
                        <th>Product Name</th>
                        <th>Barcode</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="product in filterSearch" :key="product.id">
                        <td><h2>{{ product.product_name }}</h2></td>
                        <td>
                          <barcode :value="product.product_code"> {{ product.barcode  }}</barcode>
                        </td>
                      </tr>
                      
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
          <!--Row-->

  
    </div>
</template>


<script>
import VueBarcode from 'vue-barcode';

    export default{

      created(){
        if(!User.loggedIn()){
          this.$router.push({ name: '/' })
        
        }
      },
      data(){
        return{
          products:[],
          barcodeValue: '',
          searchTerm: ''
        }
      },
      components: {
      'barcode': VueBarcode
      },
      computed:{
        filterSearch(){
          return this.products.filter(product => {
            return product.product_name.match(this.searchTerm)
          })
        }
      },

     
     
    
    methods:{
      allProduct(){
        axios.get('/api/product/')
        .then(({data}) => (this.products = data))
        .catch()
      },
      deleteProduct(id){
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.value) {
          axios.delete('/api/product/'+id)
          .then(() => {
            this.products = this.products.filter(product =>{
              return product.id != id
            } )
          })
          .catch(() =>{
            this.$router.push({name: 'product'})
          })
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
        }
      })
      }
    },
    created(){
      this.allProduct();
    }

    }

</script>