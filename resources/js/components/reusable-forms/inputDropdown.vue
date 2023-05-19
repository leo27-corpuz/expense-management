<template>
    <div class="wrap-input">
        <div class="form-input-container" v-for="input in inputsDropdow">
            <div class="input">
                <label for="">{{ input.label }}<span class="required" v-if="input.required">*</span></label>
                <select v-model="input.defaultval">
                    <option value="">--Please choose an option--</option>
                    <template v-for="drop in input.values">
                        <option :value="drop.id" v-if="drop.title">{{drop.title}}</option>
                        <option :value="drop.id" v-else-if="drop.name">{{drop.name}}</option>
                    </template>
                </select>
                <!-- <p v-if="error.defaultrole" v-for="error in error.defaultrole">{{ error }}</p> -->
            </div>
        </div>
    </div>
</template>
<script>
export default{
    props:{
        inputsDropdow: Array,
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
    .wrap-input > .form-input-container > .input > select{
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
 
    .wrap-input > .form-input-container > .input > select:focus{
        border: solid #28274F 0.8px;
        color: #28274F;
    }
    .wrap-input > .form-input-container > .input > select:focus::placeholder{
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