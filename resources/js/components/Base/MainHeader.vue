<template>
    <div class="main-header">
        <nav class="navbar navbar-expand-sm navbar-dv">
            <div>
                <div class="menu-item menu-home"><a href="#"><router-link to="/">好きにやる</router-link></a></div>
                <div v-if="authType === 0 || authType === 3" class="menu-item"><a href="#"><router-link to="/lesson">レッスン</router-link></a></div>
                <div v-if="authType === 0 || authType === 3" class="menu-item"><a href="#"><router-link to="/news">かんたんなニュース</router-link></a></div>
                <div v-if="authType === 2" class="menu-item"><a href="#"><router-link to="/admin">管理</router-link></a></div>
            </div>
            <div class="dropdown">
                <div class="flex">
                    <div class="member-name mr-10p">{{userName}}<span>様</span></div>
                    <div class="avatar-dv right-0" @click="isOpenDropdown=!isOpenDropdown">
                        <img src="/images/avatar/1.png">
                    </div>
                </div>
                <div v-if="isOpenDropdown" class="dropdown-list right-0">
                    <div class="dropdown-item tl-right" @click="isOpenDropdown=false"><span>somethisn</span></div>
                    <div class="dropdown-item tl-right" @click="isOpenDropdown=false"><router-link to="/login">ログイン</router-link></div>
                </div>
            </div>
        </nav>
    </div>
</template>
<script>
    export default {
        props: ['user_info'],
        created() {
            console.log("main header : ", this.user_info);
            this.authType = this.user_info && this.user_info.auth_type || 0;
            this.userName = this.user_info && this.user_info.first_name || 'ゲスト';
        },
        data() {
            return {
                authType: 0,
                userName: 'ゲスト',
                isOpenDropdown: false
            }
        }
    }
</script>
<style scoped>
    .navbar-dv {
        background-color: #062578;
        display: flex;
        justify-content: space-between;
        padding: 0 !important;
    }
    .navbar-dv>div {
        display: flex;
    }
    .navbar-dv>div>div {
        margin: 5px 30px;
    }

    .navbar-dv>div>div>a {
        color: #EBF0FA !important;
        font-weight: bold !important;
        text-decoration: none;
        font-size: 13px;
    }
    .menu-home>a {
        font-size: 20px !important;
        padding-top: .5rem;
        padding-bottom: .5rem;
    }
    .menu-item {
        padding-top: 12px;
        padding-bottom: 8px;
    }
    .member-name {
        padding-top: 12px;
        padding-bottom: 8px;
        color: #EBF0FA;
        font-size: 16px;
        cursor: default;
    }
    .avatar-dv {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        background: #EBF0FA;
        justify-items: center;
        overflow: hidden;
        cursor: pointer;
    }
    .avatar-dv>img {
        object-fit: cover;
        height: 100%;
    }
    .dropdown {
        position: relative;
        display: inline-block !important;
    }
    .dropdown-list {
        background: #EBF0FA;
        margin-top: 5px;
        position: absolute;
        z-index: 10;
        width: fit-content;
    }
    .dropdown-item {
        word-break: keep-all;
        display: block;
        width: 100%;
        padding: 5px 10px;
        transition: 0.3s;
        position: relative;
        cursor: pointer;
    }
    .dropdown-item:hover {
        background: #C2D1F0;
    }
</style>