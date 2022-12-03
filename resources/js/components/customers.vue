<template>
    <div class="container">
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
                <button type="submit" class="btn btn-success btn-lg">حفظ</button>
        </form>
        <table class="table table-hover">
            <thead>
            <tr>
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
                <td>{{ customer.name }}</td>
                <td>{{ customer.phone }}</td>
                <td>{{ customer.type }}</td>
                <td>{{ customer.location }}</td>
                <td>
                    <button class="btn btn-success mx-2 my-2 text-center">تعديل</button>
                    <button class="btn btn-danger">حذف</button>
                </td>
            </tr>
            </tbody>
        </table>
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
            })
        },
    }
}
</script>

