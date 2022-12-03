<template>
    <div class="container">
        <form @submit.prevent="saveInfo">
            <div class="col-md-6 mx-auto">
                <div class="text-center">
                    <img :src="info.logo" width="200" height="200" :alt="info.name">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">الشركة</label>
                    <input v-model="info.name" type="text" class="form-control" id="name">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">الهاتف</label>
                    <input type="text" v-model="info.phone" class="form-control" id="phone">
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">العنوان</label>
                    <input type="text" v-model="info.location" class="form-control" id="location">
                </div>
                <div class="d-grid col-md-6 mx-auto">
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
            </div>
        </form>
    </div>

</template>
<script>
export default {
    data() {
        return {
            info:[],
        }
    },
    mounted() {
        this.fetchInfo()
    },
    methods:{
        fetchInfo(){
            axios.post('/getInfo').then((res)=>{
                if(res.data.status == true){
                    this.info.name = res.data.info.name
                    this.info.phone = res.data.info.phone
                    this.info.location = res.data.info.location
                    this.info.logo = res.data.info.logo
                }
                console.log(res)
            });
        },
        saveInfo(){
            axios.post('/saveInfo',{
                name:this.info.name,
                phone:this.info.phone,
                location:this.info.location
            })
        }
    }
}
</script>

