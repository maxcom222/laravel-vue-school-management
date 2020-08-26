<template>
    <div>


        <section class="spnsrd-slide">

            <div class="container">

                <div class="row justify-content-center">



                            <div   v-for="(obj,index) in schools"   class="item col-md-4 text-center">

                                <a  :href="friend_url(obj.url)" @click.prevent="friendUrl(obj.url)" >

                                    <img
                                            :alt="obj.name"

                                            :src="coverImage(obj.logo)"
                                    >

                                </a>

                                <h3>{{ obj.name  }}</h3>


                            </div>


                    </div>

            </div>
        </section>




    </div>
</template>

<script>

    import carousel from 'vue-owl-carousel'

    export default {

        props: ['fullPath'],

        name: "ParentSchool",

        components: {

            carousel
        },

        data(){


            return {


                schools: [],

                saveProgress: false,

            }
        },

        methods:{

            get_school(){

                let param = { fetch_schools:1 , uid: this.$parent.user.id };

                this.saveProgress = true;

                axios.post(  this.fullPath  + 'user/school/profile_school',  param )

                    .then( res => {

                        this.schools = res.data.data;

                    })

            },

            friend_url(url){


                return  this.fullPath + 'school/' +  url;

            },

            friendUrl( url ){

                this.$router.push( '/school/' + url  );
            },

            coverImage(  logo  ){

                return 'https://d2heijv3bffmsx.cloudfront.net/' + logo;
            },


        },
        created(){


            this.get_school();

        }

    }
</script>

<style scoped>

.spnsrd-slide h3{ font-size: 13px;  margin-top: 10px; }


</style>