<template>
    <div class="home-item-container">
        <div class="home-item-header">
            <div></div>
            <div class="title"><router-link to="/lesson">レッスン</router-link></div>
            <div></div>
        </div>
        <div class="articles-summary">
            <div>
                <div style="display: flex; padding: 0 40px; justify-content: space-around;">
                    <div v-for="item in articleList" class="item-block">
                        <div>
                            <div class="article-summary-items">
                                <div>
                                    <div class="article-thumbnail"><img :src="item.thumbnail"></div>
                                </div>
                                <div class="article-content">
                                    <div><div @click="getDetailLink(item.id)">{{item.title}}</div></div>
                                    <div><div class="article-summary-content">{{item.content}}</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        mounted() {
            this.loadData();
        },
        data() {
            return {
                articleList : [],
            }
        },
        methods: {
            async loadData() {
                let url = '/lesson/list';
                axios.post(url, {limit: 3}).then(response => {
                    if (response.data && response.data.status === 1) {
                        this.articleList = response.data.data;
                    } else {

                    }
                });
            },
            getDetailLink(id) {
                let name = 'lesson_detail';
                this.$router.push({name: `${name}`, params: {id: `${id}`}});
            }
        }
    }
</script>

<style scoped>
    .item-block {
        min-width: 280px;
        width: 33.33%;
        max-width: 350px;
    }
    .item-block>div {
        padding: 10px 25px 15px;
    }

    .article-summary-items {
        height: 340px;
        overflow: hidden;
        border-radius: 5px;
        cursor: pointer;
        border: 1px solid rgb(30 30 30);
        box-shadow: 6px 6px 10px rgb(30 30 30);
    }
    .article-summary-items:hover {
        border: 1px solid #767f8a;
        box-shadow: 6px 5px 16px #38393b;
    }
    .article-summary-items>div {
        display: flex;
        flex-direction: column;
        color: #DEDEDE;
        margin-bottom: 10px;
    }

    .article-thumbnail {
        overflow: hidden;
        display: flex;
        justify-items: center;
        width: 100%;
        height: 180px;
    }
    .article-thumbnail>img {
        width: 100%;
        object-fit: cover;
    }

    .article-content>div {
        word-break: break-all;
        margin-bottom: 10px;
    }
    .article-content>div>div {
        padding: 2px 10px;
    }
    .article-content>div:first-child {
        border-bottom: 1px solid #6F7780;
        font-size: 18px;
        font-weight: bold;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden!important;
        text-overflow: ellipsis;
        white-space: normal;
    }
    .article-content>div:nth-child(2) {
        height: 90px;
    }
    .article-summary-content {
        font-size: 13px;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden!important;
        text-overflow: ellipsis;
        white-space: normal;
    }
</style>