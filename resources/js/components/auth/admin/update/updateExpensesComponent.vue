<template>
    <article>
        <skeletonLoading v-if="!loadStatusPage"></skeletonLoading>
        <template v-else>
            <div class="back">
                <router-link :to="{ name: 'expenseadmin' }"><button><i class="fa-solid fa-angle-left"></i>
                        Back</button></router-link>
            </div>
            <div class="form-container">
                <form @submit.prevent="submit">
                    <titleformComponent title="Update Expense Form"></titleformComponent>
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
                    type: 'number',
                    required: true,
                    label: 'Amount',
                    placeholder: 'ex. 1000',
                    value: '',
                },
                {
                    type: 'date',
                    required: true,
                    label: 'Date',
                    placeholder: '',
                    value: '',
                },
            ],
            inputsDropdow: [
                {
                    required: true,
                    label: 'Category',
                    values: [],
                    defaultval: '',
                },
            ],
            error: [],
            statusSubmit: false,
            buttonTitle: 'Update Expense',
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
        const promisegetCategoryData = this.getCategoryData();
        const promiseGetExpenseData = this.getExpenseData();
        Promise.all([promisegetCategoryData]).then(() => {
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
                formData.append('amount', this.inputs[0].value);
                formData.append('date', this.inputs[1].value);
                formData.append('category_id', this.inputsDropdow[0].defaultval);
                const response = await axiosIntance.post(`/api/admin/expense/update/${this.$route.params.id}`, formData, config)
                let res = await response.data
                if (res) {
                    setTimeout(() => {
                        this.statusSubmit = !this.statusSubmit
                        setTimeout(() => {
                            this.loadingMessage = ''
                            this.error = []
                            this.$router.push({name: 'expenseadmin'})
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
        async getCategoryData(){
            try {
                const config = {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                };
                const response = await axiosIntance.get('/api/admin/category', config)
                const res = await response.data
                this.inputsDropdow[0].values = res.datas
            } catch (error) {
                console.log(error)
            }
        },
        async getExpenseData(){
            try {
                const config = {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                };
                const response = await axiosIntance.get(`/api/admin/expense/update/${this.$route.params.id}`, config)
                const res = await response.data
                console.log(res)
                this.inputs[0].value = res.data.amount
                this.inputs[1].value = res.data.date
                this.inputsDropdow[0].defaultval = res.data.category.id
            } catch (error) {
                this.$router.push({name: 'useradmin'})
            }
        }
    }
}
</script>