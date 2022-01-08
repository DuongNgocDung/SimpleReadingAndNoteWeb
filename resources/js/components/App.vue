<template>
    <div v-if="isLoading===false">
        <v-main-header :user_info="user_info"></v-main-header>
        <v-main-view :user_info="user_info"></v-main-view>
    </div>
</template>

<script>
    import axios from 'axios'
    import vMainView from '../components/Base/MainView'
    import vMainHeader from '../components/Base/MainHeader'

    export default {
        name: 'app',
        created() {
            console.log("create App.vue");
            this.loadAppInfo();
        },
        data() {
            return {
                isLoading: true,
                user_info: null
            }
        },
        methods: {
            async loadAppInfo() {
                await axios.post('/user/app-info')
                    .then(response => {
                        if (response && response.data && response.data.status === 1) {
                            this.user_info = response.data.user_info;
                            console.log("this.user_info in app.vue : ", this.user_info, this.user_info.first_name);
                        }
                        this.isLoading = false;
                    }).catch(function (error) {
                        console.log(error);
                        this.isLoading = false;
                    });
            }
        },
        components: {
            vMainView,
            vMainHeader
        }
    }
</script>