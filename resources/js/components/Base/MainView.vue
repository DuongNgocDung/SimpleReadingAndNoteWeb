<template>
    <div class="main-view">
        <router-view :user_info="user_info"></router-view>
    </div>
</template>
<script>
    export default {
        props: ['user_info']
    }
</script>