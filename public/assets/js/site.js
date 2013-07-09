$(document).ready(function() {
    $(".open-modal").click(function (e) {
        var el=$(this);
        var modalSize = '';
        var modalID = '';               
        $.ajax({
            type: "GET",
            url: '/' + el.attr("data-type") + '/' + el.attr("data-id"),                        
            dataType: "html",
            success: function(data) {
                if (el.is("data-modal-id")) {
                    modalID = el.attr("data-modal-id");
                } 
                if (el.is("data-modal-size")) {
                    modalSize = el.attr("data-modal-size");
                }                
                $('<div id="' + modalID + '" class="modal ' + modalSize + ' fade" >' + data + '</div>').modal();                    
            }
        });
    });    
    
    $(".add_designer").tooltip({
        title: "Add a new designer"
    });
    $(".add_boat").tooltip({
        title: "Add a new boat"
    });
    $(".designer_link").tooltip({
        title: "Designer Details"        
    });
        
    $(".paginate_link").click(function (e) {    
        e.preventDefault();
        var el=$(this);
        var pageID = el.attr("data-index")
        $("#page").attr('value',pageID);
        $('#pagination_form').submit();
    });

});

function searchAndHighlight(searchTerm, selector) {
    if(searchTerm) {
        var selector = selector || "body";                             //default selector is body if none provided
        var searchTermRegEx = new RegExp(searchTerm,"ig");
        var matches = $(selector).text().match(searchTermRegEx);
        if(matches) {
            $('.highlighted').removeClass('highlighted');     //Remove old search highlights
            $(selector).html($(selector).html()
                    .replace(searchTermRegEx, "<span class='highlighted'>"+searchTerm+"</span>"));
            if($('.highlighted:first').length) {             //if match found, scroll to where the first one appears
                $(window).scrollTop($('.highlighted:first').position().top);
            }
            return true;
        }
    }
    return false;
}

