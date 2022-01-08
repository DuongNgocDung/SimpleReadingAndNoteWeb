<template>
    <div class="news-container">
        <div class="breadcrumb">
            <span>Home</span>
            <span>》</span>
            <span>News Detail</span>
        </div>
        <div class="flex-container">
            <div class="detail">
                <div>
                    <div class="thumbnail">
                        <img :src="item.thumbnail">
                    </div>
                </div>
                <div class="title">
                    <h1>{{item.title}}</h1>
                </div>
                <div class="content">
                    <div>{{item.content}}</div>
                </div>
            </div>
            <div class="additions">
                <div class="addition-block">
                    <div><h3>Ranking</h3></div>
                    <div>
                        <div v-for="item in rankingList">
                            <div><span>{{item.rank}}//  {{item.title}}</span></div>
                        </div>
                    </div>
                </div>
                <div class="addition-block">
                    <div>Hoặc mục lục, hoặc list,...?</div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                item: {
                    title: "タイトル２",
                    content: "TVアニメ「ボールルームへようこそ」Blu-ray&DVD全巻購入特典「原作・竹内友先生描き下ろし オリジナル短編漫画」の送付について大変遅れており申し訳ございません。こちら目処が立ちまして12月24日週のお届けを予定しておりますので、今しばらくお待ち頂けますと幸いです。こちら大変お待たせを致しましたが、2018年12月24日週のお届けを予定しておりますので、\n" +
                        "今しばらくお待ち頂けますと幸いでございます。",
                    thumbnail: "/images/wall/2.jpg",
                    author: "ルフィ",
                    source_url: "",
                    updated_date: "2021/09/11 20:15"
                },
                id: "",
                rankingList: [
                    {
                        id: 2,
                        title: 'Bài này top 1 nèk',
                        content: 'Bla bla...',
                        rank: 1,
                        view: 300
                    },
                    {
                        id: 1,
                        title: 'Bài này top 2 nèk',
                        content: 'Blo blo...',
                        rank: 2,
                        view: 250
                    },
                    {
                        id: 3,
                        title: 'Bài này top 3 nèk',
                        content: 'Ble ble...',
                        rank: 3,
                        view: 100
                    },
                    {
                        id: 4,
                        title: 'Hạng 4 nha',
                        content: 'Ble ble...',
                        rank: 4,
                        view: 80
                    },
                    {
                        id: 5,
                        title: 'Hạng 5 ha',
                        content: 'Ble ble...',
                        rank: 5,
                        view: 55
                    },
                ]
            }
        },
        mounted() {
            this.id = this.$router.params.id;
            console.log(this.item);
            console.log(this.id);
        }
    }
</script>
<style scoped>
    .breadcrumb {
        height: 40px;
        vertical-align: middle;
    }
    .breadcrumb > span {
        color: #DEDEDE;
    }
    .news-container {
        padding: 20px 60px;
    }
    .flex-container {
        display: flex;
    }
    .flex-container .detail {
        color: #DEDEDE;
        width: 65%;
    }
    .flex-container .detail > div {
        margin-bottom: 20px;
    }
    .detail .title > h1 {
        font-size: 2rem;
        text-align: center;
        font-weight: bold;
    }
    .detail .content > div {
        font-size: 1.1rem;
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
        padding: 10px 20px;
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
</style>