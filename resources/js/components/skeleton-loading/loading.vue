<template>
    <div class="skeleton-form">
        <div class="head">
            <div class="skel1"></div>
        </div>
        <div class="body">
            <div class="card-skeleton"></div>
            <div class="card-skeleton"></div>
            <div class="card-skeleton"></div>
        </div>
    </div>
</template>
<style scoped>
    .skeleton-form{
        width: 100%;
    }
    
    .skeleton-form > .head{
        width: 100%;
    }
    
    .skeleton-form > .head > .skel1{
        width: 20em;
        height: 35px;
        background: #e9e9e9;
        background: linear-gradient(110deg, #e9e9e9 8%, rgb(243, 243, 243) 18%, #e9e9e9 33%);
        background-size: 200% 100%;
        animation: 1.5s shine-skeleton linear infinite;
        margin-bottom: 30px;
        border-radius: 7px;
    }
    .skeleton-form > .head > .skel2{
        width: 10em;
        height: 35px;
        float: right;
        background: #e9e9e9;
        background: linear-gradient(110deg, #e9e9e9 8%, rgb(243, 243, 243) 18%, #e9e9e9 33%);
        background-size: 200% 100%;
        animation: 1.5s shine-skeleton linear infinite;
        margin-bottom: 30px;
        border-radius: 7px;
    }
    .body{
        width: 100%;
        margin-top: 2em;
    }
    .body > * {
        margin-bottom: 10px;
        width: 100%;
        background: #e9e9e9;
        background: linear-gradient(110deg, #e9e9e9 8%, rgb(243, 243, 243) 18%, #e9e9e9 33%);
        background-size: 200% 100%;
        animation: 1.5s shine-skeleton linear infinite;
        border-radius: 15px;
        position: relative;
    }
    .body > :nth-child(1){
        height: 50px;
    }
    .body > :nth-child(2){
       height: 200px;
    }
    .body > :nth-child(3){
     height: 100px;
    }
    @keyframes shine-skeleton {
        to {
            background-position-x: -200%;
        }
    }
</style>