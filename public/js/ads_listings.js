

var c_page_number = 0;
var data_loaded_c = 1;

var ages_arr = [];
ages_arr[1] = 'Brand New';
ages_arr[2] = '0-1 month';
ages_arr[3] = '1-6 months';
ages_arr[4] = '6-12 months';
ages_arr[5] = '1-2 years';
ages_arr[6] = '2-5 years';
ages_arr[7] = '5-10 years';
ages_arr[8] = '10+ years';



var condition_arr = [];
condition_arr[1] = '';
condition_arr[5] = 'Perfect inside and out</option>';
condition_arr[4] = 'Almost no noticeable problems or flaws</option>';
condition_arr[3] = 'A bit of wear and tear, but in good working condition</option>';
condition_arr[2] = 'Normal wear and tear for the age of the item, a few problems here and there</option>';
condition_arr[1] = 'Above average wear and tear.  The item may need a bit of repair to work properly</option>';



var usage_arr = [];
usage_arr[1] = 'Still in original packaging';
usage_arr[2] = 'Out of original packaging, but only used once';
usage_arr[3] = 'Used only a few times';
usage_arr[4] = 'Used an average amount, as frequently as would be expected';
usage_arr[5] = 'Used an above average amount since purchased';



$(document).on('click', '.js_post_ad', function(w)
{
    w.preventDefault();
    if( $('#user_login').val() == 1 )
    {
        document.location =  path + '/post-an-ad' ;
    }
    else
    {
        lscache.set( 'ad', '1' );
        document.location =  path + '/login' ;
    }
});

$(document).on('click', '.link', function(event)
{
    $('.submenu').hide();
    obj = $(this).find('i');
    $('.link i').not( $( obj ) ).attr('class', 'glyphicon glyphicon-chevron-down' );
    $(this).find('i').toggleClass('glyphicon-chevron-up glyphicon-chevron-down' );

    if(  $( obj ).hasClass('glyphicon-chevron-up' ) )
    {
        $(this).next('.submenu').show();
    }
    else
    {
        $(this).next('.submenu').hide();
    }

    event.stopPropagation();
});


$(document).on('change','#js_mileage', function()
{
    $('.js_m_t').html($(this).val() + ' KM' );
    c_page_number = 0;

    filter_classifieds( c_page_number, 0 );
});

$(document).ready(function()
{
    html = '';
    html+='<label for="">Keywords</label>';
    html+='<form class="search">';
    html+='<input type="search" class="form-control js_search_text" placeholder="Item name...">';
    html+='<button class="btn js_search_btn" type="button"><svg class="icon icon-search"><use xlink:href="'+  path + '/public/css/ico/symbol-defs.svg#icon-search"></use></svg></button>'
    html+='</form>';

    html+='<label for="">Category</label>';
    html+='<select id="js_category"></select>';

    html+='<label   class="sub_cat d-none" for="">Sub Category</label>';
    html+='<select  class="sub_cat d-none"  id="js_sub_category"></select>';

    html+='<label   class="d-none level_3" for="">Level 3 Category</label>';
    html+='<select  class="d-none level_3"  id="js_sub_sub_category"></select>';


    html+='<label   class="d-none level_4" for="">Model</label>';
    html+='<select  class="d-none level_4"  id="js_cars_modal"></select>';




    html+='<div class="car-search d-none"><label for="">Mileage <span class="js_m_t" style="margin-left:5px;">0 KM</span></label>';
    html+='<input style="width:100%;" value="0" type="range" min="0" max="1000000" class="" id="js_mileage">';
    html+='</div>';

    options_year = '<option  value="">Select</option>';
    for( $i = 1970; $i <= (new Date()).getFullYear(); $i++ )
    {
        sel = '';   //if( $i == 2015 ){ sel = 'selected'; }
        options_year +='<option  '+ sel  +' value="' +  $i  +'">'+  $i  +'</option>';
    }
    html+='<div class="car-search d-none"><label for="">Year</label>';
    html+='<select  id="js_year">'+  options_year  +'</select>';
    html+='</div>';




    html+='<div class="link">Condition<i class="glyphicon glyphicon-chevron-down"></i></div>';
    html+='<div class="submenu">';
    html+='<select id="condition" name="condition" class="placeholder" tabindex="-1">';
    html+='<option value="" selected="selected">Condition</option>';
    html+='<option value="5">Perfect inside and out</option>';
    html+='<option value="4">Almost no noticeable problems or flaws</option>';
    html+='<option value="3">A bit of wear and tear, but in good working condition</option>';
    html+='<option value="2">Normal wear and tear for the age of the item, a few problems here and there</option>';
    html+='<option value="1">Above average wear and tear.  The item may need a bit of repair to work properly</option>';
    html+='</select>';
    html+='</div>';
    html+='<div class="link n-car">Age<i class="glyphicon glyphicon-chevron-down"></i></div>';
    html+='<div class="submenu">';
    html+='<select id="id_age" name="age" class="placeholder" tabindex="-1">';
    html+='<option value="" selected="selected" >Age</option>';
    html+='<option value="1" >Brand New</option>';
    html+='<option value="2">0-1 month</option>';
    html+='<option value="3">1-6 months</option>';
    html+='<option value="4">6-12 months</option>';
    html+='<option value="5">1-2 years</option>';
    html+='<option value="6">2-5 years</option>';
    html+='<option value="7">5-10 years</option>';
    html+='<option value="8">10+ years</option>';
    html+='</select>';
    html+='</div>';

    html+='<div class="link n-car">Usage<i class="glyphicon glyphicon-chevron-down"></i></div>';
    html+='<div class="submenu">';
    html+='<select id="usage" name="usage" class="placeholder" tabindex="-1">';
    html+='<option value="" selected="selected">Usage</option>';
    html+='<option value="1">Still in original packaging</option>';
    html+='<option value="2">Out of original packaging, but only used once</option>';
    html+='<option value="3">Used only a few times</option>';
    html+='<option value="4">Used an average amount, as frequently as would be expected</option>';
    html+='<option value="5">Used an above average amount since purchased</option>';
    html+='</select>';
    html+='</div>';


    html+='<div class="link">Warranty<i class="glyphicon glyphicon-chevron-down"></i></div>';
    html+='<div class="submenu">';
    html+='<select id="warranty" name="warranty" class="" tabindex="-1">';
    html+='<option value="" selected="selected" disabled="disabled">Warranty</option>';
    html+='<option value="Yes">Yes</option>';
    html+='<option value="No">No</option>';
    html+='<option value="Does not apply">Does not apply</option>';
    html+='</select>';
    html+='</div>';

    html +='	<a href="" data-type="favourites" class="new-checkbox favourites-check">';
    html +='	<span>';
    html +='	<svg class="icon icon-square-o"><use xlink:href="'+ path +'/public/js/plugins/menu/symbol-defs.svg#icon-square-o"></use></svg>';
    html +='	<svg class="icon icon-check-square-o"><use xlink:href="'+ path +'/public/js/plugins/menu/symbol-defs.svg#icon-check-square-o"></use></svg>';
    html +='	</span>';
    html +='	<em>Favourites</em>';
    html +='	</a>';



    html+='<a href="" class="btn btn-primary reset-filters  js_reset_filter">Reset Filters</a>';

    $('.cafe-sort').html( html );
    load_cat( 'js_category');

});

function load_cat( id_select_box  )
{
    $.ajax(
        {
            type: 'POST',
            url: path + '/ads/get_cats' ,
            data: '_token=' + token, dataType:"json",
            success: function( response )
            {
                if( response.result == 1 )
                {
                    d = response.data;
                    html  = '<option value="">Select</option>';
                    for( i = 0; i < d.length; i ++ )
                    {
                        text = d[i].text;
                        id	 = d[i].id;
                        html +='<option value="'+ id +'">'+  text  +'</option>';
                    }
                    $('#' + id_select_box ).html ( html );

                    filter_classifieds( 0, 0 );
                }
                $('.loader').remove();
            }
        });
}
$(document).on('change', '#js_category', function(event)
{
    id = $('#js_category').val();
    $('.n-car').removeClass('d-none');
    $('.car-search').addClass('d-none');
    if( id == '1242')
    {
        $('.n-car').addClass('d-none');
        $('.car-search').removeClass('d-none');
    }
    $.ajax(
        {
            type: 'POST',
            url: path + '/ads/get_cats' ,
            data: '_token=' + token + '&id='+  id + '&child=1', dataType:"json",
            success: function( response )
            {
                if( response.result == 1 )
                {
                    d = response.data;
                    html  = '<option value="">Select</option>';
                    for( i = 0; i < d.length; i ++ )
                    {
                        text = d[i].text;
                        id	 = d[i].id;
                        html +='<option value="'+ id +'">'+  text  +'</option>';
                    }
                    $('#js_sub_category').html ( html );
                    $('.sub_cat').removeClass('d-none');
                }
            }
        });
});
//
$(document).on('change', '#js_sub_category', function(event)
{
    id = $('#js_sub_category').val();
    $('.level_4').addClass('d-none');
    $.ajax(
        {
            type: 'POST',
            url: path + '/ads/get_cats' ,
            data: '_token=' + token + '&id='+  id + '&child=1', dataType:"json",
            success: function( response )
            {
                if( response.result == 1 )
                {
                    d = response.data;
                    html  = '<option value="">Select</option>';
                    for( i = 0; i < d.length; i ++ )
                    {
                        text = d[i].text;
                        id	 = d[i].id;
                        html +='<option value="'+ id +'">'+  text  +'</option>';
                    }
                    $('#js_sub_sub_category').html ( html );
                    $('.level_3').removeClass('d-none');
                }
            }
        });
});

$(document).on('change', '#js_sub_sub_category', function(event)
{
    id = $('#js_sub_sub_category').val();
    $.ajax(
        {
            type: 'POST',
            url: path + '/ads/get_cats' ,
            data: '_token=' + token + '&id='+  id + '&child=1', dataType:"json",
            success: function( response )
            {
                if( response.result == 1 )
                {
                    d = response.data;
                    if(  d.length > 0 )
                    {
                        html  = '<option value="">Select</option>';
                        for( i = 0; i < d.length; i ++ )
                        {
                            text = d[i].text;
                            id	 = d[i].id;
                            html +='<option value="'+ id +'">'+  text  +'</option>';
                        }
                        $('#js_cars_modal').html ( html );
                        $('.level_4').removeClass('d-none');
                    }
                }
            }
        });
});

$(document).on('click','.js_slide_c_filters',  function()
{

    menu_content = $('.desktop-filters').html();
    menu_content = '';
    menu_content +='<div class="sidebar__close__header close_menu_sidebar" data-from="ads_filter">';
    menu_content +=  '<div class="sidebar__banner"><span class="">Close</span></div>';
    menu_content +='</div>';
    menu_content +='<div class="fav-list js-right-bar-content">';
    menu_content +=  '<div class="sidebar-section">';
    menu_content +=  '</div>';
    //menu_content +=  '<div class="frame mobile-search">'+ $('.search_by_text_frm').html()    +'</div>';
    menu_content += '<div class="frame  filters mobile-c-filters accordion cafe-sort">'+ $('.desktop-filters').html()  +'</div>';
    menu_content +=  '</div>';



    $('.desktop-filters').html('');




    $('#js-sidebar .trv-sidebar__content').removeClass('trv-sidebar__content--trailing').addClass('trv-sidebar__content--leading').css({'overflow-y':'scroll', 'height':'700px'});
    $('#js-trv-sidebar-container').html(menu_content);
    $('#js-sidebar .trv-sidebar__content').css('overflow-y', 'scroll');
    $('#js-sidebar').removeClass('d-none');


    //$('.js_department').select2({placeholder: 'Select Department' });

    $('.mobile-c-filters h2').hide();

    setTimeout(function() {
        showAsideBar('school_filter');
    }, 200);


});



$(document).on('change', '#js_category,#condition,#usage,#id_age,#warranty,#js_sub_category,#js_sub_sub_category,#js_year,#js_cars_modal', function(e)
{
    c_page_number = 0;
    $(this).find('option:selected').attr('selected', 'selected');
    filter_classifieds( c_page_number, 0 );
});

$(document).on('click', '.js_reset_filter', function(event)
{
    event.preventDefault();
    $('.js_search_text').val('');
    $('#js_category,#condition,#usage,#id_age,#warranty,#js_sub_category option:first').val('').change();//s('selected','selected');
    c_page_number = 0;
    filter_classifieds( c_page_number, 0 );
});





$(document).on('click', '.js_search_btn', function(e)
{
    c_page_number = 0;
    if(  $.trim( $('.js_search_text').val() ) == '' )
    {
        return;
    }
    filter_classifieds( c_page_number, 0 );
});



$(document).on('click', '.favourites-check', function(event)
{
    event.preventDefault();
    if( $(this).hasClass('active') )
    {
        $(this).removeClass('active')
    }
    else
    {
        $(this).addClass('active')
    }
    c_page_number = 0;
    filter_classifieds( c_page_number, 0 );
});

function filter_classifieds( page, on_scroll, uncheck )
{
    search_text		= '';
    condition 		= '';
    usage	 		= '';
    warranty		= '';
    age				= '';
    param_url 		= '';
    category		= '';
    sub_category 	= '';
    level_3			= '';
    if( uncheck != 1 )
    {
        if( getParameterByNameGlobal('search_text') != null )
        {
            search_text 	= getParameterByNameGlobal('search_text');

        }
        if( getParameterByNameGlobal('salary_band') != null )
        {
            salary_band 	= getParameterByNameGlobal('salary_band');
        }
        if( getParameterByNameGlobal('experience') != null )
        {
            experience 	= getParameterByNameGlobal('experience');
        }
        if( getParameterByNameGlobal('gender') != null )
        {
            gender 	= getParameterByNameGlobal('gender');
        }
        if( getParameterByNameGlobal('contract_type') != null )
        {
            contract_type 		 = getParameterByNameGlobal('contract_type');
            contract_type_arr	 = contract_type.split(',');
            for( i = 0; i < contract_type_arr.length; i ++ )
            {
                $('[data-type="contract_type"][data-content="'+ contract_type_arr[i] +'"]').addClass('active');
            }
        }
        if( getParameterByNameGlobal('benefits') != null )
        {
            benefits 		 = getParameterByNameGlobal('benefits');
            benefits_arr	 = benefits.split(',');
            for( i = 0; i < benefits_arr.length; i ++ )
            {
                $('[data-type="benefits"][data-content="'+ benefits_arr[i] +'"]').addClass('active');
            }
        }
        if( getParameterByNameGlobal('position') != null )
        {
            position 			= getParameterByNameGlobal('position');
            position_arr	 	= position.split(',');
            for( i = 0; i < position_arr.length; i ++ )
            {
                $('[data-type="position"][data-content="'+ position_arr[i] +'"]').addClass('active');
            }
        }

    }

    search_text		= '';
    condition 		= '';
    usage	 		= '';
    warranty		= '';
    age				= '';
    param_url 		= '';
    category		= '';
    sub_category 	= '';
    favourites = '';
    year = '';
    mileage = '';

    level_3 = '';

    condition		 	= $('#condition').val();
    usage 				= $('#usage').val();
    warranty 			= $('#warranty').val();
    year 				= $('#js_year').val();
    mileage				= $('#js_mileage').val();

    age 				= $('#id_age').val();
    category 			= $('#js_category').val();
    sub_category 		= $('#js_sub_category').val();

    level_3 			= $('#js_sub_sub_category').val();
    level_4 			= $('#js_cars_modal').val();
    search_text  = $('.js_search_text').val();

    param = { page:c_page_number, load_data:1, _token:token };
    param.favourites =  '';
    if( $('.favourites-check').hasClass('active') )
    {
        param.favourites = 1;
    }
    if( condition != ''  && condition != null   ){  param.condition = condition; param_url += '&condition=' + condition ; }
    if( usage 	  != ''   && usage != null   ){  param.usage = usage;    param_url += '&usage=' + usage ; }
    if( warranty != ''  && warranty != null  ){   param.warranty = warranty;    param_url += '&warranty=' + warranty ; }
    if( age   != '' && age != null  ){   param.age = age;    param_url += '&age=' + age ; }
    if( category    != '' && category != null  ){  param.category = category;     param_url += '&category=' + category ; }
    if( search_text   != '' && typeof search_text != 'undefined'   ){  param.search_text = search_text;     param_url += '&search_text=' + search_text ; }
    if( sub_category != '' && sub_category != null  ){  param.sub_category = sub_category;     param_url += '&sub_category=' + sub_category ; }
    if(  level_3 != '' && level_3 != null   ) { param.level_3 = level_3;   param_url += '&level_3=' + level_3 ;}

    if(  level_4 != '' && level_4 != null  && typeof level_4 != 'undefined'  ) { param.level_4 = level_4;   param_url += '&level_4=' + level_4 ;}

    if(  mileage != '' && mileage >0    ) { param.mileage = mileage;   param_url += '&mileage=' + mileage ;}
    if(  year != '' && year != null   ) { param.year = year;   param_url += '&year=' + year ;}

    param_url = 'page=' + c_page_number + param_url;
    pageurl = path + '/ads?' + param_url;
    history.pushState(	{},"",pageurl) ;


    ads_filter_action( param, on_scroll );
}






$(window).on('scroll', function()
{
    if( $('.js_ads_listing').length )
    {
        if(	$(window).scrollTop() >= $('.js_ads_listing').offset().top + $('.js_ads_listing').outerHeight() - window.innerHeight	)
        {

            if( data_loaded_c == 1  ) /*&& filter_clicked == 1*/
            {
                data_loaded_c = 0;
                filter_classifieds(  c_page_number, 1 );  /* on_scroll = 1 */
            }

        }
    }
});


$(document).on('click', '.js_job_filter a', function(e)
{
    e.preventDefault();

    uncheck = 0;

    if( $(this).hasClass('active') )
    {
        $(this).removeClass('active');
        uncheck = 1;
    }
    else
    {
        $(this).addClass('active');
    }

    c_page_number = 0;
    $('main').prepend('<div class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>');


    filter_classifieds('','', uncheck );
});


function ads_filter_action( param, on_scroll )
{
    $('body').prepend('<div class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>');

    $.ajax({
        type: 'POST',
        url: path + '/ads/filter_classifieds' ,
        data: param, dataType:"json",
        success: function( response )
        {
            $('.loader').remove();
            if( response.result == 1 )
            {
                attach_ads_response( response.data, on_scroll );
            }
            else
            {

                $('.loader').remove();
                if( on_scroll == 1  )
                {
                    data_loaded_c = 0;
                    return;
                }
                else
                {
                    data_loaded_c = 1;
                    $('.js_ads_listing').html('<p>No ads found with this criteria</p>');
                }


            }
        }
    });
}


function attach_ads_response( data , on_scroll)
{

    TotalPinsAdsForDetailJobs = {};
    for( i = 0;  i < data.length; i ++ )
    {
        records = data[i];

        //public/css/img/school-logo-01.jpg		nologo.png
        svg_path =  path + '/public/js/plugins/menu/symbol-defs.svg';
        svg_path2 = path + '/public/css/ico/symbol-defs.svg';

        logo = '';

        title  				 = records.title;
        id	  				 = records.id;
        desc 				 = records.description;

        ages 				 = records.ages;
        condition 	 		 = records.conditions;
        usage				 = records.usage;
        warranty			 = records.warranty;

        price				 = records.price;
        phone_number		 = records.phone_number;

        category			 = records.text;
        user_name 			 =  records.first_name +' '+ records.last_name;

        dated				 = records.dated;
        profile_url          = path +'/profile/' + records.username;
        html = '';

        cover_image			 = path + '/public/classifieds/'+  records.cover_image;

        lng 	= records.longitude;
        lat 	= records.latitude;
        price 	= records.price;

        profile_photo = path +  '/public/css/img/user-img.png' ;
        if( records.profile_photo != '' )
        {
            if( records.profile_photo_custom == 1 )
            {
                profile_photo = path + '/public/user_profiles/' +  records.profile_photo ;
            }
            else
            {
                profile_photo =  records.profile_photo;
            }
        }

        url = path + '/classifieds/detail/' + records.url;
        address = records.address;
        mileage = records.mileage;
        year = records.year;
        if( mileage == null ){ mileage = 'Not Mentioned'; }
        if( year == null ){ year = 'Not Mentioned'; }


        //if( usage_arr[usage].length > 30 ){ usage =  usage_arr[usage].substr(0, 30) + '...';  } else {usage = usage_arr[usage];  }
        if( desc.length > 100 ) {  desc = desc.substr(0, 100)  + '...' ; }

        html +='<div class="feed ad js_item" data-lat="'+ lat +'"><input class="js_lat" value="'+ lat  +'" type="hidden"><input class="js_lng" value="'+ lng  +'" type="hidden">';
        html +='<a href="'+  profile_url  +'" class="dp"><img src="'+ profile_photo  +'" alt="'+ user_name +'"></a>';
        html +='<div>';
        html +='<a href="'+  profile_url  +'" class="publisher">'+ user_name +' </a>';
        html +='<span class="text-muted"> posted</span>';
        html +='<h2><a href="'+ url +'" class="js_name">'+ title +'</a></h2>';
        html +='<span class="text-muted">in</span> <span class="posted-in rating">'+  category +'</span>';
        html +='<small class="text-muted">'+  dated +'</small>';
        html +='</div>';
        html +='<p>'+   desc  +'</p>';
        html +='<div class="condition">';

        if( category  == 'Cars' )
        {
            html +='<span><strong>Mileage</strong> '+ mileage  +'</span>';
            html +='<span><strong>Year</strong> '+  year +'</span>';
        }
        else
        {
            html +='<span><strong>Age</strong> '+ ages_arr[ages]  +'</span>';
            html +='<span><strong>Usage</strong> '+  usage_arr[usage] +'</span>';
        }


        html +='<span><strong>Condition</strong> '+  condition_arr[condition].substr(0, 40) +'</span>';
        html +='<span><strong>Warranty</strong> '+  warranty +'</span>';
        html +='<span class="js_address"><strong>Located</strong>'+ address  +'</span>';
        html +='</div><div class="action">';
        html +='<em>'+ price  +'</em>';

        if( lscache.get( id + 'ads')  == 1 )
        {
            html +='<a href="" class="js_ad_fav"   data-type="ads"    data-opt="remove"  data-id="' +  id +'"><svg class="icon icon-favorite  active-favorite"><use xlink:href="'+ svg_path2 +'#icon-favorite"></use></svg></a>';
        }
        else
        {
            html +='<a href="" class="js_ad_fav"  data-type="ads"    data-opt="add"  data-id="' +  id +'"><svg class="icon icon-favorite"><use xlink:href="'+ svg_path2 +'#icon-favorite"></use></svg></a>';
        }


        html +='<a href="" class="js_ad_flag"  data-id="' +  id +'"><svg class="icon icon-flag"><use xlink:href="'+ svg_path2 +'#icon-flag"></use></svg></a>';
        html +='</div>';
        html +='<div class="sharethis-inline-share-buttons mgtop10"   data-url="'+ url+'" data-title="'+ title +'"></div>';

        html +='<a href="'+  url  +'" class="featured js_profile_view"><img src="'+  cover_image  +'" alt="" class="img-fluid mgtop10"></a>';
        html +='</div>';

        pp( on_scroll + 'croll' );
        if( i == 0 && on_scroll != 1 )
        {
            lng = records.longitude;
            lat = records.latitude;

            $('.js_ads_listing').html( html );

            map = 'https://maps.googleapis.com/maps/api/staticmap?center=Dubai&zoom=13&size=637x440&maptype=roadmap&markers=color:red%7Clabel:S%7C'+ lat +','+  lng  +'&key=AIzaSyB_O3eana1MbjibnAWKwIg7cPCHXQ-8fN4';

            $('.map img').attr('src', map );
        }
        else
        {
            $('.js_ads_listing').append( html );
        }

    }

    if( on_scroll != 1 )
    {
        if( $(window).width() > 1100 )
        {
            $("html, body").animate({ scrollTop: "100px" });
        } else {$("html, body").animate({ scrollTop: "10px" });}
    }
    data_loaded_c = 1;
    c_page_number = c_page_number + 1;
    $('.loader').remove();
    __sharethis__.initialize();
}




$(document).on('click', '.js_show_map_ads', function(e)
{
    e.preventDefault();
    ads_map();
});

$(document).on('click', '.js_show_listing_ads', function(e)
{
    e.preventDefault();
    $('.map_container').remove();
    $('.close-map-ads').show(); //$('.js_ads_listing').attr('class', 'col-12 col-md-6 js_ads_listing col-right');
    c_page_number = 0;

    filter_classifieds( c_page_number, 0 );

});

function ads_map( )
{
    data_loaded_c = 0;
    TotalPinsAds = [];
    TotalPinsAdsForDetailJobs = [];
    $('main').prepend('<div class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>');
    $('.js_ads_listing .js_item').each(function(index, element)
    {
        latvar	= $(this).find('.js_lat').val();
        langvar	= $(this).find('.js_lng').val();
        lat_lang = latvar+','+langvar;
        if( latvar != 0)
        {
            obj = {}; superobject = {}
            obj.latLng 	 	    =  new google.maps.LatLng(latvar,langvar);
            obj.lat    	 		= latvar;
            obj.lang  	 		= langvar;
            TotalPinsAds[index] 	=  obj;

            frame			 = $(this);
            image 			= frame.find('.js_profile_view img').attr('src');
            id    			= frame.attr('data-id');
            address			= frame.find('.js_address').html();
            name			= frame.find('.js_name').html();
            rating			= frame.find('.rating').html();
            url    			= frame.find('.js_profile_view').attr('href');


            if( address.length  > 50 ) { address = address.substr(0, 50) + '...' ; }
            superobject.latLng 	 	    =  new google.maps.LatLng(latvar,langvar);
            superobject.lat    	 		= latvar;
            superobject.lang  	 		= langvar;
            superobject.image  	 		= image;
            superobject.id  	 		= id;
            superobject.address  	 	= address;
            superobject.name  	 		= name;

            superobject.rating  	 	= rating;
            superobject.url  	 		= url;

            index_string = superobject.lat;
            TotalPinsAdsForDetailJobs[index_string] = superobject;
        }
    });

    $('.js_ads_listing').html('').html('<div class="map_container"><a class="btn btn-sm js_show_listing_ads d-listing btn-primary">View Listing</a><div class="map_pop"> <a class="close_map_box d-none" href="">cancel</a><div class="map_image" style="background: url(http://q-ec.bstatic.com/images/hotel/square90/530/53037068.jpg) no-repeat scroll 0 0 transparent"></div><div class="map_text"><h2>Kings school Dubai</h2><p class="rating">Rating: Outstading</p><p class="address">Thana Malakand Agency</p></div><div class="map_address"> <a href="" target="_blank" class="btn btn-outline-secondary">Send a Message</a> </div></div><div id="js_bigMap" style="height:500px;"></div></div>');
    //show loader
    $('.map_pop').hide();



    lat  = TotalPinsAds[0].lat;
    lang = TotalPinsAds[0].lang;
    if( typeof(lat) == 'undefined' || lat == '')
    {
        alert('Unable to find a correct location. ');
        return;
    }
    var secheltLoc = new google.maps.LatLng(lat, lang);
    myMapOptions = {zoom: 10,center: secheltLoc,scaleControl: true,mapTypeId: google.maps.MapTypeId.ROADMAP,icon: icon,zoomControlOptions: {position: google.maps.ControlPosition.LEFT_CENTER},mapTypeControlOptions: { mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']} },
        map = new google.maps.Map(document.getElementById("js_bigMap"), myMapOptions);
    marker = new google.maps.Marker({ map: map, item_number:0,draggable: true,position:  new google.maps.LatLng(lat, lang),visible: true,icon: 'https://www.godesto.com/skin/f/theme/images/mpicon.png',});
    marker.setMap(map);

    if( $(window).width() > 768 )
    {
        new google.maps.event.trigger( marker, 'click' );
    }


    google.maps.event.addListener(marker, 'click', function(e)
    {

        var latitude = this.position.lat();
        var longitude = this.position.lng();

        item_number = this.item_number ;
        index_string = TotalPinsAds[item_number].lat;
        superobject = TotalPinsAdsForDetailJobs[index_string];


        image 			= superobject.image;
        id    			= superobject.id;
        address			= superobject.address;
        name			= superobject.name;
        rating			= superobject.rating;
        url    			= superobject.url;
        console.log(superobject);
        $('.map_pop .map_text h2').html( name );
        $('.map_pop .map_address a').attr('href',url);
        $('.map_pop .map_text .address').html( address );
        $('.map_pop .map_text .rating').html( rating );
        $('.map_pop .map_image').css('background-image', 'url("' + image + '")' ) ;
        $('.map_pop .map_image').css('background-size', 'cover' ) ;
        $('.map_pop').show();
    });


    //return;

    var markers = [];
    markerData = TotalPinsAds;

    for(var i = 1 ; i < markerData.length; i++)
    {
        if( typeof( markerData[i] ) != 'undefined' )
        {
            index_string = TotalPinsAds[i].lat;
            superobject  = TotalPinsAdsForDetailJobs[index_string];
            image 			= superobject.image;
            id    			= superobject.id;
            address			= superobject.address;
            name			= superobject.name;
            rating			= superobject.rating;
            url    			= superobject.url;




            marker_ico = 'https://www.godesto.com/skin/f/theme/images/mpicon.png';
            marker = new google.maps.Marker({map: map, draggable: true,position: superobject.latLng,visible: true,icon: marker_ico,});
            overlay = new google.maps.OverlayView();
            overlay.draw = function () {};
            overlay.setMap(map);

            google.maps.event.addListener(marker, 'click', function (e)
            {
                var point 		 = overlay.getProjection().fromLatLngToContainerPixel(e.latLng);
                var latitude	 = this.position.lat();
                var longitude 	 = this.position.lng();

                index_string 	= latitude;
                superobject  	= TotalPinsAdsForDetailJobs[index_string];
                image 			= superobject.image;
                id    			= superobject.id;
                address			= superobject.address;
                name			= superobject.name;
                rating			= superobject.rating;
                url    			= superobject.url;



                $('.map_pop .map_text h2').html( name );
                $('.map_pop .map_address a').attr('href',url);
                $('.map_pop .map_text .address').html( address );
                $('.map_pop .map_text .rating').html( rating );
                $('.map_pop .map_image').css('background-image', 'url("' + image + '")' ) ;
                $('.map_pop .map_image').css('background-size', 'cover' ) ;
                $('.map_pop').show();
            });




        }
    }


    $('.loader').remove();
    $('.close-map-ads').hide();//sss $('.js_ads_listing').attr('class', 'col-12 col-md-9 js_ads_listing col-right');
}
