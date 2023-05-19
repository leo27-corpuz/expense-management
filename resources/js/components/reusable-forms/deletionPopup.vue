<template>
    <div class="delete-form">
        <div class="title">
            <p>{{ deletion.title }}</p>
        </div>
        <div class="description">
            <p>{{ deletion.description }}</p>
        </div>
        <div class="footer-btn">
            <button type="button" v-bind:disabled="deletion.btnStatus" :class="deletion.btnStatus ? 'disabledCursor' : ''" @click="cancel">Cancel</button>
            <button type="submit" v-bind:disabled="deletion.btnStatus"  :class="deletion.btnStatus ? 'disabledCursor' : ''">Delete</button>
        </div>
    </div>
</template>
<script>
export default{
    props: {
        deletion: Object
    },
    methods: {
        cancel(){
            this.$emit('cancel')
        }
    }
}
</script>
<style scoped>
    .delete-form{
        width: 35em;
        padding: 30px 40px;
        background: #ffffff;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 5px;
        border-radius: 7px;
        position: relative;
    }
    .delete-form > .title{
        width: 100%;
        margin: 15px 0;
        text-align: center;
    }
    .delete-form > .title > p{
        padding: 0 5px;
        font-size: 16px;
        letter-spacing: 1.5px;
        color: #1D1D41;
        font-weight: 800;
    }
    .delete-form > .description{
        width: 100%;
        margin: 15px 0 70px 0;
        text-align: center;
    }
    .delete-form > .description > p{
        padding: 0 5px;
        font-size: 14px;
        letter-spacing: 1.5px;
        color: rgba(24, 24, 24, 0.8);
    }
    .delete-form > .footer-btn{
        position: absolute;
        padding: 10px 20px;
        width: 100%;
        left: 0;
        bottom: 0;
        display: flex;
        justify-content: center;
        grid-gap: 10px;
        margin-bottom: 10px;
    }
    .delete-form > .footer-btn > button {
        width: 100%;
        border: none;
        padding: 12px 25px;
        border-radius: 7px;
        font-size: 16px;
        cursor: pointer;
        letter-spacing: 1.7px;
        transition: all 0.5s ease-out;
    }
    .delete-form > .footer-btn > :nth-child(2){
        color: #b6b5b5;
        background: #1D1D41;
    }
    .delete-form > .footer-btn > :nth-child(2):hover{
        color: #ffffff;
        background: #28274F;
        transform: translateY(-2px);
    }
    .disabledCursor{
        cursor: not-allowed !important;
    }
</style>