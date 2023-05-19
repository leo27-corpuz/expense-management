<template>
    <div class="login-container">
        <div class="sub-container">
            <div class="login-form">
                <div class="title">
                    <p>Login Your Account</p>
                </div>
                <form @submit.prevent="loginSubmit">
                    <div class="wrap-input">
                        <div class="form-input-container">
                            <label for="">Email</label>
                            <div class="input">
                                <input type="email"  v-model="loginData.email" placeholder="Sample@gmail.com">
                                <p v-if="error.email" v-for="error in error.email">{{ error }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="wrap-input">
                        <div class="form-input-container">
                            <label for="">Password</label>
                            <div class="input">
                                <input type="password" v-model="loginData.password" placeholder="e-g5Abc-z">
                                <p v-if="error.password" v-for="error in error.password">{{ error }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="wrap-button">
                        <button v-bind:disabled="statusSubmit" :class="statusSubmit ? 'disabledCursor' : ''">
                            <span>Login</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <transition name="slide-fade">
        <loadingComponent v-if="statusSubmit"> 
            <p>{{ loadingMessage }}</p>
        </loadingComponent>
    </transition>
</template>
<script>
import axiosIntance from '../../composable/axios.comp';
import loadingComponent from '../essentials/loadingComponent.vue'
export default{
    data(){
        return {
            loginData: {
                email: '',
                password: ''
            },
            error: [],
            statusSubmit: false,
            loadingMessage: ''
        }
    },
    components: {
        loadingComponent
    },
    methods: {
        async loginSubmit(){
            this.statusSubmit = !this.statusSubmit
            this.loadingMessage = 'Processing..'
            try {
                const formData = new FormData();
                formData.append('email', this.loginData.email);
                formData.append('password', this.loginData.password);
                const response = await axiosIntance.post('/api/login', formData)
                const res = await response.data
                localStorage.setItem("token", res.token);
                localStorage.setItem("role", res.userRole);
                setTimeout(() => {
                    this.statusSubmit = !this.statusSubmit
                    setTimeout(() => {
                        this.loadingMessage = ''
                        this.error = []
                        if(res.userRole == 1){
                            this.$router.push('/admin')
                        }else{
                            this.$router.push('/users')
                        }
                    }, 1000)
                }, 900)
            } catch (error) {
                setTimeout(() => {
                    this.statusSubmit = !this.statusSubmit
                    setTimeout(() => {
                        this.loadingMessage = ''
                        this.error = error.response.data.error
                    }, 1000)
                }, 900)
            }
        }
    }
}
</script>
<style scoped>
    .login-container{
        width: 100%;
        height: 100vh;
        display: grid;
        margin: 0;
        place-items: center;
    }
    .login-container > .sub-container{
        width: 40%;
        background: #ffffff;
        padding: 30px;
        border-radius: 7px;
    }
    .login-container > .sub-container > .login-form > .title{
        margin: 2em 0;
        text-align: center;
    }
    .login-container > .sub-container > .login-form > .title > p{
        font-size: 20px;
        letter-spacing: 1px;
        color: #747474;
    }
    .login-container > .sub-container > .login-form > form{
        width: 100%;
    }
    .login-container > .sub-container > .login-form > form > .wrap-input{
        width: 100%;
        margin-bottom: 30px;
    }
    .login-container > .sub-container > .login-form > form > .wrap-input > .form-input-container{
        width: 100%;
        margin-bottom: 1em;
    }
    .login-container > .sub-container > .login-form > form > .wrap-input > .form-input-container > label{
        font-size: 16px;
        letter-spacing: 1.2px;
        color: #383838;
        line-height: 1.5;
        text-align: center;
    }
    .login-container > .sub-container > .login-form > form > .wrap-input > .form-input-container > .input{
        width: 100%;
        margin-top: 10px;
        position: relative;
    }
    .login-container > .sub-container > .login-form > form > .wrap-input > .form-input-container > .input > input{
        width: 100%;
        font-size: 16px;
        padding: 15px;
        border-radius: 7px;
        border: solid rgba(0, 0, 0, 0.2) 0.5px;
        color: rgba(24, 24, 24, 0.5);
        outline: none;
        letter-spacing: 1.5px;
        transition: all 0.5s ease-out;
        transition: all 0.5 ease-out;
    }
    .login-container > .sub-container > .login-form > form > .wrap-input > .form-input-container > .input > p{
        font-size: 14px;
        letter-spacing: 1.5px;
        margin: 5px 2px;
        color: darkred;
    }
    .login-container > .sub-container > .login-form > form > .wrap-input > .form-input-container > .input > input:focus{
        box-shadow: rgba(39, 128, 212, 0.3) 0px 0px 0px 1px, rgba(32, 104, 197, 0.3) 0px 0px 0px 1px;
        color: #1D1D41;
        border: solid rgba(197, 106, 32, 0.3) 1.5px;
    }
    .login-container > .sub-container  >.login-form > form > .wrap-button{
        width: 100%;
        margin-top: 35px;
        margin-bottom: 25px;
    }
    .login-container > .sub-container >.login-form > form > .wrap-button > button{
        background: #28274F;
        border: none;
        padding: 15px 19px;
        border-radius: 50px;
        width: 50%;
        font-size: 16px;
        cursor: pointer;
        letter-spacing: 2px;
        color: #ffffff;
        transition: all 0.5s ease-out;
    }
    .login-container > .sub-container >.login-form > form > .wrap-button > button:hover{
        background: #1D1D41;
        transform: translateY(-5px);
    }

</style>