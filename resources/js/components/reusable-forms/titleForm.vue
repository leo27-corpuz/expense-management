<template>
    <div class="title">
        <p>{{ title }}</p>
    </div>
</template>
<script>
export default{
    props: {
        title: String,
    }
}
</script>
<style scoped>
    .title > p{
        font-size: 40px;
        color: #4e4e4e;
        letter-spacing: 1px;
    }
    .title{
        margin-bottom: 1.5em;
        text-align: center;
    }
</style>