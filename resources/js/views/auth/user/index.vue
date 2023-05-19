<template>
    <headerComponent />
    <transition name="slide-fade">
        <siderbarCopmonent/>
    </transition>
    <main class="main-useradmin">
        <RouterView/>
    </main>
</template>
<script>
import { RouterLink, RouterView } from 'vue-router'
import headerComponent from '../../../components/auth/user/headerComponent.vue'
import siderbarCopmonent from '../../../components/auth/user/siderbarCopmonent.vue'
export default{
    components: {
        headerComponent, siderbarCopmonent
    }
}
</script>