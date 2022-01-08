<template>
    <div>
        <div class="lesson-container">
            <div class="mb-20p flex space-btw">
                <div class="screen-title"><font-awesome-icon icon="book" class="mr-10p fs-20"/>レッスン管理</div>
                <div>
                    <button class="add-btn" @click="getEditLink(0)">
                        <font-awesome-icon class="mr-10p fs-20" icon="plus"/>レッスン登録
                    </button>
                </div>
            </div>
            <div class="list-content-tbl p-10-20p">
                <table>
                    <colgroup>
                        <col width="20%"/>
                        <col width="15%"/>
                        <col width="35%"/>
                        <col width="15%"/>
                        <col width="15%"/>
                    </colgroup>
                    <thead>
                        <tr>
                            <td class="tl-center">タイトル</td>
                            <td class="tl-center">サムネイル</td>
                            <td class="tl-center">コンテンツ</td>
                            <td class="tl-center">登録日</td>
                            <td class="tl-center">操作</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="list==null || list.length==0">
                            <td colspan="4">Hem có data</td>
                        </tr>
                        <tr v-else v-for="item in list">
                            <td><div class="title" @click="getEditLink(item.id)">{{item.title}}</div></td>
                            <td>
                                <div class="sml-thumbnail">
                                    <img v-if="item && item.thumbnail" :src="item.thumbnail">
                                </div>
                            </td>
                            <td><div>{{item.content}}</div></td>
                            <td><div class="tl-center" v-if="item.register_date"><v-date-format :date="new Date(item.register_date*1000)" format="Y年m月d日 H:i"></v-date-format></div></td>
                            <td>
                                <div class="tl-center flex">
                                    <button class="sml-btn" @click="getEditLink(item.id)">編集</button>
                                    <button class="sml-btn delete-btn" @click="deleteItem(item.id)">削除</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'
    import vDateFormat from '../../Base/DateFormat'
    import { library } from '@fortawesome/fontawesome-svg-core'
    import { faBook, faPlus } from '@fortawesome/free-solid-svg-icons'
    library.add(faBook, faPlus);

    export default {
        mounted() {
            this.loadList();
        },
        data() {
            return {
                list: null,
            }
        },
        methods: {
            loadList() {
                let url = '/lesson/admin/list';
                axios.post(url, {}).then(response => {
                    if (response.data && response.data.status === 1) {
                        this.list = response.data.data;
                    } else {
                    }
                });
            },
            getEditLink(id) {
                if (id != 0) {
                    let name = 'manage_lesson_edit';
                    this.$router.push({name: `${name}`, params: {id: `${id}`}});
                } else {
                    let name = 'manage_lesson_add';
                    this.$router.push({name: `${name}`});
                }
            },
            async deleteItem(id)
            {
                let url = '/lesson/admin/save-lesson';
                await axios.post(url, {
                    data: {id: id},
                    is_delete: 1
                }).then(response => {
                    if (response.data && response.data.status === 1) {
                        this.loadList();
                    } else {
                        console.log("/lesson/admin/save-lesson failed");
                    }
                })
            }
        },
        components: {
            vDateFormat
        }
    }
</script>
<style scoped>
    .lesson-container {
        margin: 10px 80px;
        padding: 20px;
        min-height: 500px;
    }
    .list-content-tbl {
        width: 100%;
        background-color: #DEDEDE;
        color: #0F0F0F;
        box-shadow: 4px 4px 10px #666666;
        overflow-x: scroll;
    }
    .list-content-tbl::-webkit-scrollbar {
        height: 8px;
        cursor: pointer;
    }
    .list-content-tbl::-webkit-scrollbar-thumb {
        background: #333333;
    }
    .list-content-tbl::-webkit-scrollbar-track {
        background: #CCCCCC;
    }
    .list-content-tbl table {
        width: 100%;
        min-width: 880px;
    }
    .list-content-tbl td {
        word-break: break-all;
        padding: 10px;
        vertical-align: top;
        font-size: 14px;
    }
    .list-content-tbl td > div {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden!important;
    }
    .list-content-tbl thead tr {
        border-bottom: solid 2px #B2B3B3;
    }
    .list-content-tbl tbody tr {
        border-bottom: solid 1px #B2B3B3;
    }
    .list-content-tbl tbody tr:last-child {
        border-bottom: none;
    }
    .list-content-tbl thead td {
        font-weight: bold;
        font-size: 16px;
    }
    .sml-thumbnail {
        width: 80%;
        max-width: 100px;
        max-height: 50px;
        margin: auto;
        display: flex !important;
        justify-items: center !important;
    }
    .sml-thumbnail img {
        object-fit: cover;
    }
    .lesson-container .title {
        cursor: pointer;
    }
</style>