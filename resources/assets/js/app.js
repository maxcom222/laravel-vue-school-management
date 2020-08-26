
require('./bootstrap');

import vuechatscoll from 'vue-chat-scroll';

import  VueRouter from 'vue-router';

import { routes } from './routes';

import vueselect from 'vue-select';

import Ripple from 'vue-ripple-directive'



import VeeValidate from 'vee-validate';

window.Vue = require('vue');

Vue.use(vuechatscoll);

Vue.use( VueRouter );

export const eventBus = new Vue();


Vue.use(VeeValidate, {
    mode: 'passive'
});


Vue.directive('ripple', Ripple);

const router = new VueRouter({

    routes:routes,

    mode:'history'

});


Vue.component('v-select', vueselect);

Vue.component('header-component', require('./components/layout/Header.vue').default);

//Vue.component('mobile-wizard', require('./components/Wizard/ProfileWizard.vue').default);

Vue.component('major-component', require('./components/MajorComponent.vue').default);

Vue.component('footer-component', require('./components/layout/FooterComponent').default);



let handleOutsideClick;

Vue.directive('closable', {

    bind (el, binding, vnode) {


        handleOutsideClick = (e) => {

            e.stopPropagation();


            const { handler, exclude } = binding.value;


            let clickedOnExcludedEl = false;

            exclude.forEach(refName => {

                if (!clickedOnExcludedEl) {


                    const excludedEl = vnode.context.$refs[refName];

                    if( excludedEl )  {

                        clickedOnExcludedEl = excludedEl.contains(e.target)

                    }

                }
            })


            if (!el.contains(e.target) && !clickedOnExcludedEl) {

                vnode.context[handler]()
            }
        }

        document.addEventListener('click', handleOutsideClick);

        document.addEventListener('touchstart', handleOutsideClick);

    },
    unbind () {

        document.removeEventListener('click', handleOutsideClick);

        document.removeEventListener('touchstart', handleOutsideClick);

    }
});

const app = new Vue({

    el: '#app',

    router: router,

    data: {

        chatMessage: '',

        logoutOption: false,



        chat: {

            message: [],
            user:[],
            color: [],
            time: [],

        },
        typing : '',

        fullPath : 'http://localhost:8001/',// 'https://test.expatsschools.com/', //http://localhost:8001/',//

        authUser: lscache.get('user_data'),

        page: '',

        showMainComponentLoader: true,

        noHeader: '',


    },

    methods: {

        logoutAcrossTabs(){

           document.getElementById('logoutDialog').classList.remove('d-none')

            document.getElementsByTagName('main')[0].style.opacity = '0.1';

            this.logoutOption  = true;
        },

        redirectHome(){

           window.location.href = this.fullPath;
        },


    },

    watch: {
        '$route' (to, from) {

            setTimeout( () => {

                if( to.path === '/'  )  {

                    this.noHeader = 0;
                }

                if( from.path === '/login' ||  from.path === '/registration'   )  {

                    this.noHeader = 0;
                }


                if( to.path === '/login' ||  to.path === '/registration'   )  {

                    this.noHeader = 1;
                }


            }, 10 );

        }
    },

   created() {

       eventBus.$on('hideHeader', (message) => {


           this.noHeader = message.value;

       });


        let  login = lscache.get('user_data');

        if( login !== null ){

        Echo.private( 'userStatusChannel.' + login.id )

           .listen('UserStatus', (e) => {

               if( e.uid ===  login.id){

                   this.logoutAcrossTabs();
               }

           });
        }

   }
});