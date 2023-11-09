<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row customer-info">
                    <div class="col-md-3 col-6">
                        <div class="d-flex mt-2">
                            <span class="icon"><i class="fa-sharp fa-solid fa-paperclip fa-lg"></i></span>
                            <input type="number"  class="form-control" value="1">
                            <button class="btn btn-primary">بحث</button>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex mt-2">
                            <span class="icon"><i class="fa-solid fa-user fa-lg"></i></span>
                            <select class="form-select">
                                <option>Alaa</option>
                                <option>Alaa2</option>
                                <option>Alaa3</option>
                                <option>Alaa4</option>
                                <option>Alaa6</option>
                                <option>Alaa</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row customer-info">
                    <div class="col-md-3 col-6">
                        <div class="d-flex mt-2">
                            <span class="icon"><i class="fa-solid fa-cart-shopping fa-lg"></i></span>
                            <select class="form-select">
                                <option>Alaa</option>
                                <option>Alaa2</option>
                                <option>Alaa3</option>
                                <option>Alaa4</option>
                                <option>Alaa6</option>
                                <option>Alaa</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                            <div class="d-flex mt-2">
                                <span class="icon">
                                    <i class="fa-solid fa-weight-scale fa-lg"></i></span>
                                <input type="number"  class="form-control" value="1">
                            </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex mt-2">
                            <span class="icon"><i class="fa-sharp fa-solid fa-money-bill-1 fa-lg"></i></span>
                            <input type="number"  class="form-control" value="1">
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex mt-2">
                            <span class="icon"><i class="fa-solid fa-sack-dollar fa-lg"></i></span>
                            <input type="number"  class="form-control" value="1">
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex mt-2">
                            <button class="btn btn-info">تنزيل</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="table-responsive position-relative">
                    <table class="table table-hover table-striped text-center">
                        <thead>
                        <tr class="table-dark sticky-top">
                            <th>#</th>
                            <th>الاسم</th>
                            <th>متوسط السعر</th>
                            <th>اخر سعر</th>
                            <th>سعر البيع</th>
                            <th>الكمية</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(product,index) in products" :id="product.id">
                            <td>{{ product.id }}</td>
                            <td>
                                <span v-if="edit != product.id">{{ product.name }}</span>
                                <input class="form-control text-center" type="text" v-model="updateName" v-else>
                            </td>
                            <td>
                                <span>{{ product.price }}</span>
                            </td>
                            <td>
                                <span>{{ product.l_price }}</span>
                            </td>
                            <td>
                                <span v-if="edit != product.id">{{ product.pay_price }}</span>
                                <input class="form-control text-center" type="text" v-model="updatePrice" v-else>
                            </td>
                            <td>
                                <span v-if="edit != product.id">{{ product.qty }}</span>
                                <input class="form-control text-center" type="text" v-model="updateQty" v-else>

                            </td>
                            <td>
                                <button class="btn btn-primary mx-2 my-2 text-center" v-if="edit != product.id" @click="changeRow(product)">تعديل</button>
                                <div class="d-grid mx-auto" v-else>
                                    <button class="btn btn-success" @click="updateProduct(index)">حفظ</button>
                                </div>
                                <button class="btn btn-danger mx-2" v-if="edit != product.id" @click="deleteProduct(product.id,index)">حذف</button>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    data() {
        return {
            name:'',
            price:0,
            qty:0,
            pay_price:0,
            products:[],
            edit:'',
            updateName:'',
            updatePrice:'',
            updateQty:'',
        }
    },
    mounted() {
        this.getProducts()
    },
    methods:{
        getProducts(){
            axios.post('/getProducts').then((res)=>{
                this.products = res.data.products
            });
        },
        savProducts(){
            axios.post('/savProducts',{
                name:this.name,
                price:this.price,
                qty:this.qty,
                pay_price:this.pay_price,
                location:this.location,
            }).then(res=>{
                console.log(res.data)
                this.products.push(res.data.product);
                this.name = ''
                this.price = 0
                this.pay_price = 0
                this.qty = 0
                this.viewAlert(res.data.status , res.data.msg)
            }).catch(e => {
                let errors = e.response.data.errors
                let status = false;
                (errors.pay_price) ? this.viewAlert(status,errors.pay_price[0]) : false;
                (errors.price) ? this.viewAlert(status,errors.price[0]) : false;
                (errors.qty) ? this.viewAlert(status,errors.qty[0]) : false;
                (errors.name) ? this.viewAlert(status,errors.name[0]) : false;
            })
        },
        changeRow(product){
            this.edit = product.id
            this.updateName = product.name
            this.updatePrice = product.pay_price
            this.updateQty = product.qty
        },
        updateProduct(index){
            axios.post('/updateProduct',{
                id:this.edit,
                name:this.updateName,
                pay_price:this.updatePrice,
                qty:this.updateQty,
            }).then(response => {
                if (response.data.status == true) {
                    this.products[index] = response.data.product
                    this.edit = ''
                    this.updateName = ''
                    this.pay_price = ''
                    this.qty = ''
                }
                this.viewAlert(response.data.status , response.data.data)
            })
        },
        deleteProduct(id,index){
            this.$swal.fire({
                title: 'هل انتا متأكد من الحذف؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'الغاء',
                confirmButtonText: 'حذف'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/deleteProduct',{
                        id:id
                    }).then(res=>{
                        if(res.data.status == true){
                            this.products.splice(index,1)
                        }
                        this.viewAlert(res.data.status,res.data.data)
                    })
                }
            })

        },
        viewAlert(status,data){
            if(status == true){
                this.$swal({
                    position: 'center-center',
                    icon: 'success',
                    title: data,
                    showConfirmButton: false,
                    timer: 1500
                })
            }else{
                this.$swal({
                    position: 'center-center',
                    icon: 'error',
                    title: data,
                    showConfirmButton: true,
                })
            }
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
    max-height: 380px;
}
.select-box{
    width: 125px;
}
</style>

