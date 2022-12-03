<template>
    <div class="container">
        <div class="col-md-6">
            <div class="d-flex align-items-end gap-2">
                <div class="flex-grow-1">
                    <label for="phone" class="form-label">المنطقة</label>
                    <select class="form-select" v-model="location">
                        <option v-for="(location, index) in locations" :key="index" :value="location.id">{{location.name}}</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" @click="getCustomers">بحث</button>
            </div>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-hover table-striped text-center">
                <thead>
                <tr class="table-dark sticky-top">
                    <th scope="col">#</th>
                    <th scope="col">اسم العميل</th>
                    <th scope="col">النوع</th>
                    <th scope="col" v-for="(product,index) in products" :value="product.id">{{product.name}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(customer, index) in customers" :key="customer.id">
                        <td>{{customer.id}}</td>
                        <td>{{customer.name}}</td>
                        <td>{{customer.type}}</td>
                        <td v-for="(price, i) in customer.price" :key="price.id">
                            <span v-if="edite != customer.id">{{price.price}}</span>
                            <input type="number" class="form-control text-center" v-model="price.price" v-else @input="changePrice(price.id, price.price)">
                        </td>
                        <td>
                            <button class="btn btn-primary mx-2 my-2 text-center" v-if="edite != customer.id" @click="changeRow(customer)">تعديل</button>
                            <button class="btn btn-success mx-2 my-2 text-center" v-else @click="updateCustomer(index, customer.id)">حفظ</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</template>
<script>
export default {
    data() {
        return {
            locations:[],
            products:[],
            updatePrice :[],
            customers:[],
            location:'',
            edite:'',

        }
    },
    mounted() {
        this.getLocations()
    },
    methods:{
        getLocations(){
            this.customers = []
            axios.post('/getLocationsPrice').then((res)=>{
                res.data.locations.forEach((loc)=>{
                    this.locations.push({
                        id:loc.id,
                        name:loc.name,
                    })
                });
                res.data.products.forEach((pro)=>{
                    this.products.push({
                        id:pro.id,
                        name:pro.name,
                    })
                });
                this.customers = res.data.customers
            });
        },
        getCustomers(){
            axios.post('/getCustomersInLocation',{
                id:this.location
            }).then((res)=> {
                this.customers = res.data.customers
            })
        },
        changeRow(customer){
            this.edite = customer.id
            this.updatePrice = customer.price
        },
        changePrice(priceId, newPrice) {
            this.updatePrice.forEach(price => {
                if (price.id == priceId) {
                    price.price = newPrice
                }
            });
        },
        updateCustomer(index,id){
           axios.post('/updateCustomerPrice',{
               id:id,
               price:this.updatePrice
            }).then(res=>{
                this.customers[index].price = this.updatePrice
               this.edite = ''
               this.$swal({
                   position: 'center-center',
                   icon: 'success',
                   title: res.data.data,
                   showConfirmButton: false,
                   timer: 1500
               })
           })
        }
    }
}
</script>
<style scoped>
thead, tbody, tfoot, tr, td, th {
    white-space: nowrap;
}
.table{
    vertical-align: middle;
}
.table-responsive{
    max-height: 500px;
}
.select-box{
    width: 125px;
}
</style>

