
(function( $ ) {
    $(function() {
        $(document).ready(function(){
            $(".wtdpvc_shortcode_btn").click(function(e){ 
                e.preventDefault();
                
                var shortcode = $(this).attr('data-code');   
                // copy the short code to clipboard
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(shortcode).select();
                document.execCommand("copy");
                $temp.remove();
                // show the copied message
                $(this).text('Copied!');
            });
        });
         
    });
})( jQuery );