/**
 * Traitement d'une réponses suite à la soumission d'un formulaire en ajax
 * @param data
 */
function ajaxFormSuccess(data) {

    // => REMOVE HTML
    if (data.remove_html){
        for(var i=0;i<=data.remove_html.length-1;i++){
            var path = data.remove_html[i];
            $(path).remove();
        }
    }

    // => EMPTY HTML
    if (data.empty_html){
        for(var i=0;i<=data.empty_html.length-1;i++){
            var path = data.empty_html[i];
            $(path).empty();
        }
    }

    // => REPLACE HTML
    if (data.html){
        for(var i=0;i<=data.html.length-1;i++){
            var path = data.html[i]['path'];
            var html = data.html[i]['html'];
            $(path).html(html);
        }
    }

    // => ADD HTML AT END
    if (data.append_html){
        for(var i=0;i<=data.append_html.length-1;i++){
            var path = data.append_html[i]['path'];
            var html = data.append_html[i]['html'];
            $(path).append(html);
        }
    }

    // => ADD HTML AT START
    if (data.prepend_html){
        for(var i=0;i<=data.prepend_html.length-1;i++){
            var path = data.prepend_html[i]['path'];
            var html = data.prepend_html[i]['html'];
            $(path).prepend(html);
        }
    }

    // => ADD HTML AFTER ELEMENT
    if (data.after_html){
        for(var i=0;i<=data.after_html.length-1;i++){
            var path = data.after_html[i]['path'];
            var html = data.after_html[i]['html'];
            $(path).after(html);
        }
    }

    // => ADD HTML BEFORE ELEMENT
    if (data.before_html){
        for(var i=0;i<=data.before_html.length-1;i++){
            var path = data.before_html[i]['path'];
            var html = data.before_html[i]['html'];
            $(path).before(html);
        }
    }

    // => HIDE
    if (data.hide){
        for(var i=0;i<=data.hide.length-1;i++){
            var path = data.hide[i];
            $(path).hide();
        }
    }

    // => SHOW
    if (data.show){
        for(var i=0;i<=data.show.length-1;i++){
            var path = data.show[i];
            $(path).show();
        }
    }

    // FADE OUT IN
    if (data.fadeOutIn){
        for(var i=0;i<=data.fadeOutIn.length-1;i++){
            var path = data.fadeOutIn[i]['path'];
            var timer = data.fadeOutIn[i]['timer'];
            $(path).fadeOut(0);
            $(path).fadeIn(timer);
        }
    }

    // FADE IN OUT
    if (data.fadeInOut){
        for(var i=0;i<=data.fadeInOut.length-1;i++){
            var path = data.fadeInOut[i]['path'];
            var timer = data.fadeInOut[i]['timer'];
            $(path).fadeIn(0);
            $(path).fadeOut(timer);
        }
    }

    // => Affichage de la boite
    if (data.URL) {
        location.href = data.URL;
    }
}


/* Miscellaneous
 */
$(document).ready(function(){

    //----- Menu
    $('ul.sf-menu').superfish();
    $('#menu-mobile').mmenu();


    //----- AJAX FORM
    $('.ajaxForm').ajaxForm({
        /*delegation: true,*/
        dataType: 'json',
        clearForm: false,
        success: function(data) {
            ajaxFormSuccess(data);
        }
    });

    $('select.redirect').change(function() {
        location.href = $(this).val();
    });

});