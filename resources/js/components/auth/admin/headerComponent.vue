<template>
    <header class="header-admin">
        <div class="sub-container">
        </div>
        <div class="sub-container">
            <div class="admin-info">
                <div class="clickable" @click="showSetting"  ref="target1">
                    <i class="fa-solid fa-user"></i>
                    <p>{{ userName }} (admin)</p>
                    <i class="fa-solid fa-angle-down"></i>
                </div>
               <transition name="slide-top-fade" v-show="settingStatus" @click="handleClick">
                    <ul class="dropdown"  ref="targetV2">
                        <router-link :to="{name: 'profileadmin'}"><li><i class="fa-regular fa-user"></i> <p>Profile</p></li></router-link>
                        <a @click="logout"><li><i class="fa-solid fa-right-from-bracket"></i> <p>Logout</p></li></a>
                    </ul>
               </transition>
            </div>
        </div>
    </header>
</template>
<script>
import axiosIntance from '../../../composable/axios.comp';
export default{
    data(){
        return {
            settingStatus: false,
            userName: ''
        }
    },
    mounted(){
        document.addEventListener("click", this.handleClick);
    },
    created(){
        const promisegetUserData = this.getUserData();
        Promise.all([promisegetUserData]).then(() => {
            
        })
    },
    methods: {
        showSetting(){
            this.settingStatus = !this.settingStatus
        },
        handleClick(){
            const target1 = this.$refs.target1
            const targetV2 = this.$refs.targetV2
            if(targetV2){
                if( !target1.contains(event.target) && !targetV2.contains(event.target)){
                    this.settingStatus = false
                }
            }
        },
        async logout(){
            try {
                const config = {
                    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
                };
                const response = await axiosIntance.get('/api/admin/auth/logout', config)
                const res = await response.data
                if(res){
                    localStorage.removeItem("token");
                    localStorage.removeItem("role");
                    this.$router.push({name: 'loginpage'})
                }
            } catch (error) {
                console.log(error)
            }
        },
        async getUserData(){
            try {
                const config = {
                    'Content-Type': 'application/json',
                    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
                };
                const response = await axios.get('http://127.0.0.1:8000/api/isLogin', config)
                let res = await response.data
                this.userName = res.name
            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>
<style scoped>
  .header-admin{
    display: flex;
        justify-content: space-between;
        padding: 15px 60px;
        box-shadow:rgba(0, 0, 0, 0.1) 0px 2px 2px;
        width: calc(100% - 19em);
        margin-left: auto;
        z-index: 100;
        background: #ffffff;
        transition: all 0.8s ease-in-out;
    }
    .header-admin > .sub-container{
        margin: auto 0;
    }
    .header-admin > .sub-container > .admin-info {
        position: relative;
        font-size: 16px;
        color: rgba(24, 24, 24, 0.5);
        padding: 13px 15px 10px 15px;
        text-align: center;
        border-radius: 6px;
        transition: all 0.5s ease-out;
        margin-left: 0;
    }
    .header-admin > .sub-container > .admin-info > .clickable {
        cursor: pointer;
    }
    .header-admin > .sub-container > .admin-info > .clickable > *{
        display: inline;
        margin-left: 10px;
    }
    .header-admin > .sub-container > .admin-info > .clickable > :nth-child(1){
        font-size: 18px;
    }
    .dropdown{
        position: absolute;
        background: #ffffff;
        display: flex;
        right: 0;
        top: 3em;
        flex-direction: column;
        width: 15em;
        padding: 13px 20px;
        z-index: 100;
        border-radius: 7px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 5px;
    }
    .dropdown > *{
        width: 100%;
        padding: 12px;
        background: #EEF1F4;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 5px;
        margin: 7px 0;
        text-align: left;
        border-radius: 10px;
        transition: all 0.5s ease-out;
        color: rgba(24, 24, 24, 0.5);
        cursor: pointer;
    }
    .dropdown > .active{
        background: #28274F !important;
        color: #ffffff !important;
    }
    .dropdown > *:hover{
        background: #28274F;
        color: #ffffff;
    }
    .dropdown > * > li{
        display: flex;
    }
    .dropdown > * > li > i{
        font-size: 20px;
    }
    .dropdown > * > li > p{
        font-size: 16px;
        letter-spacing: 1.2px;
        margin: auto 10px;
    }
</style>