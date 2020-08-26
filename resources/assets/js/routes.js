
import SettingComponent from './components/settings/SettingComponent';

import Settingsecurity from './components/settings/Settingsecurity';

import Settingbasic from './components/settings/Settingbasic';

import UserFollowing from './components/settings/UserFollowing';

import SchoolFollowing from './components/settings/SchoolFollowing';

import UserAds from './components/settings/UserAds';

import UserRecommendations from './components/settings/UserRecommendations';

import BlockUser from './components/settings/BlockUser';

import NetworkComponent from './components/network/NetworkComponent';

import  NewsComponent from './components/news/NewsComponent';

import  JoblistingComponent from './components/jobs/JoblistingComponent';

import  ListingComponent from './components/schools/ListingComponent';

import  AdslistingComponent from './components/classifieds/AdslistingComponent';

import  SchoolMainDetail from './components/schools/SchoolMainDetail';

import  JobdetailComponent  from './components/jobs/JobdetailComponent';

import  DetailComponent  from './components/classifieds/DetailComponent';

import  ClassifiedPost  from './components/classifieds/ClassifiedPost';

import  LoginComponent  from './components/user/LoginComponent';

import  RegisterComponent  from './components/registration/RegisterComponent';

import  HomeComponent  from './components/home/HomeComponent';

import  StaticComponent  from './components/static/StaticComponent';

import  About  from './components/static/About';

import  Privacy  from './components/static/Privacy';

import  Terms  from './components/static/Terms';

import  Contact  from './components/static/Contact';

import  Profile  from './components/user/Profile';

import  FriendComponent  from './components/home/FriendComponent';

import  RegisterSchool  from './components/home/RegisterSchool';

import  ExpatClub  from './components/home/ExpatClub';


import  ChatComponent  from './components/ChatComponent';


import  ParentsLogin  from './components/home/ParentsLogin';

import ProfileWizard from  './components/Wizard/ProfileWizard';


import PostDetail from  './components/news/PostDetail';


let fullPath = 'http://localhost:8001/'; //https://test.expatsschools.com/';//http://localhost:8001/'; //https://beta.expatsschools.com/';


export const routes = [

    {
        path: '/es', component: StaticComponent, props: {fullPath},

        children: [
                {

                    path: 'about',
                    component: About,
                    props:{ fullPath }
                },
                {

                    path: 'contact',
                    component: Contact,
                    props:{ fullPath }
                },
                {

                    path: 'privacy',
                    component: Privacy,
                    props:{ fullPath }
                },

                {

                    path: 'terms',
                    component: Terms,
                    props:{ fullPath }
                },

            ]

    },

    { path: '/settings', component: SettingComponent,props:{ fullPath },

        children: [
            {

                path: 'basic',

                component: Settingbasic,

                props:{ fullPath }
            },
            {
                path: 'security',

                component: Settingsecurity,

                props:{ fullPath }
            },

            {
                path: 'user-following',

                component: UserFollowing,

                props:{ fullPath }
            },

            {
                path: 'school-following',

                component: SchoolFollowing,

                props:{ fullPath }
            },

            {
                path: 'user-ads',

                component: UserAds,

                props:{ fullPath }
            },

            {
                path: 'recommendations',

                component: UserRecommendations,

                props:{ fullPath }
            },

            {
                path: 'block-users',

                component: BlockUser,

                props:{ fullPath }
            },

            {
                path: 'settings-favortie',

                component: Settingbasic,

                props:{ fullPath }
            },




         ]



    },

    { path: '/inbox',   component: ChatComponent, props:{ fullPath },},

    { path: '/inbox/:id',   component: ChatComponent, props:{ fullPath } },




    { path: '/network',   component: NetworkComponent },

    { path: '/news',   component: NewsComponent },

    { path: '/jobs',   component: JoblistingComponent },

    { path: '/classifieds',   component: AdslistingComponent },

    { path: '/schools',   component: ListingComponent },

    { path: '/school/:url',   component: SchoolMainDetail, props:{ fullPath }},

    { path: '/jobs/:school_url/:job_url',   component: JobdetailComponent, props:{ fullPath }},

    { path: '/classifieds/post',   component: ClassifiedPost, props:{ fullPath }},

    { path: '/classifieds/:url',   component: DetailComponent, props:{ fullPath }},

    { path: '/login',   component: LoginComponent, props:{ fullPath }},

    { path: '/registration',   component: RegisterComponent, props:{ fullPath }},

    { path: '/',   component: HomeComponent, props:{ fullPath }},

    { path: '/profile/:username',   component: Profile, props:{ fullPath }},

    { path: '/friends/:url',   component: FriendComponent, props:{ fullPath }},

    { path: '/register-your-school',   component: RegisterSchool, props:{ fullPath }},

    { path: '/expat-teachers-club',   component: ExpatClub, props:{ fullPath }},

    { path: '/parents',   component: ParentsLogin, props:{ fullPath }},

    { path: '/profile_wizard/:type',   component: ProfileWizard, props:{ fullPath }},

    { path: '/account/email-verification',   component: ProfileWizard, props:{ fullPath }},

    { path: '/posts/:username/:url',   component: PostDetail, props:{ fullPath }},



];




