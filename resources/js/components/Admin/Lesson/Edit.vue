<template>
    <div class="manage-lesson-container">
        <div class="mb-20p flex space-btw p-10p">
            <div class="screen-title"><font-awesome-icon icon="book" class="mr-10p fs-20"/>レッスン管理</div>
        </div>
        <div class="register-form">
            <div class="flex dv-3-7">
                <div><span class="input-title">タイトル</span></div>
                <div><input type="text" v-model="item.title"></div>
            </div>
            <div class="flex dv-3-7">
                <div><span class="input-title">コンテンツハイライト</span></div>
                <div><textarea v-model="item.content_highlight" rows="3"></textarea></div>
            </div>
            <div class="flex dv-3-7">
                <div><span class="input-title">コンテンツ</span></div>
                <div><textarea v-model="item.content" rows="10"></textarea></div>
            </div>
            <div class="flex dv-3-7">
                <div><span class="input-title">サムネイル</span></div>
                <div class="flex">
                    <div v-if="item && item.thumbnail" class="preview-thumbnail">
                        <img :src="item.thumbnail">
                    </div>
                    <div>
                        <input type="file" id="upload_thumbnail" accept="image/png, image/gif, image/jpeg" @change="handleUploadThumbnail($event)">
                    </div>
                </div>
            </div>
            <div class="flex dv-3-7">
                <div><span class="input-title">コンテンツカテゴリー</span></div>
                <div>
                    <select v-model="item.category_id">
                        <option value=""></option>
                        <option v-for="row in listCategories" :value="row.id" :selected="(item.category_id && item.category_id === row.id) ? selected : false ">{{row.name}}</option>
                    </select>
                </div>
            </div>
            <div class="flex dv-3-7">
                <div><span class="input-title">レベル</span></div>
                <div>
                    <select v-model="item.level_id">
                        <option value=""></option>
                        <option v-for="row in listContentLevels" :value="row.id" :selected="(item.level_id && item.level_id === row.id) ? selected : false">{{row.name}}</option>
                    </select>
                </div>
            </div>
            <div class="flex dv-3-7">
                <div><span class="input-title">作者</span></div>
                <div><input type="text" v-model="item.author"></div>
            </div>
            <div class="flex dv-3-7">
                <div><span class="input-title">ソース</span></div>
                <div><input type="url" v-model="item.source_url"></div>
            </div>
            <div class="flex dv-3-7">
                <div><span class="input-title">ハッシュタグ</span></div>
                <div><input type="text" v-model="item.hashtag"></div>
            </div>
            <div class="flex dv-3-7">
                <div><span class="input-title">お勧め</span></div>
                <div><input type="checkbox" v-model="item.is_recommend" :checked="item.is_recommend == 1 ? 'checked' : false" /></div>
            </div>
            <div class="flex dv-3-7">
                <div><span class="input-title">表示順</span></div>
                <div><input type="number" v-model="item.sort_no"></div>
            </div>
            <div class="flex float-right mt-20p">
                <button id="btn-register" class="mr-10p save-btn" @click="save()">登録</button>
                <button id="btn-back" class="back-btn" @click="goBack()">戻る</button>
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
        data() {
            return {
                item: {
                    id: null,
                    category_id: null,
                    level_id: null,
                    title: null,
                    content:null,
                    content_highlight: null,
                    thumbnail: null,
                    author: null,
                    source_url: null,
                    hashtag: null,
                    is_recommend: null,
                    current_view: null,
                    sort_no: null,
                    update_date: null
                },
                uploadedThumbnail: null,
                listCategories: null,
                listContentLevels: null
            }
        },
        mounted() {
            this.loadSettingData();
            this.loadLessonData();
        },
        methods: {
            async loadSettingData() {
                let url = '/lesson/admin/get-setting-data';
                await axios.post(url, {})
                    .then(response => {
                        if (response.data && response.data.status === 1) {
                            this.listCategories = response.data.data.listCategories;
                            this.listContentLevels = response.data.data.listContentLevels;
                        } else {
                            console.log(url + " : fail");
                        }
                    });
            },
            async loadLessonData() {
                let id = this.$route.params && this.$route.params.id;
                if (id) {
                    let url = '/lesson/admin/detail';
                    await axios.post(url, {id:id})
                        .then(response => {
                            if (response.data && response.data.status === 1) {
                                if (response.data.data) {
                                    this.item = response.data.data;
                                    this.item.content = response.data.data.content.replace(/(?:<br>)/g, '\n');
                                    this.item.content_highlight = response.data.data.content_highlight.replace(/(?:<br>)/g, '\n');
                                } else {
                                    console.log("id not exist");
                                }
                            } else {
                                console.log(url + " failed !!");
                            }
                        })
                }
            },
            async save() {
                // check validate

                // call ajax to insert db
                let url = '/lesson/admin/save-lesson';
                let formData = new FormData();
                if (this.uploadedThumbnail != null && this.uploadedThumbnail !== '') {
                    formData.append('uploaded_thumbnail', this.uploadedThumbnail);
                }
                this.item.content = this.item.content.replace(/(?:\n)/g, '<br>');
                this.item.content_highlight = this.item.content_highlight.replace(/(?:\n)/g, '<br>');
                formData.append('data', JSON.stringify(this.item));
                await axios.post(url,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        if (response.data && response.data.status === 1) {
                            this.goBack();
                        } else {
                            console.log("/lesson/admin/save-lesson failed");
                        }
                    })
            },
            goBack() {
                let name = 'manage_lesson_list';
                this.$router.push({name: `${name}`})
            },
            handleUploadThumbnail(event) {
                this.uploadedThumbnail = event.target.files[0];
            }
        }
    }
</script>
<style scoped>
    .manage-lesson-container {
        color: #DEDEDE;
        padding: 10px;
        width: 80%;
        margin: auto;
    }
    .register-form {
        min-width: 750px;
    }
    .register-form > div {
        padding: 10px;
    }
    .dv-3-7 > div:first-child {
        width: 25%;
    }
    .dv-3-7 > div:nth-child(2) {
        width: 75%;
    }
    .preview-thumbnail {
        max-width: 120px;
        max-height: 80px;
        display: flex;
    }
</style>