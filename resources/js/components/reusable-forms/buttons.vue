<template>
    <div class="wrap-button">
        <button v-bind:disabled="statusSubmit" :class="statusSubmit ? 'disabledCursor' : ''">
            <span>{{buttonTitle}}</span>
        </button>
    </div>
</template>
<script>
export default{
    props: {
        statusSubmit: Boolean,
        buttonTitle: String
    }
}
</script>
<style scoped>
    .wrap-button{
        width: 100%;
        text-align: right;
    }
    .wrap-button > button{
        background: #1D1D41;
        border: none;
        padding: 12px 25px;
        border-radius: 7px;
        width: auto;
        font-size: 16px;
        cursor: pointer;
        letter-spacing: 1.7px;
        color: #b6b5b5;
        transition: all 0.5s ease-out;
    }
    .wrap-button > button:hover{
        color: #ffffff;
        background: #28274F;
    }
    .disabledCursor{
        cursor: not-allowed !important;
    }
</style>