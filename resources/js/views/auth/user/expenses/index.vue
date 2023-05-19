<template>
    <section>
        <expensesComponent v-if="path === '/user/expenses'" @successEmit="successEmit"/>
        <router-view v-else @successEmit="successEmit"></router-view>
        <transition name="slide-fade">
            <successPopup v-if="successMessage">
                <p class="successmessage">{{ successMessage }}</p>
            </successPopup>
        </transition>
    </section>
</template>
<script>
import expensesComponent from '../../../../components/auth/user/pages/expensesComponent.vue'
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
        expensesComponent, successPopup
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