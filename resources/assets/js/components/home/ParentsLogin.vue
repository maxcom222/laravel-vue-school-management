<template>
    <div>


        <header class="page-title bg-feed">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1>You are signed in as a parent</h1>
                    </div>
                </div>
            </div>
        </header>


        <main>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="frame">

                            <div class="teachers" id="faqs">
                                <ul>

                                    <li><div><a @click.prevent="profileUrl()"  href=""><svg class="icon icon-person">
                                        
                                        <use :xlink:href="icon_person"></use></svg></a><span   @click="profileUrl()">

                                        <i   class="spot-text">

                                            My Profile</i> - As a parent, you may wish to work, or volunteer in a school. This profile can help your children's school seek out key expertise in their community.</span></div></li>

                                    <li><div><a href=""  @click.prevent="networkUrl()" >
                                        
                                        <svg class="icon icon-handshake-o">
                                            
                                            <use :xlink:href="icon_handshake"></use></svg></a>

                                        <span  @click="networkUrl()"><i   class="spot-text">Network</i> - Make meaningful connections with other parents in your school.</span></div></li>

                                    <li><div><a @click.prevent="inboxUrl"  href=""><svg class="icon icon-comment">
                                        
                                        <use :xlink:href="icon_comment"></use></svg></a> <span @click="inboxUrl"><i  class="spot-text">Inbox</i> - message other users, You may want to contact teachers or parents connected to a school you are or might be moving your children to. You can also message teachers or have made themselves available for tutoring.</span></div></li>

                                    <li><div><a @click.prevent="newsUrl()"  href=""><svg class="icon icon-coffee">
                                        
                                        <use :xlink:href="icon_coffee"></use></svg></a><span @click="newsUrl()"><i class="spot-text">News and Views</i> - Post articles on thought-provoking topics. Our partners at various educational magazines may wish to publish you. You may wish to post a question to another school.</span></div></li>

                                    <li><div><a @click.prevent="adUrl()"  href=""><svg class="icon icon-bullhorn">
                                        
                                        <use :xlink:href="icon_bullhorn"></use></svg></a><span  @click="adUrl()"><i    class="spot-text">Classifieds</i> - Uniforms, general items etc... We have a trusted place to advertise where you can filter your own school community.</span></div></li>

                                    <li><div><a @click.prevent="jobUrl()"  href=""><svg class="icon icon-suitcase">
                                        
                                        <use :xlink:href="icon_suitcase"></use></svg></a><span @click="jobUrl()"><i   class="spot-text">Jobs</i> - Search for jobs you may be interested in. Doesn't matter if you're not currently employed. Build you profile and see where it can take you.</span></div></li>

                                    <li><div><a @click.prevent="schoolUrl()"   href=""><svg class="icon icon-graduation-cap">
                                        
                                        <use :xlink:href="icon_graduation"></use></svg></a><span @click="schoolUrl()" ><i   class="spot-text">Schools</i> - Search for schools and do your research. Check out their profile pages and compare them in a fair way. Look at who works there and any articles or galleries they have shared.</span></div></li>

                                </ul>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
</template>

<script>
    export default {

        name: "ParentsLogin",

        props:['fullPath'],

        data(){


            return {

                icon_comment: this.fullPath  + 'js/plugins/menu/symbol-defs.svg#icon-comment',

                icon_handshake: this.fullPath  + 'js/plugins/menu/symbol-defs.svg#icon-icon-handshake-o',

                icon_graduation: this.fullPath  + 'js/plugins/menu/symbol-defs.svg#icon-graduation-cap',

                icon_coffee: this.fullPath  + 'js/plugins/menu/symbol-defs.svg#icon-coffee',

                icon_bullhorn: this.fullPath  + 'js/plugins/menu/symbol-defs.svg#icon-bullhorn',

                icon_suitcase: this.fullPath  + 'js/plugins/menu/symbol-defs.svg#icon-suitcase',

                icon_person:  this.fullPath  + 'css/ico/symbol-defs.svg#icon-person',

                user: lscache.get('user_data'),


            }
        },

        methods:{


            schoolUrl(){

                this.$router.push('/schools');
            },

            profileUrl(){

                this.$router.push('/profile/' + this.user.username );
            },


            inboxUrl(){

                this.$router.push('/inbox');
            },


            adUrl(){

                this.$router.push('/classifieds');
            },

            jobUrl(){

                this.$router.push('/jobs');
            },

            newsUrl(){

                this.$router.push('/news');
            },

            networkUrl(){

                this.$router.push('/network');
            },

        },
    }
</script>

<style scoped>

</style>