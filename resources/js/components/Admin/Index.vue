<template>
    <div class="admin-menu-container">
        <div class="admin-menu"><router-link to="/admin/lesson">レッスン管理</router-link></div>
        <div class="admin-menu"><router-link to="/">something else 管理...</router-link></div>
    </div>
</template>
<script>

    export default {
        mounted() {
        },
        methods: {
        },
        components: {
        }
    }
</script>
<style scoped>
    .admin-menu-container {
        padding: 20px 80px;
        text-align: center;
    }
    .admin-menu {
        color: #C1C1C1;
        font-weight: bold;
        font-size: 30px;
        padding: 10px;
    }
</style>