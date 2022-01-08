<template>
    <div class="content-container">
        <div class="p-10p tl-center">新規会員登録</div>
        <div class="register-form-container">
            <div>
                <span>名</span>
                <input type="text" v-model="register_data.first_name"/>
            </div>
            <div>
                <span>苗字</span>
                <input type="text" v-model="register_data.last_name"/>
            </div>
            <div>
                <span>メールアドレス/ユーザー名</span>
                <input type="text" v-model="register_data.login_id"/>
            </div>
            <div>
                <span>パスワード(半角英数字8文字以上)</span>
                <input type="password" v-model="register_data.password"/>
            </div>
            <div>
                <span>パスワードを再入力</span>
                <input type="password" v-model="register_data.confirm_password"/>
            </div>
            <div class="tl-center mt-40p">
                <button @click="handleRegister()">設定する</button>
                <button class="delete-btn">キャンセル</button>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                register_data: {
                    first_name: "",
                    last_name: "",
                    login_id: "",
                    password: "",
                    confirm_password: ""
                }
            }
        },
        mounted() {
            console.log("mounted login vue");
        },
        methods: {
            handleRegister() {
                if (this.register_data.login_id === "" || this.register_data.password === "" || this.register_data.confirm_password) {
                    console.log("login_id & password are required");
                }
                axios.post('/user/register', {
                    first_name: this.register_data.first_name,
                    last_name: this.register_data.last_name,
                    login_id: this.register_data.login_id,
                    password: this.register_data.password,
                    confirm_password: this.register_data.confirm_password,
                }).then(response => {
                    console.log(response.data);
                    if (response.data.status === 1 && response.data.data && response.data.data.user_id) {
                        console.log("login success");
                    }
                });
            }
        }
    }
</script>
<style scoped>
    .content-container {
        margin: auto;
        padding-top: 50px;
        width: 50%;
        max-width: 500px;
        min-width: 400px;
        color: white;
    }
    .register-form-container > div {
        padding: 10px;
    }
    .register-form-container input {
        padding: 8px 12px 7px !important;
        font-size: 16px;
    }
</style>