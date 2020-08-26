<template>


<div>

        <div class="frame recommendations">


            <div class="footer">

                <a :href="about_url">About</a> <span>·</span>

                <a :href="help_url">Help Center</a> <span>·</span>

                <a :href="privacy_url">Privacy Policy</a> <span>·</span>

                <a :href="term_url">Term &amp; Conditions</a> <span>·</span>

                <small>© {{ new Date().getFullYear() }}. All Rights Reserved.</small>

            </div>

        </div>

</div>

</template>

<script>
    export default {


        name: "Settingright",

        props:['fullPath'],


        data() {

            return {

                about_url : this.fullPath + 'about',

                privacy_url : this.fullPath + 'privacy',

                term_url : this.fullPath + 'terms',

                help_url : this.fullPath + 'help',


            }



        },
    }
</script>

<style scoped>

</style>