<template>
     <div class="loading-container">
        <span class="loader"></span>
        <slot></slot>
    </div>
</template>
<style scoped>
    .loading-container{
        position: fixed;
        right: 2em;
        top: 3em;
        z-index: 100;
        background: #ffffff;
        padding: 12px 30px 12px 12px; 
        display: flex;
        flex-direction: row;
        grid-gap: 10px;
        border-radius: 7px;
    }
    .loader {
    width: 25px;
    height: 25px;
    border: 5px solid rgba(185, 185, 185, 0.6);
    border-bottom-color: #28274F;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    } 
</style>