<template>


    <div   id="publication">

        <div class="frame" >

            <h2>Publications</h2>


           <div
                   v-for="pub in publication"

                   :key="pub.id"

                   class="feed"

           >

               <div style="width: 100%;padding: 0;">

                      <h2>

                           <a
                                   :href="post_url(pub.id, pub.url)  ">

                               {{ pub.title }}

                           </a>

                       </h2>

                       <small class="text-muted">

                           {{ pub.dated }}

                       </small>

                       </div>

                       <p>{{  description(pub.description)   }}</p>

                        <a :href="post_url(pub.id, pub.url)">
                            read more
                        </a>


               </div>

            
            
        </div>


</div>

</template>



<script>
export default {

    name: "ProfilePublication",

    props: ['fullPath', 'user', 'selfView'],


    data()  {


        return{

            publication:[],


        }
    },

    computed: {



    },



    methods:{

        post_url(id, url ) {


            return this.fullPath  + 'posts/'+ this.user.username + '/' + url ;

        },


        stripHtml(  html ) {

            var temporalDivElement = document.createElement("div");

            temporalDivElement.innerHTML = html;

            return temporalDivElement.textContent || temporalDivElement.innerText || "";
        },




        description( desc ){


            desc = this.stripHtml(  desc );

            if( desc.length > 100 ) {

                return desc.substr(  0, 100 ) +  '...' ;

            } else  {

                return desc;
            }

        },

        loadPublication(){

            axios.post( this.fullPath + 'user/profile/get_post', {uid: this.$parent.user.id} )
                .then( res => {

                    this.publication = res.data.data;

                })

        },

    },

    created() {


        this.loadPublication();



    }
}
</script>

<style scoped>

</style>