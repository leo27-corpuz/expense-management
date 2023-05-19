<template>
    <article>
        <skeletonLoading v-if="!loadStatusPage"></skeletonLoading>
        <template v-else>
            <div class="back">
                <router-link :to="{ name: 'useradmin' }"><button><i class="fa-solid fa-angle-left"></i>
                        Back</button></router-link>
            </div>
            <div class="form-container">
                <form @submit.prevent="submit">
                    <titleformComponent title="Update User Form"></titleformComponent>
                    <inputsComponent :inputs="inputs" :error="error"></inputsComponent>
                    <inputDropdown :inputsDropdow="inputsDropdow" :error="error"></inputDropdown>
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
                    placeholder: 'ex. User',
                    value: '',
                },
                {
                    type: 'email',
                    required: true,
                    label: 'Email',
                    placeholder: 'ex. user@gmail.com',
                    value: '',
                },
                {
                    type: 'password',
                    required: false,
                    label: 'Password',
                    placeholder: 'ex. 12Asd/as1',
                    value: '',
                },
            ],
            inputsDropdow: [
                {
                    required: true,
                    label: 'Role',
                    values: [],
                    defaultval: '',
                },
            ],
            error: [],
            statusSubmit: false,
            buttonTitle: 'Create Role',
            loadingMessage: '',
            loadStatusPage: false
        }
    },
    emits: {
        successEmit: '',
    },
    components: {
        inputsComponent, titleformComponent, inputDropdown, buttonsComponent, loadingComponent, skeletonLoading
    },
    created(){
        const promisegetRolesData = this.getRolesData();
        const promiseGetUSerData = this.getUserData();
        Promise.all([promisegetRolesData, promiseGetUSerData]).then(() => {
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
                formData.append('name', this.inputs[0].value);
                formData.append('email', this.inputs[1].value);
                formData.append('password', this.inputs[2].value);
                formData.append('role', this.inputsDropdow[0].defaultval);
                const response = await axiosIntance.post(`/api/admin/user/update/${this.$route.params.id}`, formData, config)
                let res = await response.data
                console.log(res)
                if (res) {
                    setTimeout(() => {
                        this.statusSubmit = !this.statusSubmit
                        setTimeout(() => {
                            this.loadingMessage = ''
                            this.error = []
                            this.$router.push({name: 'useradmin'})
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
        },
        async getRolesData(){
            try {
                const config = {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                };
                const response = await axiosIntance.get('/api/admin/role', config)
                const res = await response.data
                this.inputsDropdow[0].values = res.datas
            } catch (error) {
                console.log(error)
            }
        },
        async getUserData(){
            try {
                const config = {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                };
                const response = await axiosIntance.get(`/api/admin/user/update/${this.$route.params.id}`, config)
                const res = await response.data
                console.log(res)
                this.inputs[0].value = res.data.name
                this.inputs[1].value = res.data.email
                this.inputsDropdow[0].defaultval = res.data.role.id
            } catch (error) {
                this.$router.push({name: 'useradmin'})
            }
        }
    }
}
</script>