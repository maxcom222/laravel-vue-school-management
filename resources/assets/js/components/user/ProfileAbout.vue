<template>


    <div>


        <div class="frame"    >

            <a href="" class="btn-edit" @click.prevent="switchAbout"  v-if="selfView===1">

                <svg class="icon icon-mode_edit">

                    <use :xlink:href="this.$parent.icon_edit">

                    </use>

                </svg>

            </a>

            <h2>About me/Biography</h2>


            <p v-if="showAbout===true">

                {{  about_text }}

            </p>
            <div v-if="showAbout===false">

                 <textarea

                         ref="about_text"

                         v-model="about_text"

                         class="form-control"

                         placeholder="Write about yourself"

                 >


                 </textarea>

                <p v-if="isProgress" class="alert-success nice-padding">

                    Saving your data

                </p>

                <button @click="saveAbout" type="button" class="btn btn-primary  mg-top-10 mg-bottom-10">Save</button>

            </div>






        </div>







    </div>

</template>



<script>
export default {

    name: "ProfileAbout",

    props: ['fullPath', 'user', 'selfView'],


    data()  {


        return{

            showAbout: true,

            isProgress: false,

            about_text: this.user.about,

        }
    },

    computed: {


    },

    methods:{


        switchAbout() {

            this.showAbout = false;

        },
        saveAbout() {

            this.isProgress =  true;



            axios.post( this.fullPath + 'user/profile/save_about', {  about_text:  this.about_text } )
                .then( res => {

                    this.isProgress = false;

                    this.showAbout = true;

                });

        }


    },



    created() {

        this.about_text =  this.user.about;

    }
}
</script>

<style scoped>
textarea {
    height: 200px;
}
</style>