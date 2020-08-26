<template>



    <div class="frame school-panel  job-info">

        <div>
            <a :href="profile_url" class="logo-small">
            <img
                    :src="logo"

                    style="height:80px;" :alt="jobItem.school_name">
             </a>
        </div>

        <h2>{{ jobItem.title }}</h2>

        <span class="text-muted">{{ jobItem.school_name }}</span>

        <div>
            <span class="rating">Contract Type: {{ jobItem.contract_type }}</span>


            <span class="people">Last Date: {{ jobItem.apply_before }}</span></div>

        <p>{{  description }}</p>

        <a :href="job_url" @click.prevent="jobUrl()" class="btn btn-sm btn-view ">
            View Job
            <svg class="icon icon-keyboard_arrow_right">

             <use :xlink:href="icon_right"></use>

            </svg>
        </a>

    </div>




</template>

<script>
    export default {

        name: "JobitemComponent",

        props: ['jobItem', 'fullPath'],

        data(){
            return{

                icon_right : this.fullPath + 'css/ico/symbol-defs.svg#icon-keyboard_arrow_right',

            }
        },

        computed: {

            description()  {

                let description  = this.stripHtml  ( this.jobItem.description  ) ;

                return description.substring(0, 300 ) + '...';

            },

            profile_url() {

                return this.fullPath + 'school/' + this.jobItem.school_url  ;
            },
            logo()  {

                return 'https://d2heijv3bffmsx.cloudfront.net/' + this.jobItem.logo;
            },

            job_url(){

                return this.fullPath + 'jobs/'+  this.jobItem.school_url + '/' +    this.jobItem.url;
            },

        },

        methods: {

            jobUrl(){

                this.$router.push('jobs/'+  this.jobItem.school_url + '/' +    this.jobItem.url);
                //return this.fullPath + 'jobs/'+  this.jobItem.school_url + '/' +    this.jobItem.url;
            },

            stripHtml(  html ) {

                var temporalDivElement = document.createElement("div");

                temporalDivElement.innerHTML = html;

                return temporalDivElement.textContent || temporalDivElement.innerText || "";
            },



        },
        created() {


        },



    }
</script>

<style scoped>

</style>