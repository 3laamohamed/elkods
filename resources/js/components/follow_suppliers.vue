<template>
    <div class="container">
        <div class="col-md-6">
            <div class="d-flex align-items-end gap-2">
                <div class="flex-grow-1">
                    <label for="phone" class="form-label">المنطقة</label>
                    <select class="form-select" v-model="location">
                        <option value="all">الجميع</option>
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
                    <th scope="col">الكمية</th>
                    <th scope="col">الاجمالي</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(customer, index) in customers" :key="customer.id">
                        <td>{{customer.id}}</td>
                        <td>{{customer.name}}</td>
                        <td>{{customer.qty}}</td>
                        <td>{{customer.total}}</td>
                        <td>
                            <button class="btn btn-primary mx-2 my-2 text-center" @click="changeRow(customer.id)">تفاصيل</button>
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
            location:'all',
            edite:'',
            customerLink: ''

        }
    },
    mounted() {
        this.getLocations()
    },
    methods:{
        getLocations(){
            this.customers = []
            axios.post('/getCustomersPeriod').then((res)=>{
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
            axios.post('/getCustomersPeriodLocation',{
                id:this.location
            }).then((res)=> {
                this.customers = res.data.customers
            })
        },
        changeRow(customer){
            window.location= `/detailsSupplier/supplier/${customer}`
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

