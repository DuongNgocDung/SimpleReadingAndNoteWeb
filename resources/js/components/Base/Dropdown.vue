<template>
    <div class="dropdown-container">
        <div class="dropdown-button">
            <div @click="isOpen = !isOpen">bla bla click vào đây</div>
        </div>
        <div v-if="isOpen" class="dropdown-content">
            <div v-for="item in listContent">
                {{item}}
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                isOpen: false,
                listContent: null
            }
        },
        mounted() {
            console.log("sao nè ?")
            this.listContent = ['my baby i love you so...', 'much forever you and i', 'a b c d e...'];
        }
    }
</script>