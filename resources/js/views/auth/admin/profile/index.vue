<template>
    <section>
        <profileComponent v-if="path === '/admin/profile'" @successEmit="successEmit"/>
        <router-view v-else @successEmit="successEmit"></router-view>
        <transition name="slide-fade">
            <successPopup v-if="successMessage">
                <p class="successmessage">{{ successMessage }}</p>
            </successPopup>
        </transition>
    </section>
</template>
<script>
import profileComponent from '../../../../components/auth/admin/pages/profileComponent.vue'
import successPopup from '../../../../components/essentials/successPopup.vue'
export default{
    data(){
        return {
            path: this.$route.path,
            successMessage: '',
        }
    },
    watch: {
        '$route.path'(newVal, oldVal) {
            this.path = newVal
        },
    },
    components: {
        profileComponent, successPopup
    },
    methods: {
        successEmit(payload){
            this.successMessage = payload
            setTimeout(() => {
                this.successMessage = ''
            }, 3000)
        }
    }
}
</script>