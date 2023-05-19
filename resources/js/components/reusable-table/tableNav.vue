<template>
    <thead>
        <tr>
            <th v-for="tableNavData in tableNavDatas">
                <span>{{ tableNavData.title}}</span>
            </th>
            <th></th>
        </tr>
    </thead>
</template>
<script>
export default{
    props: {
        tableNavDatas: Array,
    }
}
</script>
<style scoped>
    thead{
        width: 100%;
        text-align: left;
        background: #EEF1F4;
        border-bottom: solid rgba(170, 170, 170, 0.4) 0.5px;
        border-left: solid rgba(170, 170, 170, 0.4) 0.5px;
        border-right: solid rgba(170, 170, 170, 0.4) 0.5px;
    }
    thead > tr > th{
        vertical-align: top;
        white-space: nowrap;
        padding: 20px;
        color: rgba(24, 24, 24, 0.5);
        font-size: var(--mobile-default-font-size);
        letter-spacing: 1px;
        position: relative;
    }
</style>