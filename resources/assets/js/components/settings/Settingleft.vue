<template>


<div>


    <ul class="settings">

        <router-link  tag="li" active-class="active" to="/settings/basic" >
            <a>

                <svg class="icon icon-account_circle">

                    <use :xlink:href="icon_account">

                    </use>

                </svg>

                Basic

            </a>

        </router-link>




        <router-link  tag="li"  active-class="active" to="/settings/security" >
            <a>
                <svg class="icon icon-verified_user">

                    <use :xlink:href="icon_supp"></use>

                </svg>
                Security

            </a>
        </router-link>


        <router-link  tag="li"  active-class="active" to="/settings/user-following" >
            <a >

                <svg class="icon icon-supervisor_account">

                    <use :xlink:href="icon_s"></use>

                </svg>

                People you are following

            </a>
        </router-link>


        <router-link  tag="li"  active-class="active" to="/settings/school-following" >
            <a >

                <svg class="icon icon-graduation-cap">

                    <use :xlink:href="icon_g"></use>

                </svg> Schools you are following


            </a>
        </router-link>

        <router-link  tag="li"  active-class="active" to="/settings/user-ads" >
            <a >

                <svg class="icon icon-local_offer">

                    <use :xlink:href="icon_local"></use>

                </svg> Ads


            </a>
        </router-link>


        <router-link  tag="li"   active-class="active" to="settings-favortie" >
            <a>

                <svg class="icon icon-favorite">

                    <use :xlink:href="icon_fav"></use>

                </svg>

                Favorite

            </a>

        </router-link>



        <router-link  tag="li" active-class="active"   to="/settings/recommendations" >
            <a>

                <svg class="icon icon-verified_user">

                    <use :xlink:href="icon_v"></use>

                </svg>

                Recommendations

            </a>

        </router-link>




        <router-link  tag="li" active-class="active"   to="/settings/block-users" >
            <a>

                <svg class="icon icon-block">
                     <use :xlink:href="icon_block"></use>
                </svg>

                Block User

            </a>

        </router-link>




    </ul>

</div>

</template>

<script>
    export default {


        name: "Settingleft",

        props:['fullPath'],


        data() {

            return {

                about_url : this.fullPath + 'about',

                privacy_url : this.fullPath + 'about',

                term_url : this.fullPath + 'about',

                help_url : this.fullPath + 'about',

                setting_fav_url:   this.fullPath  +  'user/settings-favorties',

                security_url:   this.fullPath + 'settings-security',

                restrict_url:  this.fullPath +  'settings/restricted_user',

                rec_url :  this.fullPath + 'user/settings-recommendations',

                school_f_url: this.fullPath + 'user/settings-schools-followers',

                user_f_url:  this.fullPath + 'user/settings-followers',

                settings_f_url: this.fullPath + 'user/settings-ads',

                setting_b_url:  this.fullPath + 'user/settings-basic',

                settings_ad_url: this.fullPath + 'user/settings-ads',




                icon_account: this.fullPath + 'css/ico/symbol-defs.svg#icon-account_circle',

                icon_block: this.fullPath + 'css/ico/symbol-defs.svg#icon-block',

                icon_v:  this.fullPath + 'css/ico/symbol-defs.svg#icon-verified_user',

                icon_g:   this.fullPath + 'css/plugins/menu/symbol-defs.svg#icon-graduation-cap',



                icon_s: this.fullPath + 'css/ico/symbol-defs.svg#icon-supervisor_account',

                icon_local:  this.fullPath + 'css/ico/symbol-defs.svg#icon-local_offer',

                icon_supp: this.fullPath +'css/ico/symbol-defs.svg#icon-verified_user',

                icon_fav: this.fullPath  +'css/ico/symbol-defs.svg#icon-favorite',




        }



        },
    }
</script>

<style scoped>

    .router-link-active  a{     color: #01ae79; }

    .router-link-exact-active.active {
    background: #34495e;
}

    ul.settings li.active a,  ul.settings li:hover a {
        color: #FFF;
        text-shadow: 0 0 6px rgba(0, 0, 0, 1);
    }

    ul.settings li.active a .icon,   ul.settings li:hover a .icon {
        color: #FFF;
    }

    ul.settings li:hover{

        background: #34495e;
    }

</style>