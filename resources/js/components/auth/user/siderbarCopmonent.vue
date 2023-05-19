<template>
    <nav class="sidebar">
         <div class="logo">
             <h1>Expense</h1>
         </div>
         <div class="body-siderbar">
             <div class="per-branch">
                 <div class="main">
                     <p>Resources</p>
                     <router-link :to="{name: 'userdashboard'}"><i class="fa-solid fa-house"></i> <p>Dashboard</p></router-link>
                 </div>
                 <div class="bodys">
                     <p>Expenses Management</p>
                     <siderbarNav :navigators="navigatorsExpenseManagment"></siderbarNav>
                 </div>
             </div>
         </div>
     </nav>
 </template>
 <script>
 import siderbarNav from '../admin/siderbarChild/siderbarNav.vue'
 export default{
     data(){
         return {
             logoData: {
                 logoCurrent: '',
                 logoLoadingStatus: false
             },
             navigatorsExpenseManagment: [
                 {
                     name: 'expenseuser',
                     icon: 'fa-solid fa-dollar-sign',
                     title: 'Expenses'
                 },
             ],
         }
     },
     components: {
         siderbarNav
     }
 }
 </script>
 <style scoped>
     .sidebar{
         position: fixed;
         top: 0;
         left: 0;
         width: 19em;
         height: 100%;
         background: #1D1D41;
         z-index: 99;
         overflow-y: auto;
     }
 
 
     .sidebar > .logo{
         width: 100%;
         text-align: center;
         margin: 2em 0 0 0;
     }
     .sidebar > .logo > h1{
         font-size: 35px;
         letter-spacing: 4px;
         color: #ffffff;
         font-weight: 800;
         cursor: pointer;
         white-space: nowrap;
     }
     .sidebar > .logo > a > h1 > span{
         font-family: 'Pacifico', cursive !important;
     }
     .sidebar > .body-siderbar{
         width: 100%;
         padding: 30px 0;
     }
     .sidebar > .body-siderbar > .per-branch{
         width: 100%;
     }
     .sidebar > .body-siderbar > .per-branch > div{
         width: 92%;
         margin: auto auto 30px auto;
     }
     .sidebar > .body-siderbar > .per-branch > div > .router-link-exact-active{
         color: #ffffff;
         background: #28274F;
     }
     .sidebar > .body-siderbar > * > div > p{
         margin: 5px 0 17px 0;
         padding: 0 5px;
         font-size: 15px;
         letter-spacing: 1.5px;
         color: #b6b5b5;
         font-weight: 600;
     }
 </style>