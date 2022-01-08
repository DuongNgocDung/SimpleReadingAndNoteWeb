<template>
    <div>
        <div class="home-content-block">
            <recommends v-bind:recommend-list="recommendList"></recommends>
        </div>
        <div class="home-content-block">
            <news></news>
        </div>
        <div class="home-content-block">
            <articles></articles>
        </div>
    </div>
</template>

<script>
    import Recommend from './Recommend.vue';
    import News from './News.vue';
    import Articles from './Articles.vue';
    import { RouterLink } from "vue-router";


    export default {
        components: {
            'recommends' : Recommend,
            'news' : News,
            'articles' : Articles
        },
        data() {
            return {
                recommendList: [
                    {url: "/images/wall/chainsaw_main/bg-144.jpg"},
                    {url: "/images/wall/chainsaw_main/5.jpg"},
                    {url: "/images/wall/chainsaw_main/Chainsaw Man3.jpg"},
                    {url: "/images/wall/chainsaw_main/6.jpg"},
                    {url: "/images/wall/chainsaw_main/3.jpg"},
                    {url: "/images/wall/chainsaw_main/1.jpg"}
                ]
            }
        }
    }
</script>

<style scoped>
    .home-content-block {
        margin-bottom: 70px;
    }
</style>