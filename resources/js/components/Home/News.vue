<template>
    <div class="home-item-container">
        <div class="home-item-header">
            <div></div>
            <div>かんたんなニュース</div>
            <div></div>
        </div>
        <div class="news-summary">
            <div>
                <div><!-- cái block này sẽ đổ xún -->
                    <div v-for="item in newsList" class="news-summary-item">
                        <div>
                            <div class="thumbnail-dv">
                                <img :src="item.thumbnail">
                            </div>
                        </div>
                        <div class="news-content">
                            <div>{{item.title}}</div>
                            <div>{{item.content}}</div>
                            <div>
                                <span>{{item.updated_date}}</span>
                                <span class="continue-read-dv"><router-link :to="{ name: 'news_content', params: {id: item.id } }">読み続けて…</router-link></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                newsList: [
                    {
                        id: 1,
                        title: "タイトル１",
                        content: "これから、一所懸命コードを練習して、日本語を勉強している。",
                        thumbnail: "/images/wall/1.png",
                        author: "Ngoc Dung",
                        source_url: "",
                        updated_date: "2021/09/11 22:11"
                    },
                    {
                        id: 2,
                        title: "タイトル２",
                        content: "TVアニメ「ボールルームへようこそ」Blu-ray&DVD全巻購入特典「原作・竹内友先生描き下ろし オリジナル短編漫画」の送付について大変遅れており申し訳ございません。こちら目処が立ちまして12月24日週のお届けを予定しておりますので、今しばらくお待ち頂けますと幸いです。こちら大変お待たせを致しましたが、2018年12月24日週のお届けを予定しておりますので、\n" +
                            "今しばらくお待ち頂けますと幸いでございます。",
                        thumbnail: "/images/wall/2.jpg",
                        author: "ルフィ",
                        source_url: "",
                        updated_date: "2021/09/11 20:15"
                    },
                    {
                        id: 3,
                        title: "タイトル３",
                        content: "自分は『ボールルームへようこそ』を見て、社交ダンスを始めてこんなに初めて大好きと思える習い事に出会いました！自分は多々良くんのように見て覚える才能があると初めて知りましたボールルームへようこそに出会って少し世界が変わりました大げさかもしれませんが本当に出会えてよかったです！",
                        thumbnail: "/images/wall/3.jpg",
                        author: "サンジ",
                        source_url: "",
                        updated_date: "2021/09/11 19:11"
                    },
                    {
                        id: 4,
                        title: "タイトル４",
                        content: "シーズン2っていつやるんですか？？\nめっちゃ見たです！！！！！！",
                        thumbnail: "/images/wall/4.png",
                        author: "ゾロ",
                        source_url: "",
                        updated_date: "2021/09/11 19:00"
                    },
                    {
                        id: 5,
                        title: "和歌山県白浜町チーターの赤ちゃんが元気に大きくなる",
                        content: "国くにや市しなどは毎年まいとし、小学校しょうがっこうや中学校ちゅうがっこうに通かよっていない子こどもを調しらべています。しかし、外国人がいこくじんの子こどもについては調しらべていません。\n" +
                            "\n" +
                            "ＮＨＫは専門家せんもんかと一緒いっしょに、国くにのデータなどを調しらべて、外国人がいこくじんの子こどものうち、学校がっこうに通かよっていない子こどもがどのぐらいいるか計算けいさんしました。\n" +
                            "\n" +
                            "去年きょねん、６歳さいから１４歳さいまでの外国人がいこくじんの子こどもが日本にっぽんに１２万まん人にんぐらいいました。このうち８４００人にんぐらいが学校がっこうに通かよっていない可能性かのうせいがあることがわかりました。この中なかには、外国人がいこくじんのための学校がっこうに通かよっている子こどもや、自分じぶんの国くにへ帰かえった子こどももいるようです。\n" +
                            "\n" +
                            "専門家せんもんかは「日本にっぽんの将来しょうらいのためにも、外国人がいこくじんの子こどもたちの教育きょういくをどうしたらいいか考かんがえなければなりません」と話はなしています。",
                        thumbnail: "/images/wall/5.jpg",
                        author: "サスケ",
                        source_url: "",
                        updated_date: "2021/09/10 09:00"
                    },
                ]
            }
        }
    }
</script>

<style scoped>
    .news-summary {
        padding: 10px;
        background: #DEDEDE;
        height: 400px;
    }
    .news-summary>div {
        height: 100%;
        overflow: hidden;
        overflow-y: scroll;
    }
    .news-summary>div::-webkit-scrollbar {
        width: 0;
    }
    .news-summary-item {
        width: 100%;
        overflow: hidden;
        display: flex;
        height: 125px;
        padding: 5px;
    }
    .news-summary-item>div:first-child {
        width: 185px;
        display: flex;
    }
    .news-summary-item>div {
        padding: 5px 10px;
        width: 100%;
    }

    .thumbnail-dv {
        overflow: hidden;
        display: flex;
        justify-items: center;
        width: 100%;
    }
    .thumbnail-dv>img {
        width: 100%;
        object-fit: cover;
    }

    .news-content {
        overflow: hidden;
        position: relative;
    }
    .news-content>div:first-child {
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
    }
    .news-content>div:nth-child(2) {
        font-size: 13px;
        height: 60px;
        overflow: hidden;
    }
    .news-content>div:nth-child(3) {
        position: absolute;
        bottom: 0;
        font-size: 12px;
        width: 100%;
        font-style: italic;
    }

    .continue-read-dv {
        text-decoration: underline;
        position: absolute;
        right: 0;
        cursor: pointer;
        color: #2B4C8C;
        margin-right: 20px;
    }

    .continue-read-dv:hover {
        text-decoration: underline;
        text-underline: #2B4C8C;
    }
</style>