jQuery(function($){

    // alert('hi');
    $('.js-filter select').on('change', function(){
        var cat = $('#cat').val();
        var rating = $('#popularity').val();
        // alert(cat);
        // alert(rating);


        var data = {
            action: 'filter_posts', 
            cat: cat,
            rating: rating,
        }

        $.ajax({
            url: variables.ajax_url,
            type: 'POST',
            data: data,

            success: function(response){
                $('.js-movies').html(response);
            }
        })
    })
});