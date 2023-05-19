<template>
    <article>
        <skeletonLoading v-if="!loadStatusPage"></skeletonLoading>
        <template v-else>
            <div class="back">
                <router-link :to="{ name: 'roleadmin' }"><button><i class="fa-solid fa-angle-left"></i>
                        Back</button></router-link>
            </div>
            <div class="form-container">
                <form @submit.prevent="submit">
                    <titleformComponent title="Update Role Form"></titleformComponent>
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
                    label: 'Title',
                    placeholder: 'ex. User',
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
            inputsDropdow: [
                {
                    required: true,
                    label: 'Select Default Role ID',
                    values: [
                        {
                            id: 1,
                            title: 'Admin Default Role ID(1)'
                        },
                        {
                            id: 2,
                            title: 'User Default Role ID(2)'
                        }
                    ],
                    defaultval: '',
                },
            ],
            error: [],
            statusSubmit: false,
            buttonTitle: 'Update Role',
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
    created(){
        const promisegetRoleData = this.getRoleData();
        Promise.all([promisegetRoleData]).then(() => {
            setTimeout(() => {
                this.loadStatusPage = true
            }, 1000)
        })
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
                formData.append('title', this.inputs[0].value);
                formData.append('description', this.textareas[0].value);
                formData.append('defaultrole', this.inputsDropdow[0].defaultval);
                const response = await axiosIntance.post(`/api/admin/role/update/${this.$route.params.id}`, formData, config)
                let res = await response.data
                if (res) {
                    setTimeout(() => {
                        this.statusSubmit = !this.statusSubmit
                        setTimeout(() => {
                            this.loadingMessage = ''
                            this.error = []
                            this.$router.push({name: 'roleadmin'})
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
                    }, 1000)
                }, 900)
            }
        },
        async getRoleData(){
            try {
                const config = {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                };
                const response = await axiosIntance.get(`/api/admin/role/update/${this.$route.params.id}`, config)
                const res = await response.data
                console.log(res)
                this.inputs[0].value = res.data.title
                this.textareas[0].value = res.data.description
                this.inputsDropdow[0].defaultval = res.data.defaultrole
            } catch (error) {
                this.$router.push({name: 'roleadmin'})
            }
        }
    }
}
</script>