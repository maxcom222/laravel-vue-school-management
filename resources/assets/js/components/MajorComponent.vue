<template>
<div>


       <router-view  :key="$route.fullPath"></router-view>
</div>

</template>

<script>

    export default {


        name: "MajorComponent",

        props:[

            'fullPath',

            'expatsFriends',

            'noHeader',

            'selfView',

            'twitterName',

            'membershipStatus' ,

            'user',

            'userDatastandard',

            'v'


        ],


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

            this.$parent.showMainComponentLoader = false;


        },
        created(){

            this.$parent.noHeader  = this.noHeader;

        }
    }
</script>

<style scoped>


</style>