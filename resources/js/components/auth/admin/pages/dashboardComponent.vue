<template>
    <article>
        <skeletonLoading v-if="!loadStatusPage"></skeletonLoading>
        <template v-else>
            <div class="title">
                <p>Dashboard</p>
            </div>
            <div class="main-table">
                <tableHeader tableHeader="Expenses"></tableHeader>
                <table class="table">
                    <tableNav :tableNavDatas="tableNavDatas"></tableNav>
                    <tbody>
                        <tr v-for="datas in tableDataBody">
                            <td>{{ datas.category }}</td>
                            <td>₱{{ datas.totalExpense }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <pieChart :piedata="piedata"/>
        </template>
    </article>
</template>
<script>
import tableHeader from '../../../reusable-table/tableHeader.vue';
import tableNav from '../../../reusable-table/tableNav.vue';
import axiosIntance from '../../../../composable/axios.comp.js'
import skeletonLoading from '../../../skeleton-loading/loading.vue'
import pieChart from '../../../chart/pieChart.vue'
export default{
    data(){
        return {
            tableNavDatas: [
                {
                    title: 'Expense Category',
                },
                {
                    title: 'Total',
                },
            ],
            tableDataBody:[],
            loadStatusPage: false,
            piedata: ''
        }
    },
    components: {
        tableHeader, tableNav, skeletonLoading, pieChart
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
                const response = await axiosIntance.get('/api/admin/expense/total', config)
                const res = await response.data
                this.tableDataBody = res
                this.piedata = res
            } catch (error) {
                console.log(error)
            }
        },
    }
}
</script>
<style scoped>
    article {
        width: 100% !important;
    }
</style>