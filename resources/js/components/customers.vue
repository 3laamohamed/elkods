<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <form @submit.prevent="savCustomers">
                    <div class="mb-3">
                        <label for="name" class="form-label">اسم العميل</label>
                        <input v-model="name" type="text" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label"> رقم الهاتف</label>
                        <input v-model="phone" type="text" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">النوع</label>
                        <select class="form-select" v-model="type">
                            <option value="عميل">عميل</option>
                            <option value="مورد">مورد</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">المنطقة</label>
                        <select class="form-select" v-model="location">
                            <option v-for="(location, index) in locations" :key="index" :value="location.id">{{location.name}}</option>
                        </select>
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
                            <th>رقم الهاتف</th>
                            <th>النوع</th>
                            <th>المنطقة</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(customer,index) in customers" :id="customer.id">
                            <td>{{ customer.id }}</td>
                            <td>
                                <span v-if="edit != customer.id">{{ customer.name }}</span>
                                <input class="form-control text-center" type="text" v-model="updateName" v-else>
                            </td>
                            <td>
                                <span v-if="edit != customer.id">{{ customer.phone }}</span>
                                <input class="form-control text-center" type="text" v-model="updatePhone" v-else>
                            </td>
                            <td>
                                <span v-if="edit != customer.id">{{ customer.type }}</span>
                                <select class="form-select select-box" v-model="updateType" v-else>
                                    <option value="عميل" >عميل</option>
                                    <option value="مورد">مورد</option>
                                </select>
                            </td>
                            <td>
                                <span v-if="edit != customer.id">{{ customer.location }}</span>
                                <select class="form-select select-box" v-model="updateLocationId" v-else>
                                    <option v-for="(location, index) in locations" :key="index" :value="location.id">{{location.name}}</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-primary mx-2 my-2 text-center" v-if="edit != customer.id" @click="changeRow(customer)">تعديل</button>
                                <button class="btn btn-success mx-2 my-2 text-center" v-else @click="updateCustomer(index)">حفظ</button>
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
            location:'',
            type:'',
            name:'',
            phone:'',
            customers:[],
            locations:[],
            edit:'',
            updateName:'',
            updatePhone:'',
            updateType:'',
            updateLocationId:'',
            updateLocationName:'',
        }
    },
    mounted() {
        this.getCustomers()
    },
    methods:{
        getCustomers(){
            axios.post('/getCustomers').then((res)=>{
                res.data.customers.forEach((customer)=>{
                    this.customers.push({
                        id:customer.id,
                        phone:customer.phone,
                        name:customer.name,
                        location:customer.location.name,
                        locationsId:customer.location.id,
                        type:customer.type,
                    })
                });
                res.data.locations.forEach((loc)=>{
                    this.locations.push({
                        id:loc.id,
                        name:loc.name,
                    })
                });
            });
        },
        savCustomers(){
            axios.post('/savCustomers',{
                name:this.name,
                phone:this.phone,
                type:this.type,
                location:this.location,
            }).then(res=>{
                this.customers.push({
                    id:res.data.id,
                    phone:this.phone,
                    name:this.name,
                    type:this.type,
                    location:this.locations.find(loc => loc.id == this.location ).name,
                });
                this.name = ''
                this.phone = ''
                this.type = ''
                this.location = ''
                this.viewAlert(res.data.status , res.data.data)
            }).catch(e => {
                let errors = e.response.data.errors
                let status = false;
                (errors.type) ? this.viewAlert(status,errors.type[0]) : false;
                (errors.location) ? this.viewAlert(status,errors.location[0]) : false;
                (errors.name) ? this.viewAlert(status,errors.name[0]) : false;
            })
        },
        changeRow(customer){
            this.edit = customer.id
            this.updateName = customer.name
            this.updatePhone = customer.phone
            this.updateType = customer.type
            this.updateLocationId = customer.locationsId
        },
        updateCustomer(index){
            this.updateLocationName = this.locations.find(location => location.id == this.updateLocationId ).name
            axios.post('/updatCustomers',{
                id:this.edit,
                phone:this.updatePhone,
                name:this.updateName,
                location:this.updateLocationId,
                type:this.updateType,
            }).then(response => {
                if (response.data.status == true) {
                    this.customers[index] = {
                        id:this.edit,
                        phone:this.updatePhone,
                        name:this.updateName,
                        locationsId:this.updateLocationId,
                        type:this.updateType,
                        location:this.updateLocationName
                    }
                    this.edit = ''
                    this.updateName = ''
                    this.updatePhone = ''
                    this.updateType = ''
                    this.updateLocationId = ''
                    this.updateLocationName = ''
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
                    axios.post('/deletCustomers',{
                        id:id
                    }).then(res=>{
                        if(res.data.status == true){
                            this.customers.splice(index,1)
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

