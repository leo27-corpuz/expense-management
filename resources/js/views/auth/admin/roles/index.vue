<template>
    <section>
        <rolesComponent v-if="path === '/admin/roles'"/>
        <router-view v-else @successEmit="successEmit"></router-view>
        <transition name="slide-fade">
            <successPopup v-if="successMessage">
                <p class="successmessage">{{ successMessage }}</p>
            </successPopup>
        </transition>
    </section>
</template>
<script>
import rolesComponent from '../../../../components/auth/admin/pages/rolesComponent.vue'
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
        rolesComponent, successPopup
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