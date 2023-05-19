<template>
    <div class="table-header">
        <div class="table-title">
            <p>{{ tableHeader }}</p>
        </div>
    </div>
</template>
<script>
export default{
    props: {
        tableHeader: String,
    }
}
</script>
<style scoped>
    .table-header {
        width: 100%;
        background: #ffffff;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: relative;
        border: solid rgba(170, 170, 170, 0.4) 0.5px;
        border-radius: 5px 5px 0 0;
    }
    .table-header > * {
        margin: auto 0;
    }
    .table-header > .table-title > p{
        font-size: 16px;
        letter-spacing: 1.2px;
        color: #4e4e4e;
        line-height: 1.7;
        color: rgba(24, 24, 24, 0.5);
        font-weight: 600;
    }
</style>
