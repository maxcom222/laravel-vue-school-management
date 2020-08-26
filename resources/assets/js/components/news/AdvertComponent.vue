<template>


    <div>

        <div class="frame recommendations">


            <div class="footer">

                <a @click.prevent="aboutUrl" :href="about_url">About</a> <span>·</span>

                <a @click.prevent="contactUrl"  :href="help_url">Help Center</a> <span>·</span>

                <a @click.prevent="privacyUrl"  :href="privacy_url">Privacy Policy</a> <span>·</span>

                <a @click.prevent="termUrl"  :href="term_url">Term &amp; Conditions</a> <span>·</span>

                <small>© {{ new Date().getFullYear() }}. All Rights Reserved.</small>

            </div>

        </div>

    </div>

</template>

<script>
    export default {


        name: "AdvertComponent",

        props:['fullPath'],


        data() {

            return {

                about_url : this.fullPath + 'about',

                privacy_url : this.fullPath + 'privacy',

                term_url : this.fullPath + 'terms',

                help_url : this.fullPath + 'help',


            }



        },

        methods:{


            aboutUrl(){

                this.$router.push('/es/about');
            },
            privacyUrl(){

                this.$router.push('/es/privacy');
            },
            termUrl(){

                this.$router.push('/es/terms');
            },

            contactUrl(){

                this.$router.push('/es/contact');
            }
        }
    }
</script>

<style scoped>

</style>