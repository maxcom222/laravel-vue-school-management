<div class="top-menu">
<div class="container">
    <div class="row no-gutters">
      <div class="col-8 col-md-3 order-md-1 col-xl-2 order-xl-1 align-self-center"> <a href="{{ url('/') }}" class="main-logo"><img src="{{ asset('css/img/logoa.png') }}" alt="Expats Schools Logo"></a> </div>
      <div class="col-4 col-md-3 order-md-3 col-xl-1 order-xl-4 align-self-center">
        
        
        <?php
			if (Session::has('user'))
			{
					$user = Session::get('user');
					$profile_photo = url( '/css/img/user-img.png' );
					
					if( $user -> profile_photo != '' )
					{
						
						if( $user -> profile_photo_custom == 1 )
						{
							$profile_photo = url('/user_profiles/'. $user -> profile_photo ) ;
						}
						else
						{
							$profile_photo =  $user -> profile_photo;
						}
					}
					
		?>
         <ul class="user">
          <li><input id="user_login" value="1" type="hidden" />
          <input id="user_first_name" value="<?php echo $user -> first_name;?>" type="hidden" />
          <input id="user_last_name" value="<?php echo $user -> last_name;?>" type="hidden" />
          <input value="<?php echo  $user -> id;?>"  type="hidden" id="guid" />
          <a href="javascript:void(0);"><img class="profile-photo" src="<?php echo $profile_photo;?>" alt="<?php echo $user -> first_name;?>"></a>
            <ul class="user-menu">
              <li><a href="<?php echo url('/profile/'. $user -> username  );?>"><svg class="icon icon-user-circle">
                <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-user-circle"></use>
                </svg>Profile</a> </li>
              <li class="d-none"><a href=""><svg class="icon icon-shield">
                <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-shield"></use>
                </svg>Privacy</a> </li>
              <li><a href="{{ url('/user/settings-basic') }}"><svg class="icon icon-cog">
                <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-cog"></use>
                </svg>Settings</a> </li>
              <li><a href="{{ url('/user/logout') }}" class="js_log_out"><svg class="icon icon-power-off">
                <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-power-off"></use>
                </svg>Logout</a></li>
            </ul>
          </li>
         </ul>
         
         <a href="" class="notify"><span class="indctr d-none"></span><svg class="icon icon-bell-o"><use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-bell-o"></use></svg></a>

         <?php } else { ?>
       
         
         
         <ul class="user">
         <li><a href="javascript:void(0);"><img src="{{ asset('css/img/user-img.png') }}" alt=""></a>
            <ul class="user-menu">
            <li><a  onclick="return false" style="cursor:default;"  href="" >Login as a</a> </li>
              <li><a class="js_l_app"   data-id="teacher" href="{{ url('/login') }}" ><svg class="icon icon-user-circle"><use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-user-circle"></use></svg>Teacher</a> </li>
			  <li><a class="js_l_app"  data-id="parent"     href="{{ url('/login') }}" ><svg class="icon icon-user-circle"><use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-user-circle"></use></svg>Parent</a> </li>
              <li><a href="https://www.expatsschools.com/secure_admin/Admin/login" target="_blank" ><svg class="icon icon-user-circle"><use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-user-circle"></use></svg>School</a> </li>
              <li><a href="{{ url('/contact') }}"><svg class="icon icon-shield"><use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-shield"></use></svg>Contact</a> </li>
            </ul>
          </li>
         </ul>
         
         
         
         
         
         
         
         <?php } ?> 
     </div>
      
      
      
      
      <div class="col-12 col-md-6 order-md-2 col-xl-2 order-xl-2 align-self-center">
        <form class="search">
          <input type="search" class="form-control g_search" placeholder="Search...">
          <button class="btn g_search_btn" type="button"><svg class="icon icon-search">
          <use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-search"></use>
          </svg></button>
        </form>
        <div class="ser-autocomplete">
        </div>
      </div>
      
      
       <?php
			if (Session::has('user'))
			{
		?>
      
      
      <div class="col-12 col-md-12 order-md-4 col-xl-7 order-xl-3 align-self-center">
        <ul id="menu">
          <li <?php if( $page_on == 'home' ) {?>  class="current"   <?php } ?>   ><a href="{{ url('home') }}">
		  <svg class="icon icon-home"><use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-home"></use></svg>My Feed</a></li>
          <li  <?php if( $page_on == 'inbox' ) {?>  class="current inboxs"   <?php } else{  ?> class="inboxs" <?php } ?>   ><span class="indctr d-none"></span><a href="{{ url('messages') }}"><svg class="icon icon-comment">
		  <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-comment"></use></svg>Inbox</a> </li>
          <li  <?php if( $page_on == 'staff-room' ) {?>  class="current"   <?php } ?>   ><a href="{{ url('staff-room') }}"><svg class="icon icon-handshake-o">
            <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-handshake-o"></use></svg>Network</a> </li>
          
          <li  <?php if( $page_on == 'coffee-club' ) {?>  class="current"   <?php } ?>   ><a href="{{ url('coffee-club') }}"><svg class="icon icon-coffee">
            <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-coffee"></use></svg>News and Views</a> </li>
          
          
          <li  <?php if( $page_on == 'classified' ) {?>  class="current"   <?php } ?>   ><a href="{{ url('ads') }}"><svg class="icon icon-bullhorn">
            <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-bullhorn"></use></svg>Classified</a> </li>
          <li  <?php if( $page_on == 'jobs' ) {?>  class="current"   <?php } ?>   ><a href="{{ url('jobs') }}"><svg class="icon icon-suitcase">
            <use xlink:href="{{ asset('js/plugins/menu/symbol-defs.svg') }}#icon-suitcase"></use></svg>Jobs</a> </li>
          <li  <?php if( $page_on == 'school' ) {?>  class="current"   <?php } ?>   ><a href="{{ url('schools') }}"><svg class="icon icon-graduation-cap">
            <use xlink:href="{{ asset('css/plugins/menu/symbol-defs.svg') }}#icon-graduation-cap"></use></svg>Schools</a> </li>
        
        
        
        <li class="js_open_apps" style=" display:none;"    ><a    target="_blank"><svg class="icon icon-apps"><use xlink:href="{{ asset('css/plugins/menu/symbol-defs.svg') }}#icon-apps"></use></svg>Apps</a>
        <div class="user-menu user-menu-apps" style="display: none;">
<p><a href="http://expatsschools.recognize365.com"     target="_blank"><svg class="icon icon-apps"><use xlink:href="{{ asset('css/plugins/menu/symbol-defs.svg') }}#icon-apps"></use></svg>ES 365</a></p>
<p><a href="https://expatsschools.zenepal.com/" target="_blank"><svg class="icon icon-supervisor_account"><use xlink:href="{{ asset('css/plugins/menu/symbol-defs.svg') }}#icon-supervisor_account"></use></svg>ES HR</a></p>
</div>
        
        </li>
        
        <li style="display:none;"  ><a href="https://expatsschools.zenepal.com/" target="_blank"><svg class="icon icon-supervisor_account"><use xlink:href="{{ asset('css/plugins/menu/symbol-defs.svg') }}#icon-supervisor_account"></use></svg>ES HR</a> </li>
        
        
        
        
        
        </ul>
      </div>
      
      
      
        <?php } else { ?>
        
        
        <div class="col-12 col-md-12 order-md-4 col-xl-7 order-xl-3 align-self-center">
        <ul id="menu">
         <li><a class="js_l_app"   data-id="teacher"  href="{{ url('login') }}"><svg class="icon icon-sentiment_neutral"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-sentiment_neutral"></use></svg>Teachers + Support Staff</a></li>
         <li><a class="js_l_app"   data-id="parent"  href="{{ url('login') }}"><svg class="icon icon-verified_user"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-verified_user"></use></svg>Parents</a></li>
         <li><a href="https://www.expatsschools.com/register-your-school">
		 <svg class="icon icon-graduation-cap"><use xlink:href="{{ asset('css/plugins/menu/symbol-defs.svg') }}#icon-graduation-cap"></use></svg> Schools</a></li>
         <li><a href="{{ url('contact') }}"><svg class="icon icon-chat_bubble"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-chat_bubble"></use></svg>Contact</a></li>
         <li><a href="{{ url('about') }}"><svg class="icon icon-info"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-info"></use></svg>About</a></li>
         <li  style="display:none;"  ><a href="http://expatsschools.recognize365.com"     target="_blank"><svg class="icon icon-apps"><use xlink:href="{{ asset('css/plugins/menu/symbol-defs.svg') }}#icon-apps"></use></svg>ES 365</a> </li>
        
        <li    style="display:none;"   ><a href="https://expatsschools.zenepal.com/" target="_blank"><svg class="icon icon-supervisor_account"><use xlink:href="{{ asset('css/plugins/menu/symbol-defs.svg') }}#icon-supervisor_account"></use></svg>ES HR</a> </li>
       
        
        
        </ul>
      </div>
        
        
        <?php } ?>
      
      
    </div>
  </div>
</div>


<div class="mobile-header" role="banner">
  <div class="middle-icons"> <a href="https://www.expatsschools.com/"><img alt="expatsschools.com logo" src="https://www.expatsschools.com/css/img/logoa.png"></a> </div>
  <div class="left-icons">
    <button type="button" data-id="js_global_main_menu"><svg class="icon icon-menu"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-menu"></use></svg></button>
    <button type="button" data-id="js_main_search"><i class="icon-search"></i></button>
  </div>
  <div class="right-icons">
   <button type="button" data-id="js_main_settings"><i class="icon-gear"></i></button>
    <button type="button" data-id="js_main_account"><svg class="icon icon-person"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-person"></use></svg></button>
   
  </div>
</div>


<aside id="js-sidebar" class="trv-sidebar d-none" >
  <div class="trv-sidebar__content trv-sidebar__content--trailing">
    <div id="js-trv-sidebar-container">
      <div class="sidebar__close__header close_menu_sidebar">
        <div class="sidebar__banner"><span class="">Close</span></div>
      </div>
      <div class="fav-list js-right-bar-content">
        <div class="sidebar-section">
          <section class="cnt-box">
            <div class="cnt-box__content js-window">
              <ul class="popover__select-ul">
                <li><a class="js_global_language_mobile" href=""><span>Language</span> <i class="icons icon-play_arrow"></i></a> </li>
                <li><a class="js_global_currency_mobile" href=""><span>Currency</span> <span class="js_main_cur_val">AED</span> <i class="icons icon-play_arrow"></i> </a></li>
                <li><a href="https://www.godesto.com/contact"><span>Help</span> <i class="icons icon-play_arrow"></i></a> </li>
                <li><a class="js_global_mobile_mobile" href=""><span>Mobile</span> <i class="icons icon-play_arrow"></i></a> </li>
                <li><a target="_blank" href="http://business.godesto.com"><span>For Businesses</span> <i class="icons icon-play_arrow"></i></a> </li>
              </ul>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</aside>



