
$(document).ready(function(e)
{
    setTimeout( creat_type_ahead, 100);
    setTimeout( load_areas, 100);
});
function creat_type_ahead()
{

    $.ajax({
        type: 'POST',
        url: path + '/school_search',
        data: '_token=' + token,   dataType: "json",
        success: function(response)
        {

            if( response.result == 1 )
            {
                response = response.data;
                var jsonData = response;
                var dataSource = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name', 'id'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: jsonData
                });

                dataSource.initialize();
                $('.js_txt_search').typeahead({
                    minLength: 0,
                    highlight: true
                }, {
                    name: 'schools',
                    display: function(item) {
                        return item.name
                    },
                    source: dataSource.ttAdapter(),
                    suggestion: function(data)
                    {
                        return '<div>' + data.name + '</div>'
                    }

                });

                $('.js_txt_search').on('typeahead:selected', function (e, datum)
                {
                    $('.js_txt_search_hide').val(datum.name);
                });
            }
        }
    });
}
function load_areas()
{
    $.ajax({
        type: 'POST',
        url: path + '/load_area',
        data: '_token=' + token,   dataType: "json",
        success: function(response)
        {
            if( response.result == 1 )
            {
                data = response.data;
                html = '<option value="">All of Dubai</option>';
                for( i = 0; i < data.length; i ++ )
                {
                    html +='<option value="'+ data[i].area +'">'+ data[i].area +'</option>';
                }
                $('.js_area').html( html );
            }
        }
    });
}
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