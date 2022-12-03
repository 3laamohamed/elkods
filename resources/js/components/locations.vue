<template>
    <div class="container">
        <form @submit.prevent="saveLocation">
            <div class="mb-3">
                <label for="name" class="form-label">المنطقة</label>
                <input v-model="name" type="text" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">بداية المدة</label>
                <select class="form-select" v-model="s_period">
                    <option v-for="(period, index) in periods" :key="index" :value="period.id">{{period.name}}</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">نهاية المدة</label>
                <select class="form-select" v-model="e_period">
                    <option v-for="(period, index) in periods" :key="index" :value="period.id">{{period.name}}</option>
                </select>
            </div>
                <button type="submit" class="btn btn-success btn-lg">حفظ</button>
        </form>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>المنطقة</th>
                <th>بداية المدة</th>
                <th>نهاية المدة</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(loc,index) in locations" :id="loc.id">
                <td>{{ loc.id }}</td>
                <td>{{ loc.name }}</td>
                <td>{{ loc.s_period }}</td>
                <td>{{ loc.e_period }}</td>
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
            s_period:'',
            e_period:'',
            name:'',
            periods:[],
            locations:[],

        }
    },
    mounted() {
        this.fetchInfo()
    },
    methods:{
        fetchInfo(){
            axios.post('/getLocations').then((res)=>{
                res.data.periods.forEach((period)=>{
                    this.periods.push({
                        id:period.id,
                        name:period.name,
                    })
                });
                res.data.locations.forEach((loc)=>{
                    this.locations.push({
                        id:loc.id,
                        name:loc.name,
                        s_period:loc.startperiod.name,
                        e_period:loc.endperiod.name,
                    })
                });
            });
        },
        saveLocation(){
            axios.post('/saveLocation',{
                name:this.name,
                s_period:this.s_period,
                e_period:this.e_period,
            })
        },
    }
}
</script>

