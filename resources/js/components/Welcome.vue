<template>
    <div>
        <div>
            <div style="color: #EBF0FA; font-weight: bold; text-align: center; margin: 50px; font-size: 40px;">
                <router-link to="/home">練習アプリへようこそ</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Welcome',
        data() {
            return {
                authType: 0
            }
        },
        methods: {

        }
    }
</script>