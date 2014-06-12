
$(document).ready(function() {
    $(".all_images").scroll(function() {
        if (!done) {
            var scrollHeight = $(".all_images").prop('scrollHeight');
            var divHeight = $(".all_images").height();
            var scrollerEndPoint = scrollHeight - divHeight;
            var divScrollerTop = $(".all_images").scrollTop();
            if ((scrollerEndPoint - divScrollerTop) < 100)
            {
                myphotos();//The Div scroller has reached the bottom   
            }
        }
    });
});