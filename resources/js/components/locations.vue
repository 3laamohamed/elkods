<template>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
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
                    <div class="d-grid col-md-6 mx-auto">
                        <button type="submit" class="btn btn-success ">حفظ</button>
                    </div>

                </form>
            </div>
            <div class="col-md-7">
                <div class="table-responsive position-relative">
                    <table class="table table-hover table-striped text-center">
                        <thead>
                        <tr class="table-dark sticky-top">
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
                            <td>
                                <span v-if="edit != loc.id">{{ loc.name }}</span>
                                <input class="form-control text-center" type="text" v-model="update_name" v-else/>
                            </td>
                            <td>
                                <span  v-if="edit != loc.id">{{ loc.s_period }}</span>
                                <select class="form-select" v-else v-model="update_s_period">
                                    <option  v-for="(period, index) in periods" :key="index" :value="period.id">{{period.name}}</option>
                                </select>
                            </td>
                            <td>
                                <span v-if="edit != loc.id">{{ loc.e_period }}</span>
                                <select class="form-select" v-else v-model="update_e_period">
                                    <option v-for="(period, index) in periods" :key="index" :value="period.id">{{period.name}}</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-primary mx-2 my-2 text-center" v-if="edit != loc.id" @click="changeRow(loc)">تعديل</button>
                                <button class="btn btn-success mx-2 my-2 text-center" v-else @click="updateLocations(index)">حفظ</button>
                                <button class="btn btn-danger mx-2" v-if="edit != loc.id" @click="deleteLocations(loc.id,index)">حذف</button>
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
            s_period:'',
            e_period:'',
            name:'',
            periods:[],
            locations:[],
            edit:null,
            update_s_period:'',
            update_e_period:'',
            update_s_name:'',
            update_e_name:'',
            update_name:'',

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
                        s_period_id:loc.startperiod.id,
                        e_period:loc.endperiod.name,
                        e_period_id:loc.endperiod.id,
                    })
                });
            });
        },
        saveLocation(){
            axios.post('/saveLocation',{
                name:this.name,
                s_period:this.s_period,
                e_period:this.e_period,
            }).then(res=>{
                this.locations.push({
                    id:res.data.id,
                    name:this.name,
                    s_period:this.periods.find(period => period.id == this.s_period ).name,
                    s_period_id:this.s_period,
                    e_period:this.periods.find(period => period.id == this.e_period ).name,
                    e_period_id:this.e_period,
                });
                    this.name = ''
                    this.s_period = ''
                    this.e_period = ''
            })
        },
        changeRow(loc) {
            this.edit = loc.id
            this.update_name = loc.name
            this.update_s_period = loc.s_period_id
            this.update_e_period = loc.e_period_id
        },
        updateLocations(index) {
            this.update_s_name = this.periods.find(period => period.id == this.update_s_period ).name
            this.update_e_name = this.periods.find(period => period.id == this.update_e_period ).name
            axios.post('/updateLocation', {
                id: this.edit,
                name:this.update_name,
                s_period:this.update_s_period,
                e_period:this.update_e_period,
            }).then(response => {
                if (response.data.status == true) {
                    this.locations[index] = {
                        id:this.edit,
                        name:this.update_name,
                        s_period:this.update_s_name,
                        s_period_id:this.update_s_period,
                        e_period:this.update_e_name,
                        e_period_id:this.update_e_period,
                    }
                    this.edit = ''
                    this.update_name = ''
                    this.update_s_period = ''
                    this.update_e_period = ''
                    this.update_s_name = ''
                    this.update_e_name = ''
                }
            })
        },
        deleteLocations(id,index){
            axios.post('/deleteLocation',{
                id:id,
            }).then(res=>{
                if(res.data.status == true){
                    this.locations.splice(index,1)
                }
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
    max-height: 320px;
}
</style>

