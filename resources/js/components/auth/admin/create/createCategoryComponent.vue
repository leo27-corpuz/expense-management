<template>
    <article>
        <skeletonLoading v-if="!loadStatusPage"></skeletonLoading>
        <template v-else>
            <div class="back">
                <router-link :to="{ name: 'categoryadmin' }"><button><i class="fa-solid fa-angle-left"></i>
                        Back</button></router-link>
            </div>
            <div class="form-container">
                <form @submit.prevent="submit">
                    <titleformComponent title="Add Category Form"></titleformComponent>
                    <inputsComponent :inputs="inputs" :error="error"></inputsComponent>
                    <inputDropdown :inputsDropdow="inputsDropdow" :error="error"></inputDropdown>
                    <textareaComponent :textareas="textareas" :error="error"></textareaComponent>
                    <buttonsComponent :statusSubmit="statusSubmit" :buttonTitle="buttonTitle"></buttonsComponent>
                </form>
            </div>
        </template>
    </article>
    <transition name="slide-fade">
        <loadingComponent v-if="statusSubmit">
            <p>{{ loadingMessage }}</p>
        </loadingComponent>
    </transition>
</template>
<script>
import inputsComponent from '../../../reusable-forms/inputs.vue'
import titleformComponent from '../../../reusable-forms/titleForm.vue'
import textareaComponent from '../../../reusable-forms/textarea.vue'
import buttonsComponent from '../../../reusable-forms/buttons.vue'
import axiosIntance from '../../../../composable/axios.comp';
import loadingComponent from '../../../essentials/loadingComponent.vue'
import inputDropdown from '../../../reusable-forms/inputDropdown.vue'
import skeletonLoading from '../../../skeleton-loading/loading.vue'
export default{
    data(){
        return{
            inputs: [
                {
                    type: 'text',
                    required: true,
                    label: 'Name',
                    placeholder: 'ex. Travel',
                    value: '',
                },
            ],
            textareas: [
                {
                    label: 'Description',
                    required: true,
                    placeholder: 'Brief Description',
                    value: ''
                },
            ],
            error: [],
            statusSubmit: false,
            buttonTitle: 'Create Category',
            loadingMessage: '',
            loadStatusPage: false
        }
    },
    emits: {
        successEmit: '',
    },
    components: {
        inputsComponent, titleformComponent, textareaComponent, buttonsComponent, loadingComponent, inputDropdown, skeletonLoading
    },
    mounted() {
        setTimeout(() => {
            this.loadStatusPage = true
        }, 1000)
    },
    methods: {
        async submit(){
            this.statusSubmit = !this.statusSubmit
            this.loadingMessage = 'Processing..'
            try {
                const config = {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                };
                const formData = new FormData();
                formData.append('name', this.inputs[0].value);
                formData.append('description', this.textareas[0].value);
                const response = await axiosIntance.post('/api/admin/category', formData, config)
                let res = await response.data
                if (res) {
                    setTimeout(() => {
                        this.statusSubmit = !this.statusSubmit
                        setTimeout(() => {
                            this.loadingMessage = ''
                            this.error = []
                            this.$router.push({name: 'categoryadmin'})
                            this.$emit('successEmit', 'Successful')
                        }, 1000)
                    }, 900)
                }
            } catch (error) {
                setTimeout(() => {
                    this.statusSubmit = !this.statusSubmit
                    setTimeout(() => {
                        this.loadingMessage = ''
                        this.error = error.response.data.error
                        console.log(this.error)
                    }, 1000)
                }, 900)
            }
        }
    }
}
</script>