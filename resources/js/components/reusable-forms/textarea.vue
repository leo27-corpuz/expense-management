<template>
    <div class="wrap-textarea">
        <div class="form-textarea-container" v-for="textarea in textareas">
            <div class="textarea">
                <label for="">{{ textarea.label }}<span class="required" v-if="textarea.required">*</span></label>
                <textarea v-model="textarea.value" :placeholder="textarea.placeholder"></textarea>
                <!-- <p v-if="error.description" v-for="error in error.description">{{ error }}</p> -->
            </div>
        </div>
    </div>
</template>
<script>
export default{
    props:{
        textareas: Array,
        error: Array
    }
}
</script>
<style scoped>
    .wrap-textarea{
        width: 100%;
    }
    .wrap-textarea > .form-textarea-container{
        width: 100%;
        margin-bottom: 15px;
    }
    .wrap-textarea > .form-textarea-container > .textarea{
        width: 100%;
        position: relative;
    }
    .wrap-textarea > .form-textarea-container > .textarea > textarea{
        width: 100%;
        font-size: 16px;
        padding: 15px;
        border-radius: 7px;
        border: solid rgba(0, 0, 0, 0.2) 0.5px;
        color: rgba(24, 24, 24, 0.5);
        outline: none;
        height: 250px;
        resize: none;
        letter-spacing: 1.5px;
        margin-top: 5px;
        transition: all 0.5s ease-out;
        white-space: pre-wrap;
    }
    .wrap-textarea > .form-textarea-container > .textarea > textarea:focus{
        border: solid 28274F 0.8px;
        color: 28274F;
    }
    .wrap-textarea > .form-textarea-container > .textarea > label{
        width: 100%;
        color: rgba(24, 24, 24, 0.5);
        margin-left: 2px;
        font-size: 14px;
        letter-spacing: 1.5px;
    }
    .wrap-textarea > .form-textarea-container > .textarea > p{
        font-size: 14px;
        letter-spacing: 1.5px;
        margin: 5px 2px;
        color: darkred;
    }
</style>