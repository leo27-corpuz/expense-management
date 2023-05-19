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
                <p>Users</p>
            </div>
            <div class="add-data">
                <router-link :to="{ name: 'useradmincreate' }"><button>Add User <i
                            class="fa-solid fa-angle-right"></i></button></router-link>
            </div>
            <div class="main-table">
                <tableHeader tableHeader="Users Table"></tableHeader>
                <table class="table">
                    <tableNav :tableNavDatas="tableNavDatas"></tableNav>
                    <tbody>
                        <tr v-for="datas in tableDataBody">
                            <td>{{ datas.id }}</td>
                            <td>{{ datas.name }}</td>
                            <td>{{ datas.email }}</td>
                            <td>{{ datas.role.title }}</td>
                            <td>{{ datas.created_at }}</td>
                            <td class="actions">
                                <div class="list-action">
                                    <div v-if="datas.role.defaultrole != 1">
                                        <i class="fa-solid fa-trash" @click="DeleteData(datas.id)"></i>
                                        <div class="tip">
                                            Delete
                                        </div>
                                    </div>
                                    <div v-if="datas.role.defaultrole != 1">
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
                    title: 'Name',
                },
                {
                    title: 'Email Address',
                },
                {
                    title: 'Role'
                },
                {
                    title: 'Created At'
                }
            ],
            tableDataBody:[],
            deletion: {
                title: "You're about to delete this User",
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
        const promisegetUsersData = this.getUsersData();
        Promise.all([promisegetUsersData]).then(() => {
            setTimeout(() => {
                this.loadStatusPage = true
           }, 1000)
        })
    },
    methods: {
        async getUsersData(){
            try {
                const config = {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    }
                };
                const response = await axiosIntance.get('/api/admin/user', config)
                const res = await response.data
                console.log(res)
                this.tableDataBody = res.datas
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
                const response = await axiosIntance.delete(`/api/admin/user/delete/${this.deletion.idValueToDelete}`, config)
                const res = await response.data
                if (res) {
                    setTimeout(() => {
                        this.statusSubmit = !this.statusSubmit
                        this.getUsersData()
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
            this.$router.push({name: 'useradminupdate', params: {id: id}})
        }
    }
}
</script>
<style scoped>
    article {
        width: 100% !important;
    }
</style>