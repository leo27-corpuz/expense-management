<template>
    <RouterView />
</template>
<script>
import { RouterView } from 'vue-router'
import userData from './composable/ComposableUserData.js'
export default{
    data(){
    },
    watch: {
        '$route': function(newVal, oldVal) {
            userData(localStorage.getItem("token"), localStorage.getItem("role"))
        },
  }
}
</script>