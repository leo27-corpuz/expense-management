<template>
    <div class="chart">
        <canvas id="myChart"></canvas>
    </div>
</template>
<script>
import Chart from 'chart.js/auto';
export default {
    props: {
        piedata: Object
    },
    data(){
        return {
            datas: {
                labels: [],
                datasets: [{
                    data: [],
                }]
            }
        }
    },
    mounted() {
        const ctx = document.getElementById('myChart');
        this.piedata.forEach(title => {
            this.datas.labels.push(title.category)
            this.datas.datasets[0].data.push(title.totalExpense)
        });
        new Chart(ctx, {
            type: 'pie',
            data: this.datas,
            options: {
            }
        });
    }
}
</script>
<style scoped>
    .chart{
        width: 300px;
        height: 300px;
        margin: 5em 0;
    }
</style>