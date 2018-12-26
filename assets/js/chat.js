/*jslint browser: true*/
/*global $, jQuery, alert*/

$(function () {

    "use strict";

    $('.chat-left-inner > .chatonline').slimScroll({
        height: '100%',
        position: 'right',
        size: "5px",
        color: '#dcdcdc'

    });
    $('.chat-list').slimScroll({
        position: 'right'
        , size: "5px"
        , height: '100%'
        , color: '#dcdcdc'
     });
    
    var cht = function () {
            var topOffset = 445;
            var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
            height = height - topOffset;
            $(".chat-list").css("height", (height) + "px");
    };
    $(window).ready(cht);
    $(window).on("resize", cht);
    
    

    // this is for the left-aside-fix in content area with scroll
    var chtin = function () {
            var topOffset = 270;
            var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
            height = height - topOffset;
            $(".chat-left-inner").css("height", (height) + "px");
    };
    $(window).ready(chtin);
    $(window).on("resize", chtin);
    
    


    $(".open-panel").on("click", function () {
        $(".chat-left-aside").toggleClass("open-pnl");
        $(".open-panel i").toggleClass("ti-angle-left");
    });

});

/* Popup function */
$(document).ready(function(){
     
    var arr = ["skp"]; // List of users
   
    $('.chat-popup-header').click(function(){  
        var chatbox = $(this).parents().attr("rel") ;
        $('[rel="'+chatbox+'"] .chat-popup-body').slideToggle('slow');
        return false;
    });
   
    $('.chat-popup-close').click(function(){
    
        var chatbox = $(this).parents().parents().attr("rel") ;
        $('[rel="'+chatbox+'"]').hide();
        //update require
        arr.splice($.inArray(chatbox, arr),1);
        i = 50 ; // start position
        j = 260;  //next position
        $.each( arr, function( index, value ) {          
            $('[rel="'+value+'"]').css("right",i);
        i = i+j;
            });
        
        return false;
    });
});

/*Transfer Messege*/
$(document).ready(function(){
    var conn = new WebSocket('ws://tutorials.lcl:8080');
    conn.onopen = function(e) {
        console.log("Connection established!");
    };

    conn.onmessage = function(e) {
        console.log(e.data);
        var data = JSON.parse(e.data);
        var row = '<tr><td valign="top"><div><strong>' + data.from +'</strong></div><div>'+data.msg+'</div><td align="right" valign="top">'+data.dt+'</td></tr>';
        $('#chats > tbody').prepend(row);

    };

    conn.onclose = function(e) {
        console.log("Connection Closed!");
    }

    $("#send").click(function(){
        var userId 	= $("#userId").val();
        var msg 	= $("#msg").val();
        var data = {
            userId: userId,
            msg: msg
        };
        conn.send(JSON.stringify(data));
        $("#msg").val("");
    });

})
