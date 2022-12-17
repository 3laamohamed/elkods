<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <form @submit.prevent="savCustomersMoney">
                    <div class="mb-3">
                        <label for="phone" class="form-label">العميل</label>
                        <select class="form-select" v-model="customer">
                            <option v-for="(customer, index) in customers" :key="index" :value="customer.id">{{customer.name}}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">المبلع المدفوع</label>
                        <input v-model="money" type="text" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <textarea v-model="note" class="form-control" placeholder="الملاحظات"></textarea>
                    </div>
                    <div class="d-grid col-md-6 mx-auto">
                        <button type="submit" class="btn btn-success">حفظ</button>
                    </div>
                </form>
            </div>
            <div class="col-md-8">
                <div class="table-responsive position-relative">
                    <table class="table table-hover table-striped text-center">
                        <thead>
                        <tr class="table-dark sticky-top">
                            <th>#</th>
                            <th>العميل</th>
                            <th>المال</th>
                            <th>الوقت</th>
                            <th>ملاحظات</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(customer,index) in data" :id="customer.id">
                            <td>{{ customer.id }}</td>
                            <td>
                                <span>{{ customer.customer }}</span>
                            </td>
                            <td>
                                <span v-if="edit != customer.id">{{ customer.money }}</span>
                                <input class="form-control text-center" type="text" v-model="updateMoney" v-else>
                            </td>
                            <td>
                                <span>{{ customer.time }}</span>
                            </td>
                            <td>
                                <span>{{ customer.note }}</span>
                            </td>
                            <td>
                                <button class="btn btn-primary mx-2 my-2 text-center" v-if="edit != customer.id" @click="changeRow(customer)">تعديل</button>
                                <div class="d-grid mx-auto" v-else>
                                    <button class="btn btn-success" @click="updateCustomer(index)">حفظ</button>
                                </div>
                                <button class="btn btn-danger mx-2" v-if="edit != customer.id" @click="deleteCustomer(customer.id,index)">حذف</button>
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
            money:'',
            customer:'',
            customers:[],
            note:'',
            data:[],
            edit : '',
            updateMoney:'',
        }
    },
    mounted() {
        this.getCustomers()
    },
    methods:{
        getCustomers(){
            axios.post('/getCustomersMoney').then((res)=>{
                res.data.customers.forEach((customer)=>{
                    this.customers.push({
                        id:customer.id,
                        name:customer.name,
                        money:customer.money,
                    })
                });
                res.data.data.forEach((loc)=>{
                    this.data.push({
                        id:loc.id,
                        customer:loc.customers.name,
                        money:loc.money,
                        time:loc.time,
                        note:loc.note
                    })
                });
            });
        },
        savCustomersMoney(){
            axios.post('/saveCustomersMoney',{
                customer:this.customer,
                money:this.money,
                note:this.note,
            }).then(res=>{
                this.data.push({
                    id:res.data.add.id,
                    customer:res.data.add.customers.name,
                    money:res.data.add.money,
                    time:res.data.add.time,
                    note:res.data.add.note
                })
                this.money = ''
                this.customer = ''
                this.note = ''
                this.viewAlert(res.data.status , res.data.data)
            }).catch(e => {
                let errors = e.response.data.errors
                let status = false;
                (errors.money) ? this.viewAlert(status,errors.money[0]) : false;
                (errors.customer) ? this.viewAlert(status,errors.customer[0]) : false;
            })
        },
        changeRow(customer){
            this.edit = customer.id
            this.updateMoney = customer.money
        },
        updateCustomer(index){
            axios.post('/updateCustomersMoney',{
                id:this.edit,
                money:this.updateMoney,
            }).then(response => {
                if (response.data.status == true) {
                    this.data[index].money = this.updateMoney
                    this.edit = ''
                    this.updateMoney = ''
                }
                this.viewAlert(response.data.status , response.data.data)
            })
        },
        deleteCustomer(id,index){
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
                    axios.post('/deletCustomersMoney',{
                        id:id
                    }).then(res=>{
                        if(res.data.status == true){
                            this.data.splice(index,1)
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
