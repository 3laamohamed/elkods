<template>
    <div class="container-fluid">
        <div class="col-12">
            <div class="d-flex align-items-end gap-2">
                <div>
                    <label for="phone" class="form-label">المنطقة</label>
                    <select class="form-select" v-model="location">
                        <option  value="all">الجميع</option>
                        <option v-for="(location, index) in locations" :key="index" :value="location.id">{{location.name}}</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" @click="getCustomers">بحث</button>
                <div class="shift-select">
                    <label for="phone" class="form-label">الوردية</label>
                    <select class="form-select" @change="changeShift" v-model="shift">
                        <option  value="صباحي">صباحي</option>
                        <option  value="مسائي">مسائي</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-hover table-striped text-center">
                <thead>
                <tr class="table-dark sticky-top">
                    <th rowspan="2">#</th>
                    <th rowspan="2">اسم العميل</th>
                    <th rowspan="2">النوع</th>
                    <th colspan="2" v-for="(product,index) in products" :value="product.id">{{product.name}}</th>
                    <th rowspan="2"></th>
                </tr>
                <tr class="table-dark sticky-top sticky-top-second">
                    <template v-for="(product,index) in products">
                        <th>سعر</th>
                        <th>كمية</th>
                    </template>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(customer, index) in customers" :key="customer.id">
                        <td>{{customer.id}}</td>
                        <td>{{customer.name}}</td>
                        <td>{{customer.type}}</td>
                        <template v-for="(price, i) in customer.price" :key="price.id">
                            <td>
                                <span v-if="edite!= customer.id">{{price.price}}</span>
                                <div class="input-group" v-if="edite == customer.id">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-sack-dollar"></i></span>
                                    <input type="text" class="form-control text-center" :value="price.price" @input="changePrice(price.id, price.price)">
                                </div>
                            </td>
                            <td>
                                <span v-if="edite!= customer.id">{{price.quantity}}</span>
                                <div class="input-group" v-if="edite == customer.id">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-weight-scale"></i></span>
                                    <input type="number" class="form-control text-center" :value="price.quantity" @input="changeQuantity(price.id,$event.target.value)">
                                </div>
                            </td>
                        </template>
                        <td>
                            <button class="btn btn-primary mx-2 my-2" v-if="edite != customer.id" @click="changeRow(customer)">تعديل</button>
                            <button class="btn btn-success mx-2 my-2" v-else @click="updateCustomer(index, customer.id)">حفظ</button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="table-dark sticky-bottom">
                        <td colspan="3">الاجمالي</td>
                        <template v-for="(total, i) in totalQty" :key="total.id">
                            <td>{{total.price}}</td>
                            <td>{{total.quantity}}</td>
                        </template>
                        <td></td>
                    </tr>
                </tfoot>
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
            shift:'صباحي',
            totalQty: []
        }
    },
    mounted() {
        this.getLocations()
    },
    methods:{
        getLocations(){
            this.customers = []
            axios.post('/getSupplyMilk').then((res)=>{
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
                this.calcFooterTable()
            });
        },
        getCustomers(){
            axios.post('/getCustomersInLocationSupply',{
                id:this.location,
                shift:this.shift
            }).then((res)=> {
                this.customers = res.data.customers
                this.totalQty = []
                this.calcFooterTable()
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
        changeQuantity(priceId,quantity){
            this.updatePrice.forEach(price => {
                if (price.id == priceId) {
                    price.quantity = quantity
                }
            });
        },
        updateCustomer(index,id){
           axios.post('/saveOrderSupply',{
               id:id,
               order:this.updatePrice,
               shift:this.shift
            }).then(res=>{
                if(res.data.status == true){
                    this.customers[index] = res.data.customer
                    this.edite = ''
                    this.totalQty = []
                    this.calcFooterTable()
                    this.$swal({
                        position: 'center-center',
                        icon: 'success',
                        title: res.data.data,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }else if(res.data.status == false){
                    this.edite = ''
                    this.totalQty = []
                    this.calcFooterTable()
                    this.$swal({
                        position: 'center-center',
                        icon: 'error',
                        title: res.data.data,
                        showConfirmButton: true,
                    })
                }
           })
        },
        changeShift(){
          axios.post('/changeShift',{
              shift:this.shift
          }).then(res=>{
              this.customers = res.data.customers
              this.totalQty = []
              this.calcFooterTable()
          })
        },
        calcFooterTable() {
            this.customers.forEach(customer => {
                if(this.totalQty.length == 0) {
                    // this.totalQty = new Array(customer.price.length)
                    customer.price.forEach(qty => {
                        this.totalQty.push({
                            id : qty.type_id,
                            price:qty.price * (qty.quantity || 0),
                            quantity : qty.quantity || 0
                        })
                    })
                }else{
                    customer.price.forEach(qty => {
                        this.totalQty.forEach(total => {
                            if(qty.type_id == total.id){
                                total.price += qty.price * (qty.quantity || 0);
                                total.quantity += qty.quantity || 0
                            }
                        })
                    })
                }
            });
        }
    }
}
</script>
<style scoped>
.shift-select {
    margin-right: auto;
    width: 200px;
}
thead, tbody, tfoot, tr, td, th {
    white-space: nowrap;
    vertical-align: middle !important;
}
.table{
}
.table-responsive{
    max-height: 75vh;
}
.select-box{
    width: 125px;
}
.input-group-text,.form-control{
    border-radius: 0;
}
.sticky-top-second {
    top: 39.974px !important
}
</style>

