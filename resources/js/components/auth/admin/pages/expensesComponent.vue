<template>
    <article>
        <skeletonLoading v-if="!loadStatusPage"></skeletonLoading>
        <template v-else>
            <transition>
                <div class="deletion-container" v-show="deletionStatus">
                    <transition name="bounce">
                        <form @submit.prevent="deleteProcess" v-show="deletionStatus" ref="form">
                            <deletionPopup :deletion="deletion" @cancel="cancel"></deletionPopup>
                        </form>
                    </transition>
                </div>
            </transition>
            <div class="title">
                <p>Expenses</p>
            </div>
            <div class="add-data">
                <router-link :to="{ name: 'expensesadmincreate' }"><button>Add Expense <i
                            class="fa-solid fa-angle-right"></i></button></router-link>
            </div>
            <div class="main-table">
                <tableHeader tableHeader="Category Table"></tableHeader>
                <table class="table">
                    <tableNav :tableNavDatas="tableNavDatas"></tableNav>
                    <tbody>
                        <tr v-for="datas in tableDataBody">
                            <td>{{ datas.id }}</td>
                            <td>{{ datas.category.name }}</td>
                            <td>₱{{ datas.amount }}</td>
                            <td>{{ datas.date }}</td>
                            <td class="actions">
                                <div class="list-action">
                                    <div>
                                        <i class="fa-solid fa-trash" @click="DeleteData(datas.id)"></i>
                                        <div class="tip">
                                            Delete
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fa-solid fa-pen-to-square" @click="updateData(datas.id)"></i>
                                        <div class="tip">
                                            Update
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
import tableHeader from '../../../reusable-table/tableHeader.vue';
import tableNav from '../../../reusable-table/tableNav.vue';
import deletionPopup from '../../../reusable-forms/deletionPopup.vue';
import axiosIntance from '../../../../composable/axios.comp.js'
import loadingComponent from '../../../essentials/loadingComponent.vue'
import skeletonLoading from '../../../skeleton-loading/loading.vue'
export default{
    data(){
        return{
            tableNavDatas: [
                {
                    title: 'ID',
                },
                {
                    title: 'Category',
                },
                {
                    title: 'Amount',
                },
                {
                    title: 'Date'
                }
            ],
            tableDataBody:[],
            deletion: {
                title: "You're about to delete this Category",
                description: "Before deleting the information in the form, please ensure that you have reviewed it thoroughly and confirmed that all the necessary details have been recorded accurately.",
                btnStatus: false,
                idValueToDelete: ''
            },
            deletionStatus: false,
            disabledCloseDeleteForm: false,
            loadingMessage: '',
            statusSubmit: false,
            loadStatusPage: false
        }
    },
    components: {
        tableHeader, tableNav, deletionPopup, loadingComponent, skeletonLoading
    },
    created(){
        const promisegetExpensesData = this.getExpensesData();
        Promise.all([promisegetExpensesData]).then(() => {
            setTimeout(() => {
                this.loadStatusPage = true
           }, 1000)
        })
    },
    methods: {
        async getExpensesData(){
            try {
                const config = {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                };
                const response = await axiosIntance.get('/api/admin/expense', config)
                const res = await response.data
                this.tableDataBody = res.datas
                console.log(this.tableDataBody)
            } catch (error) {
                console.log(error)
            }
        },
        DeleteData(id){
            this.deletionStatus = !this.deletionStatus
            this.deletion.idValueToDelete = id
        },
        cancel(){
            if(this.disabledCloseDeleteForm === false){
                this.deletionStatus = !this.deletionStatus
                this.deletion.idValueToDelete = ''
            }
        },
        async deleteProcess(){
            this.statusSubmit = !this.statusSubmit
            this.loadingMessage = 'Processing..'
            try {
                const config = {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                };
                const response = await axiosIntance.delete(`/api/admin/expense/delete/${this.deletion.idValueToDelete}`, config)
                const res = await response.data
                if (res) {
                    setTimeout(() => {
                        this.statusSubmit = !this.statusSubmit
                        this.getExpensesData()
                        setTimeout(() => {
                            this.loadingMessage = ''
                            this.$emit('successEmit', 'Successful')
                            this.deletionStatus = !this.deletionStatus
                            this.deletion.idValueToDelete = ''
                        }, 1000)
                    }, 900)
                }
            } catch (error) {
                this.statusSubmit = !this.statusSubmit
                console.log(error)
            }
        },
        updateData(id){
            this.$router.push({name: 'expensesadminupdate', params: {id: id}})
        }
    }
}
</script>
<style scoped>
    article {
        width: 100% !important;
    }
</style>