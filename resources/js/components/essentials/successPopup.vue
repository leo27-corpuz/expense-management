<template>
    <div class="success-container">
        <slot></slot>
    </div>
</template>
<style scoped>
    .success-container{
        position: fixed;
        right: 2em;
        top: 3em;
        z-index: 100;
        background: #28274F;
        padding: 12px 30px 12px 12px; 
        display: flex;
        flex-direction: row;
        grid-gap: 10px;
        border-radius: 7px; 
    }
</style>