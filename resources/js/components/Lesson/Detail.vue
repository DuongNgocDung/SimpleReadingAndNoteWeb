<template>
    <div class="lesson-container">
        <div class="breadcrumb">
            <span>Home</span>
            <span>》</span>
            <span v-if="item && item.title">{{item.title}}</span>
        </div>
        <div class="flex-container">
            <div v-if="item" class="detail">
                <div>
                    <div class="thumbnail">
                        <img :src="item.thumbnail">
                    </div>
                </div>
                <div class="title">
                    <h1>{{item.title}}</h1>
                </div>
                <div v-if="item && item.content_highlight" class="content-highlight">
                    <p v-html="item && item.content_highlight"></p>
                </div>
                <div class="content">
                    <p v-html="item && item.content"></p>
                    <!--<div class="noted-word" @click="showNotedDetails($event)">練習</div>-->
                </div>
                <div v-if="item && (item.author || item.source_url)" class="content-source">
                    <div v-if="item.author"><font-awesome-icon icon="user" class="mr-5p"/>著者 : {{item.author}}</div>
                    <div v-if="item.source_url"><font-awesome-icon icon="link" class="mr-5p"/>ソースURL : <a :href="item.source_url" target="_blank">{{item.source_url}}</a></div>
                </div>
            </div>
            <div v-if="item" class="additions">
                <div class="addition-block">
                    <div class="add-note-title" @click="showAddNoteDialog">
                        <font-awesome-icon icon="plus"/>
                        メモを追加
                    </div>
                    <div class="list-notes">
                        <div v-for="item in noteList">
                            <div :data-id="item.id" class="noted-word" @click="showNotedDetails($event)">
                                <span class="txt-b">{{item.word}} : </span>
                            </div>
                            <span>{{item.meaning}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: none">
            <div id="add-note-dialog" style="width: 200px; height: 100px; background: #6373FF">
            </div>
        </div>
        <transition name="fade">
            <div v-if="isOpenNoteModal" style="position: absolute; top: 0; left: 0;">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-header">
                                <button class="form-control" @click="cancelSaveWord">X</button>
                            </div>
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="flex input-with-label">
                                        <span>新しい言葉</span>
                                        <input class="form-control" name="new_word" v-model="data.word"/>
                                    </div>
                                    <div class="flex input-with-label">
                                        <span>ふりがな</span>
                                        <input class="form-control" name="furigana" v-model="data.furigana"/>
                                    </div>
                                    <div class="flex input-with-label">
                                        <span>ろまじ</span>
                                        <input class="form-control" name="romaji" v-model="data.romaji"/>
                                    </div>
                                    <div class="flex input-with-label">
                                        <span>意味</span>
                                        <input class="form-control" name="meaning" v-model="data.meaning"/>
                                    </div>
                                    <div class="flex input-with-label">
                                        <span>ノート</span>
                                        <input class="form-control" name="note" v-model="data.note"/>
                                    </div>
                                    <div class="flex input-with-label">
                                        <span>例</span>
                                        <textarea rows="5" name="example" v-model="data.example"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="save-btn" @click="saveWord">登録</button>
                                    <button class="cancel-btn" @click="cancelSaveWord">キャンセル</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <transition name="fade">
            <div v-if="notedWord && notedWord.id" class="noted-word-details fs-14" style="position: absolute; top: 0; left: 0;">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div>
                                <div>
                                    <span class="txt-b fs-20">{{notedWord.word}}  </span><span class="fs-18 mr-15p" v-if="notedWord.furigana">／{{notedWord.furigana}}／</span>
                                </div>
                                <div>
                                    <span>{{notedWord.meaning}}</span>
                                </div>
                                <div v-if="item.example">
                                    <p class="example-txt">例::::</p>
                                    <p>
                                        <span>{{item.example}}</span>
                                    </p>
                                </div>
                            </div>
                                </div>
                            </div>
                            <!--<div class="close-btn" @click="hideNotedDetails">X</div>-->
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
<script>
    import axios from 'axios'
    import $ from 'jquery'
    import { library } from '@fortawesome/fontawesome-svg-core'
    import { faPlus, faUser, faLink } from '@fortawesome/free-solid-svg-icons'
    library.add(faPlus, faUser, faLink);

    export default {
        data() {
            return {
                item: null,
                id: "",
                noteList: null,
                isOpenNoteModal: false,
                data: {
                    word: "",
                    furigana: "",
                    romaji: "",
                    meaning: "",
                    note: "",
                    example: ""
                },
                notedWord: null,
                notedWordPosition: {
                    top: '0px',
                    left: '0px'
                }
            }
        },
        mounted() {
            this.id = this.$route.params.id;
            this.loadData();
        },
        methods: {
            showNoteDialog(word) {
                console.log("Show dialog note : " + word);
            },
            showAddNoteDialog() {
                this.isOpenNoteModal = true;
            },
            async loadData() {
                let url = '/lesson/detail-by-id';
                const res = await axios.post(url, {id: this.id});
                this.item = res && res.data && res.data.data;
                this.loadNoteList();
            },
            async saveWord() {
                let url = '/lesson/save-word';
                await axios.post(url, {
                    lesson_id: this.id,
                    data: this.data
                }).then(response => {
                    if (response.data.status === 1) {
                        this.loadNoteList();
                        this.cancelSaveWord();
                    }
                })
            },
            async loadNoteList() {
                console.log("load notes list...");
                let url = '/lesson/notes-by-lesson';
                await axios.post(url, {lesson_id: this.id})
                    .then(response => {
                        if (response.data && response.data.status === 1) {
                            this.noteList = response.data.data;
                            console.log(this.noteList);
                        }
                    });
            },
            cancelSaveWord() {
                this.isOpenNoteModal = false;
                this.data = {
                    word: "",
                    furigana: "",
                    romaji: "",
                    meaning: "",
                    note: "",
                    example: ""
                }
            },
            showNotedDetails(event) {
                let elm = event.currentTarget;
                let wordId = $(elm).attr('data-id');

                if (wordId) {
                    this.notedWord = this.noteList[0];
                    console.log(this.noteList);
                }
            },
            hideNotedDetails() {
                this.notedWord = null;
            }
        }
    }
</script>
<style scoped>
    body {
        background: #F2F2F2 !important;
    }
    .breadcrumb {
        height: 40px;
        vertical-align: middle;
    }
    .breadcrumb > span {
        color: #DEDEDE;
    }
    .lesson-container {
        padding: 20px 60px;
    }
    .flex-container {
        display: flex;
    }
    .flex-container .detail {
        color: #D9D9D9;
        width: 65%;
    }
    .flex-container .detail > div {
        margin-bottom: 20px;
    }
    .detail .title > h1 {
        font-size: 2rem;
        text-align: center;
    }
    .detail .content-highlight > p {
        font-weight: bold;
        font-style: italic;
        font-size: 16px;
    }
    .detail .content-source {
        border-top: 1px solid #A6A6A6;
        font-size: 13px;
        width: fit-content;
        margin-top: 50px !important;
        padding-top: 5px;
    }
    .content-source > div {
        padding-top: 10px;
    }
    .flex-container .additions {
        width: 35%;
        padding: 0 0 0 30px;
    }
    .addition-block {
        background: #DEDEDE;
        min-height: 250px;
        margin-bottom: 20px;
        border-radius: 8px;
    }
    .addition-block > div:nth-child(2) {
        padding: 10px 20px;
    }
    .addition-block > div:first-child {
        border-bottom: 1px solid #8C8C8C;
        padding: 10px 20px 2px;
    }
    .list-notes {
        font-size: 14px;
    }
    .list-notes > div {
        margin-bottom: 3px;
    }

    .thumbnail {
        height: 350px;
        width: 100%;
        display: flex;
        justify-items: center;
        margin-bottom: 25px;
        border-radius: 5px;
        overflow: hidden;
    }
    .thumbnail > img {
        width: 100%;
        object-fit: cover;
    }
    .noted-word {
        cursor: pointer;
        display: inline;
    }

    .modal-mask {
        position: fixed;
        z-index: 9998;
        toze: 12;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .8);
        display: table;
        transition: opacity .3s ease;
    }
    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }
    .modal-dialog {
        width: 500px;
        height: 400px;
        background: #fff;
        position: relative;
        margin: auto;
        border-radius: 10px;
    }
    .modal-header {
        border-radius: 10px 10px 0 0;
        padding: 5px 10px;
        background: #F7D83E;
        text-align: right;
    }
    .modal-header button {
        color: #ab0909;
        font-weight: bold;
        cursor: pointer;
        font-size: 18px;
    }
    .modal-content {
        padding: 5px 10px;
    }
    .modal-footer {
        text-align: center;
        padding: 20px 0 0;
    }
    .modal-footer button {
        width: 100px;
        height: 30px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        color: #f0f0f0;
    }
    .modal-footer button:hover {
        font-weight: bold;
    }

    .input-with-label {
        padding: 5px 10px;
    }
    .input-with-label span:first-child {
        width: 30%;
    }
    .input-with-label input, textarea {
        background: transparent;
        width: 65%;
        border: 1px solid gray;
        border-radius: 5px;
        padding: 2px 5px;
        font-size: 13px;
    }
    .input-with-label input:focus-visible, textarea:focus-visible {
        border: 1px solid #062578;
        outline: none;
    }
    .save-btn {
        background: #103491;
    }
    .cancel-btn {
        background: #c91e1e;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .3s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }

    .txt-b {
        font-weight: bold;
    }
    .noted-word-details {
        position: absolute;
        display: flex;
    }
    .noted-word-details > div:first-child {
        max-width: 350px;
        min-width: 250px;
        height: auto;
        font-size: 14px;
        background: #fff;
        padding: 10px 15px;
        border: 3px solid #082c8c;
        border-radius: 5px;
        box-shadow: 6px 10px 10px rgb(0 0 0 / 60%);
        box-sizing: border-box;
    }
    .noted-word-details > div:nth-child(2) {
        border-radius: 50%;
        background: #082c8c;
        min-width: 30px;
        width: 30px;
        min-height: 30px;
        height: 30px;
        margin-left: -25px;
        margin-top: -5px;
        color: #fff;
        font-weight: bold;
        text-align: center;
        padding-top: 5px;
        cursor: pointer;
    }
    .fs-20 {
        font-size: 20px;
    }
    .fs-18 {
        font-size: 18px;
    }
    .fs-14 {
        font-size: 14px;
    }
    .example-txt {
        font-weight: bold;
        text-decoration: underline;
    }
    .mr-15p {
        margin-right: 15px;
    }
    .add-note-title {
        font-size: 20px;
        cursor: pointer;
        color: #3866C2
    }
    .add-note-title:hover {
        color: #2E539E;
    }
</style>