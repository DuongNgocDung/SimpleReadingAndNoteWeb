<template>
    <div>
        <div v-if="isLoading===false" class="login-form-container">
            <div>
                <span>メールアドレス/ユーザー名</span>
                <input type="text" v-model="login_id"/>
            </div>
            <div>
                <span>パスワード</span>
                <input type="password" v-model="password"/>
            </div>
            <div class="tl-center mt-40p">
                <button @click="handleLogin">ログイン</button>
                <button class="delete-btn">キャンセル</button>
            </div>
            <div class="tl-center">
                <span>初めての方は<span class="register-link" @click="getRegisterLink()">新規会員登録</span></span>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'

    export default {
        props: ['user_info'],
        data() {
            return {
                isLoading: true,
                isLogout: false,
                login_id: "",
                password: ""
            }
        },
        mounted() {
            if (this.$route.name === 'logout') {
                this.isLogout = true;

            } else { // handle login
                if (this.user_info && this.user_info.user_id) { // already login
                    this.$router.push({name: 'home'});
                }
            }
        },
        methods: {
            handleLogin() {
                if (this.login_id === "" || this.password === "") {
                    console.log("login_id & password are required");
                }
                axios.post('/user/confirm-login', {
                    login_id: this.login_id,
                    password: this.password
                }).then(response => {
                    if (response.data && response.data.status === 1 && response.data.data && response.data.data.user_id) {
                        console.log("login success !!!");
                        let redirectUrl = 'home';
                        this.$router.push({name: `${redirectUrl}`});
                        window.location.href = 'http://open.door/home';
                    }
                });
            },
            async handleLogout() {
                let url = '/user/logout';
                await axios.post(url, {
                    user_id: this.user_info.user_id
                }).then(response => {
                    console.log(response.data);
                    window.location.href = 'http://open.door/home';
                })
            },
            getRegisterLink() {
                let name = 'register_account';
                this.$router.push({name: `${name}`});
            }
        }
    }
</script>
<style scoped>
    .login-form-container {
        margin: auto;
        padding-top: 50px;
        width: 50%;
        max-width: 500px;
        min-width: 400px;
        color: white;
        cursor: default;
    }
    .login-form-container > div {
        padding: 10px;
    }
    .login-form-container input {
        padding: 8px 12px 7px !important;
        font-size: 16px;
    }
    .register-link {
        color: #3D6EF5;
        cursor:pointer;
    }
    .register-link:hover {
        color: #255CF4;
    }
</style>