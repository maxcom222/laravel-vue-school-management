<template>
    <div>
        <footer v-if="noHeader===0">
            <div class="container">
                <div class="row">
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3">
                        <a href="" @click.prevent="" ><img :src="footerImage" alt=""></a>
                        <p>Tipping the Balance</p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3"></div>
                    <div class="col-12 col-md-6 col-lg-3 "></div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <h4>Sitemap</h4>
                        <ul>

                            <router-link  tag="li" to="/es/about" >
                                <a> About  us </a>
                            </router-link>

                            <router-link  tag="li" to="/es/privacy" >
                                <a> Privacy Policy </a>
                            </router-link>

                            <router-link  tag="li" to="/es/terms" >
                                <a> Term and Conditions </a>
                            </router-link>

                            <router-link  tag="li" to="/es/contact" >
                                <a> Contact </a>
                            </router-link>

                            <router-link  tag="li" to="/schools" >
                                <a> Schools </a>
                            </router-link>

                            <router-link  tag="li" to="/network" >
                                <a> Teachers </a>
                            </router-link>

                            <router-link  tag="li" to="/parents" >
                                <a> Parents </a>
                            </router-link>




                        </ul>
                    </div>


                </div>
                <div class="row">
                    <div class="col-12">

                        <p>Copyright {{ new Date('Y')  }} Expats' Schools. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>

    export default {

        props: ['fullPath'],


        name: "FooterComponent",

        data(){

            return{

                footerImage:  this.fullPath + 'css/img/logo-footera.png',

                noHeader: '',

            }
        },
        created(){

            setTimeout(() =>{

                this.noHeader = this.$parent.noHeader;

            }, 400);
        }
    }
</script>

<style scoped>

</style>