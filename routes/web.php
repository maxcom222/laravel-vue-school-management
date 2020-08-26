<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('template');
});
*/




Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@home');

Route::get('/login', 'HomeController@main') ;

Route::post('/login', 'AuthController@login');


Route::post('/register', 'AuthController@register');

Route::get('/registration', 'HomeController@main');



Route::get('/accept_invitation/register', 'AuthController@login');

Route::get('/go_to_login', 'TeacherController@go_to_login');


Route::post('/reset_password', 'AuthController@reset_password');

Route::post('/update/reset_password', 'AuthController@reset_password');

Route::post('/verify/membership_email', 'AuthController@send_school_verification_code');

Route::post('/verify/membership_code', 'AuthController@verify_school_code');

Route::post('/verify/membership_code_photo', 'AuthController@verify_school_code_photo');

Route::post('/send_verification_code_photo', 'AuthController@send_verification_code_photo');


Route::get('/reset_password/verify_code/{code}', 'AuthController@reset_password_verify');

Route::post('/register_social', 'AuthController@register_social');

Route::post('/subscribe', 'AuthController@subscriber');

Route::post('/follow_school', 'AuthController@follow_school');

Route::get('/profile_wizard/{url}', 'HomeController@main');


Route::post('/save_profile', 'AuthController@save_profile');


Route::post('/save_profile_parent', 'AuthController@save_profile_parent');

Route::post('/profile_image_upload', 'AuthController@profile_image_upload');

Route::post('/create_profile_image_upload', 'AuthController@create_profile_image_upload');

Route::post('/remove/doc', 'AuthController@remove_document');


Route::post('/resend_code', 'AuthController@resend_code');
Route::get('/logout', 'AuthController@logout');

Route::get('/user/logout', 'AuthController@logout');

Route::post('/user/logout', 'AuthController@logout');


/*
Route::get('qr-code', function ()
{
	$png = QrCode::format('png')->size(96)->generate('https://www.expatsschools.com');
	$png = base64_encode($png);
  echo "<img src='data:image/png;base64," . $png . "'>";
exit;
});

*/



Route::post('/user/upload_album', 'HomeController@upload_album');
Route::post('/ads/filter_classifieds', 'HomeController@filter_classifieds');
Route::post('/delete/post', 'CoffeController@delete_user_post');

Route::post('/delete/comment', 'CoffeController@delete_user_comment');


Route::post('/school_search', 'HomeController@school_search');


Route::post('/post/top/search', 'HomeController@top_search');


Route::get('/school/news-events/{url}', 'HomeController@school_social');


Route::post('/get_social_data', 'HomeController@get_social_data');



Route::get('/public_search/job/{url}', 'HomeController@redirect_to_job');

Route::get('/news/{school_url}/{news_url}', 'HomeController@news_detail');
Route::get('/post-an-ad', 'HomeController@place_ad');

Route::get('/post-an-ad/edit/{id}', 'HomeController@edit_place_ad');
Route::get('/albums/{school_url}/{album_url}', 'HomeController@album_details');

//Route::get('/classifieds', 'HomeController@classifieds');
Route::get('/classifieds/detail/{url}', 'HomeController@classified_detail');
Route::get('/ads', 'HomeController@classifieds');




Route::get('/contact', 'HomeController@contact');

Route::get('/profile', 'TeacherController@profile_only');



Route::get('/user/etcapp/profile/{username}', 'TeacherController@user_from_etc');

Route::get('/oauth_callback/twitter', 'TeacherController@twitter');

Route::post('/oauth_callback/twitter', 'TeacherController@twitter');






Route::post('/update_profile', 'TeacherController@update_profile');

Route::post('/cover_image_upload', 'AuthController@cover_image_upload');


Route::post('/delete_profile', 'TeacherController@delete_profile');

Route::post('/ads/upload_ad_photo', 'HomeController@upload_ad_photo');

Route::post('/ads/save_ad', 'HomeController@save_ad');
Route::get('/classifieds/makelive/{url}', 'HomeController@makelive');


Route::post('/ajax/get_prof_collection', 'HomeController@get_prof_collection');


Route::get('/privacy', 'HomeController@privacy');
Route::get('/about', 'HomeController@about');
Route::get('/terms', 'HomeController@terms');
Route::get('/help', 'HomeController@contact');
//Route::get('/messages', 'TeacherController@messages');

Route::get('/messages', 'ChatController@messages2');


Route::get('/inbox', 'HomeController@main');


Route::get('/inbox/{any}', 'HomeController@main');


//Route::get('/expat-teachers-club', 'HomeController@epc');

Route::get('/expat-teachers-club', 'HomeController@main');



Route::post('/ajax/connections_suggestion', 'CoffeController@connections_suggestion');
Route::post('/school_profile/enquiry', 'HomeController@enquiry_school');


Route::post('/select/school_domains', 'HomeController@school_domains');
Route::post('/ajax/load_school_staff', 'HomeController@load_school_staff');





Route::get('/faqs', 'CoffeController@faqs');
Route::get('/clear_c', 'CoffeController@clear_c');

Route::get('/teachers', 'HomeController@teachers');
Route::get('/parents', 'HomeController@main');




Route::get('/unsub', 'HomeController@unsub');
Route::post('/filter_school_pins', 'HomeController@filter_school_pins');
Route::post('/register-your-school', 'HomeController@register_your_school');

Route::get('/slick', 'HomeController@slick');
Route::get('/friends_contract', 'HomeController@friends_contract');
Route::post('/friends_contract', 'HomeController@friends_contract');
Route::get('/search', 'HomeController@search');
Route::post('/search', 'HomeController@search');



Route::post('/close/account', 'CoffeController@close_account');


Route::post('/user/block', 'AuthController@block_user');



Route::get('/user/profile_view', 'TeacherController@profile_view');

Route::post('/user/remove_twitter', 'TeacherController@remove_twitter');



Route::get('/chat', 'ChatController@chat');

Route::post('/send', 'ChatController@send');

Route::post('/custom/broadcasting', 'ChatController@auth');


Route::post('/user/getfriends', 'ChatController@get_friends');

Route::post('/session/create', 'SessionController@create');

Route::post('/send_message/{session}', 'ChatController@send_message');

Route::post('/get_messages/{session}', 'ChatController@get_messages');

Route::post('/session/{session}/read', 'ChatController@read');

Route::post('/session/{session}/clear', 'ChatController@clear');

Route::post('/session/{session}/block', 'BlockController@block');

Route::post('/session/{session}/unblock', 'BlockController@unblock');

Route::post('/chat/open_window', 'ChatController@open_window');


Route::post('/messages/upload_image', 'ChatController@upload_image');

Route::get('/copy', 'BucketController@copy');

Route::get('/list_school', 'SchoolsController@list_school');

Route::get('/school/detail/{url}', 'SchoolsController@detail');


Route::post('/get_schools', 'SchoolsController@get_schools');

Route::post('/schools/load_areas', 'SchoolsController@load_areas');

Route::post('/schools/school_type_ahead', 'SchoolsController@school_type_ahead');

Route::get('/schools/school_type_ahead', 'SchoolsController@school_type_ahead');

Route::post('/schools/school_type_ahead_original', 'SchoolsController@school_type_ahead_original');


Route::post('/schools/follow', 'SchoolsController@follow_school');

Route::post('/schools/post/enquiry_school', 'SchoolsController@enquiry_school');








Route::post('/classifieds/get_cats', 'ClassifiedsController@get_cats');

Route::post('/classifieds/upload_cover_photo', 'ClassifiedsController@upload_cover_photo');

Route::post('/classifieds/album/post', 'ClassifiedsController@upload_album');

Route::post('/classifieds/save_ad', 'ClassifiedsController@save_ad');

Route::get('/classifieds', 'HomeController@main');

Route::post('/list_ads/get', 'ClassifiedsController@listing');

Route::post('/add_to_fav/post', 'ClassifiedsController@add_to_fav');



Route::post('/classifieds/flag_item/post', 'ClassifiedsController@flag_item');

Route::post('/classifieds/reply_ad/post', 'ClassifiedsController@reply_ad');



Route::get('/jobs/list', 'JobsController@index');

Route::post('/list_jobs/post', 'JobsController@list_jobs');

//Route::get('/jobs/detail/{school_url}/{job_url}', 'JobsController@detail');


Route::get('/jobs/{school_url}/{job_url}', 'HomeController@main');


Route::post('/jobs/apply/post', 'JobsController@job_apply_form');


Route::get('/user/login', 'AuthController@userlogin') ->name('user_login');


Route::post('/user/post/login', 'AuthController@userlogin');

Route::post('/user/post/reset', 'AuthController@userresetpassword');

Route::post('/user/post/register', 'AuthController@userregister');


Route::get('/account/registration', 'AuthController@register');

Route::get('/account/email-verification', 'HomeController@main');



Route::post('/post/basic_info', 'SettingsController@index');

Route::post('/post/update_password', 'SettingsController@index');

Route::post('/post/user/followers', 'SettingsController@get_followers');

Route::post('/post/user/discard_follower', 'SettingsController@remove_following');//remove_following  //remove_follower

Route::post('/post/user/user_following_school', 'SettingsController@get_school_followers');


Route::post('/post/user/user_ads', 'SettingsController@user_classifieds');


Route::get('/user/profile/{url}', 'ProfileController@user_profile');

Route::post('/user/profile/get_education', 'ProfileController@get_education');

Route::post('/user/profile/get_experience', 'ProfileController@get_experience');

Route::post('/user/profile/get_followers', 'ProfileController@get_followers');

Route::post('/user/profile/get_post', 'ProfileController@get_post');

Route::post('/user/profile/invite_friend', 'ProfileController@send_user_invite');

Route::post('/user/profile/membership_email', 'ProfileController@send_school_verification_code');

Route::post('/user/profile/save_about', 'ProfileController@save_about');

Route::post('/user/profile/save_experience', 'ProfileController@save_experience');

Route::post('/user/profile/save_education', 'ProfileController@save_education');

Route::post('/user/profile/save_contact_info', 'ProfileController@save_contact_info');

Route::post('/user/album/post', 'ProfileController@upload_album');

Route::post('/profile/user/recommendation', 'ProfileController@Recommendation');


Route::get('/network', 'HomeController@main');

Route::post('/network/specialization', 'NetworkController@load_specialization');

Route::post('/network/get_staffs', 'NetworkController@filter_staff');


Route::get('/news', 'HomeController@main');

Route::get('/news/get_post', 'NewsController@get_post');

Route::post('/news/upload_image', 'NewsController@upload_image');

Route::post('/news/publish', 'NewsController@publish');

Route::post('/news/publish/question', 'NewsController@publish_question');

Route::post('/news/publish/event', 'NewsController@publish_event');

Route::post('/news/get_posts', 'NewsController@get_post');

Route::get('/posts/{username}/{post_url}', 'HomeController@main');

Route::post('/user/action/like', 'NewsController@user_action_save');

Route::post('/user/action/fav', 'NewsController@user_fav');

Route::get('/user/profile_wizard/{type}', 'AuthController@user_profile_wizard');

Route::post('/user/save_profile_wizard', 'AuthController@save_profile_wizard');

Route::post('/profile/user/logo_upload', 'AuthController@logo_upload');

Route::post('/profile/user/logo_upload_wizard', 'AuthController@logo_upload_wizard');



Route::post('/status_checking', 'AuthController@status_checking');

Route::post('/sp/get_post', 'NewsController@post_detail_load');


Route::post('/profile/user/profile_upload', 'AuthController@profile_upload');


Route::post('/verify_primary_email', 'AuthController@verify_primary_email');

Route::post('/save_parent_profile', 'AuthController@save_parent_profile');


Route::post('/load_area', 'HomeController@load_area');

Route::get('/user_by_name', 'ProfileController@search_user_by_name');

Route::post('/schools/post/staff', 'SchoolsController@load_school_staff');


Route::get('/settings', 'HomeController@main');

Route::get('/settings/{any}', 'HomeController@main');

Route::post('/settings/user_update_password', 'SettingsController@user_update_password');

Route::post('/settings/get_recommendations', 'SettingsController@get_recommendations');

Route::post('/post/update_recommendation', 'SettingsController@get_recommendations');

Route::post('/post/get_block', 'SettingsController@get_restricted_user');

Route::post('/post/user/discard_block', 'SettingsController@block_user');


Route::get('/main', 'HomeController@main');

Route::get('/inbox', 'HomeController@main');

Route::get('/networks', 'HomeController@main');

Route::get('/newss', 'HomeController@main');

Route::get('/classifiedss', 'HomeController@main');

Route::get('/jobs', 'HomeController@main');  //JobsController@main

Route::get('/schools', 'HomeController@main');//list_school

Route::get('/school/{url}', 'HomeController@main');

Route::get('/classifieds/{url}', 'HomeController@main');

Route::get('/classifieds/post', 'HomeController@main');

Route::post('/sp/school/detail', 'SchoolsController@school_detail');

Route::get('/sp/school/detail', 'SchoolsController@school_detail');

Route::post('/sp/job/detail', 'JobsController@job_detail');

Route::post('/sp/classifieds/detail', 'ClassifiedsController@ad_detail');

Route::post('/post/contact_info', 'ClassifiedsController@contact_info');

Route::post('/user/school/profile_school', 'ProfileController@profile_school');

Route::get('/profile/{username}', 'HomeController@main');

Route::get('/register-your-school', 'HomeController@main');


Route::get('/friends/{url}', 'HomeController@main');


Route::get('/', 'HomeController@main');

Route::get('/parentsss', 'HomeController@main');


Route::get('/es/about', 'HomeController@main');

Route::get('/es/contact', 'HomeController@main');

Route::get('/es/privacy', 'HomeController@main');

Route::get('/es/terms', 'HomeController@main');


Route::post('/sp/friends/detail', 'ClassifiedsController@get_friends');
