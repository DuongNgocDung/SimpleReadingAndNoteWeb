<template>
    <div>
        <div class="lesson-container">
            <div class="screen-title"><font-awesome-icon icon="book" class="mr-10p fs-20"/>レッスン</div>
            <div class="flex">
                <div class="left-block">
                    <div v-if="lessonList" v-for="item in lessonList">
                        <div style="color: white">ua3</div>
                        <div class="item-block" @click="getDetailLink(item.id)">
                            <div class="content-thumbnail">
                                <img v-if="item.thumbnail" :src="item.thumbnail"/>
                                <img v-else src="/images/wall/chainsaw_main/bg-144.jpg"/>
                            </div>
                            <div class="content-detail">
                                <div class="title">
                                    <div>{{item.title}}</div>
                                </div>
                                <div class="description">
                                    <div>{{item.content}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-block">
                    bla bla
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'
    import { library } from '@fortawesome/fontawesome-svg-core'
    import { faBook, faPlus } from '@fortawesome/free-solid-svg-icons'
    library.add(faBook, faPlus);

    export default {
        mounted() {
            this.loadData();
        },
        data() {
            return {
                lessonList: null
            }
        },
        methods: {
            loadData() {
                let url = '/lesson/list';
                axios.post(url, {limit: 50}).then(response => {
                    if (response.data && response.data.status === 1) {
                        console.log(response.data);
                        this.lessonList = response.data.data;
                    } else {

                    }
                });
            },
            getDetailLink(lessonId) {
                let name = 'lesson_detail';
                this.$router.push({name: `${name}`, params: {id: `${lessonId}`}});
            }
        }
    }
</script>
<style scoped>
    .lesson-container {
        color: #DEDEDE;
        margin: 10px 80px;
        padding: 20px;
        min-height: 500px;
    }
    .left-block {
        width: 70%;
        height: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-content: center;
    }
    .left-block > div {
        width: 33.33%;
        min-width: 200px;
        overflow: hidden;
        max-height: 350px;
        padding: 10px 20px;
    }
    .right-block {
        width: 30%;
        height: 100%;
        background: gray;
    }
    .item-block {
        height: 300px;
        overflow: hidden;
        border-radius: 5px;
        box-shadow: 2px 3px 10px rgb(30 30 30);
        cursor: pointer;
    }
    .item-block:hover {
        box-shadow: 2px 3px 10px #38393b;
    }
    .content-thumbnail {
        width: 100%;
        height: 130px;
        overflow: hidden;
        display: flex;
        justify-items: center;
    }
    .content-detail {
        font-size: 13px;
        padding: 10px;
    }
    .content-detail .title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden!important;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 5px;
    }
    .content-detail .description {    display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden!important;
    }
</style>