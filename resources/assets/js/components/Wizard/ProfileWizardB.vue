<template>
<div>

    <div v-if="loader===1" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>


    <main class="authorize profile-wizard-page">


        <div class="user-box">


            <a :href="home_url"><img :src="logoa" alt="Expats logo"></a>


            <ul class="nav nav-wizard" id="pills-tab" role="tablist">

                <li class="nav-item">

                    <a :class="tabSelected===1? 'active': ''" id="pills-step-1-tab" data-toggle="pill"  @click.prevent="" role="tab">1</a>

                </li>

                <li class="nav-item">

                    <a  :class="tabSelected===2? 'active': ''"  @click.prevent=""  role="tab">2</a>

                </li>

                <li class="nav-item">

                    <a :class="tabSelected===3? 'active': ''"  @click.prevent=""  role="tab">3</a>

                </li>

                <li class="nav-item">

                    <a :class="tabSelected===4? 'active': ''"  @click.prevent=""  role="tab">4</a>

                </li>

            </ul>



            <div class="tab-content wizard" id="pills-tabContent">


                <step1
                        v-if="step===1"

                        :full-path="fullPath">


                </step1>



                <parent-step2

                        v-if="step===2 && init_choice === 'parent' "

                        :full-path="fullPath"
                    >


                </parent-step2>

                <step2
                        v-if="step===2  && init_choice === 'teacher'  "

                        :full-path="fullPath">


                </step2>



                <step3
                        v-if="step===3"

                        :full-path="fullPath">


                </step3>

                <step4
                        v-if="step===4"

                        :full-path="fullPath">


                </step4>



            </div>

        </div>

    </main>



</div>

</template>

<script>



    import Step1 from './Step1';

    import Step2 from './Step2';

    import Step3 from './Step3';

    import Step4 from './Step4';

    import ParentStep2 from './ParentStep2';


    export default {

        name: "profile",

        props:  ['fullPath', 'user', 'v', 'user_data_standard'],

        components:  {

            Step1,

            Step2,

            Step3,

            Step4,

            ParentStep2

        },

        data() {


            return {

                loader: 1,

                icon_edit: this.fullPath + 'css/ico/symbol-defs.svg#icon-mode_edit',

                icon_del:   this.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

                icon_adds: this.fullPath + 'css/ico/symbol-defs.svg#icon-add',

                icon_check: this.fullPath + 'css/ico/symbol-defs.svg#icon-check',

                icon_open_in_new: this.fullPath + 'css/ico/symbol-defs.svg#icon-open_in_new',

                icon_people:  this.fullPath + 'css/ico/symbol-defs.svg#icon-people',

                logoa: this.fullPath + 'css/img/logoa.png',

                step: 1,

                tabSelected: 1,

                first_name: '',

                last_name: '',

                country: '',

                city: '',

                init_choice: lscache.get('init_choice'),

                home_url:  this.fullPath,




            }
        },

        created() {



            if( this.v  !==   0 )  {

                let user_follower =  [];

                lscache.set('user_follower', user_follower );

                let user_activity  = [];

                let user_likes 	   = [];

                let user_activity_arr = [];

                for( let i = 0; i < user_activity.length; i ++ )
                {

                    user_activity_arr.push( user_activity[i].object_id );

                }

                lscache.set('user_likes', user_activity_arr );

                lscache.set('user_block', [] );

                lscache.set('user', 1 );

                lscache.set('user_data', this.user_data_standard );

                console.log(  lscache.get('user_data') );

                lscache.set('favourite', [] );

                this.step  = 2;
                this.loader = 0;


            } else {

                this.loader = 0;
            }

        }



    }
</script>

<style scoped>


    .user-box-bill{

        margin: 0 auto;

        background-color: #fff;

        -webkit-box-shadow: 0px 2px 3px 0px rgba(0, 0, 0, 0.33);

        width: 600px;

    }
    .user-box-logo{


        text-align: center;
        margin: 0 auto;
        display: block;
        margin-bottom: 30px;
        padding-top: 20px;

    }



</style>