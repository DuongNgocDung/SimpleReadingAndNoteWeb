<template>
    <div class="recommend-container">
        <div>
            <div class="recommend-long-block">
                <div v-for="item in recommendList" class="recommend-item">
                    <img :src="item.url">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            recommendList: {type: Array},
        },
        data() {
            return {
                defaultList : [
                    {url: "/images/wall/chainsaw_main/bg-144.jpg"},
                    {url: "/images/wall/chainsaw_main/5.jpg"},
                    {url: "/images/wall/chainsaw_main/Chainsaw Man3.jpg"},
                    {url: "/images/wall/chainsaw_main/6.jpg"},
                    {url: "/images/wall/chainsaw_main/3.jpg"},
                    {url: "/images/wall/chainsaw_main/1.jpg"}
                ],
            }
        },
        mounted() {
            if (this.isEmpty(this.recommendList)) {
                this.recommendList = this.defaultList;
            }
        },
        methods: {
            isEmpty(val) {
                return typeof val === 'undefined' || val == null || val === 0 || val === '' || val === [];
            }
        }
    }
</script>

<style scoped>
    .recommend-container {
        padding: 10px 0px 0px;
        background: #1F1F1F;
    }

    .recommend-container > div {
        overflow-x: scroll;
    }

    .recommend-container > div::-webkit-scrollbar {
        height: 8px;
    }
    .recommend-container > div::-webkit-scrollbar-thumb {
        background: #B3B3B3;
        border-radius: 10px;
    }
    .recommend-container > div::-webkit-scrollbar-track {
        background: #1F1F1F;
    }

    .recommend-long-block {
        width: max-content;
        display: flex;
        flex-direction: row;
    }

    .recommend-item {
        width: 400px;
        height: 230px;
        overflow: hidden;
        display: flex;
        justify-items: center;
        padding: 2px 8px;
    }
    .recommend-item > img {
        width: 100%;
        object-fit: cover;
    }
</style>