<template>
    <div class="wrap-input">
        <div class="form-input-container" v-for="input in inputs">
            <div class="input">
                <label for="">{{ input.label }}<span class="required" v-if="input.required">*</span></label>
                <input :type="input.type" :placeholder="input.placeholder" v-model="input.value">
                <!-- <p v-if="error.title" v-for="error in error.title">{{ error }}</p> -->
            </div>
        </div>
    </div>
</template>
<script>
export default{
    props:{
        inputs: Array,
        error: Array
    }
}
</script>
<style scoped>
    .wrap-input{
        width: 100%;
    }
    .wrap-input > .form-input-container{
        width: 100%;
        margin-bottom: 15px;
    }

    .wrap-input > .form-input-container > .input{
        width: 100%;
        position: relative;
    }
    .wrap-input > .form-input-container > .input > label{
        width: 100%;
        color: rgba(24, 24, 24, 0.5);
        margin-left: 2px;
        font-size: 14px;
        letter-spacing: 1.5px;
    }
    .wrap-input > .form-input-container > .input > input{
        width: 100%;
        font-size: 16px;
        padding: 15px;
        margin-top: 5px;
        border-radius: 7px;
        border: solid rgba(0, 0, 0, 0.2) 0.5px;
        color: rgba(24, 24, 24, 0.5);
        outline: none;
        letter-spacing: 1.5px;
        transition: all 0.5s ease-out;
    }
 
    .wrap-input > .form-input-container > .input > input:focus{
        border: solid #28274F 0.8px;
        color: #28274F;
    }
    .wrap-input > .form-input-container > .input > input:focus::placeholder{
        color: #28274F;
    }
    .merge{
        display: flex;
        grid-gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 5px;
    }
    .merge > * {
        flex: 1 1 45%;
    }
    .wrap-input > .form-input-container > .input > p{
        font-size: 14px;
        letter-spacing: 1.5px;
        margin: 5px 2px;
        color: darkred;
    }
</style>