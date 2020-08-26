<template>


<div>

       <h1> Main </h1>

       <router-view></router-view>
</div>

</template>

<script>

    export default {


        name: "Settingmain",

        props:['fullPath'],


        data() {

            return {

                about_url : this.fullPath + 'about',

                privacy_url : this.fullPath + 'about',

                term_url : this.fullPath + 'about',

                help_url : this.fullPath + 'about',

                page : '',






            }



        },

        mounted(){


        }
    }
</script>

<style scoped>


</style>