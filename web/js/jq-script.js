$(document).ready(function(){

    $('#add-author').on('click', function () {
        $('#books-author_id').clone().attr('class', 'form-control authors-list').appendTo('#authors-form');
    });

});