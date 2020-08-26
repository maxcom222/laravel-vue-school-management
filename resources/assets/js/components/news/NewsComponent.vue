<template>

    <div>

        <main class="two-cloumn coffe-club">

            <div v-if="loaderRun" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>


            <div class="container">

                <div class="row">

                    <div class="col-12 col-md-8">

                        <search-component

                                :full-path="fullPath"

                        >

                        </search-component>


                        <list-component

                                :full-path="fullPath"

                        >

                        </list-component>





                    </div>

                    <div class="col-12 col-md-4 col-right">

                        <advert-component

                                :full-path="fullPath"

                        >
                        </advert-component>

                    </div>




                </div>

            </div>





        </main>


    </div>

</template>

<script>

    import  AdvertComponent from  './AdvertComponent.vue';

    import  ListComponent from  './ListComponent.vue';

    import  SearchComponent from  './SearchComponent.vue';


    export default{

        name: "NewsComponent",

        props: [],

        data() {

            return{

                loaderRun: false,

                fullPath:  '',
            }

        },

        components:  {


            SearchComponent,

            ListComponent,

            AdvertComponent,

        },
        beforeCreate(){

           /* if ( this.$root.authUser === null ) {

                this.$router.push('/login');

            }*/
        },
        created(){

            this.fullPath = this.$parent.fullPath;

        }
    }
</script>

<style scoped>

</style>