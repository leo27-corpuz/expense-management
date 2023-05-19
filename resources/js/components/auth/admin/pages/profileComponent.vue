<template>
    <article>
        <skeletonLoading v-if="!loadStatusPage"></skeletonLoading>
        <template v-else>
            <div class="title">
                <p>Profile</p>
            </div>
            <div class="profile-view-container">
                <div class="profile-col">
                    <div class="title">
                        <p>Name: </p>
                    </div>
                    <div class="content">
                        <p>{{ userData.name }}</p>
                    </div>
                </div>
                <hr>
                <div class="profile-col">
                    <div class="title">
                        <p>Email: </p>
                    </div>
                    <div class="content">
                        <p>{{ userData.email }}</p>
                    </div>
                </div>
                <hr>
                <div class="profile-col">
                    <div class="title">
                        <p>Position: </p>
                    </div>
                    <div class="content">
                        <p>{{ userData.role.title }}</p>
                    </div>
                </div>
                <hr>
                <div class="profile-col">
                    <div class="content">
                        <router-link :to="{ name: 'expenseadminupdatepassword' }"><button>Update
                                Password</button></router-link>
                    </div>
                </div>
            </div>
        </template>
    </article>
</template>
<script>
import skeletonLoading from '../../../skeleton-loading/loading.vue'
export default{
    data(){
        return {
            userData: '',
            loadStatusPage: false
        }
    },
    components: {
        skeletonLoading
    },
    created(){
        const promisegetUserData = this.getUserData();
        Promise.all([promisegetUserData]).then(() => {
            setTimeout(() => {
                this.loadStatusPage = true
            }, 1000)
        })
    },
    methods: {
        async getUserData(){
            try {
                const config = {
                    'Content-Type': 'application/json',
                    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
                };
                const response = await axios.get('http://127.0.0.1:8000/api/isLogin', config)
                let res = await response.data
                this.userData = res
            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>
<style scoped>
    article {
        width: 100% !important;
    }
</style>