
window.onload = function(){
    countMessages = 0
}

var countMessages = 0
var nickName = ""
var token = ""
var ajax = null;
var ajax2 = null;
var topScroll = 0;
var direct = false;
var usersOnline = [];

var SpeechRecognition = window.webkitSpeechRecognition
var recognition = new SpeechRecognition()
var Content = ''

recognition.continuous = true

recognition.onresult = function(event) {

    var current = event.resultIndex
    var transcript = event.results[current][0].transcript

    Content = transcript

    let user = nickName
    let message = Content
    let private = 0
    let type = 1
    let voice = 1

    console.log("preUser: " + user +  " // Message voice: " + Content)

    sendMessageToServer(type, user, message, private, voice)
    console.log("User: " + user +  " // Message voice: " + Content)
    sendMessageToServer(type, user, message, private, voice)

    recognition.start()

};

recognition.onstart = function() { 
    console.log('Voice recognition is ON.')
}

recognition.onspeechend = function() {
    console.log('Not activity.')
}

recognition.onerror = function(event) {
    if(event.error == 'no-speech') {
        console.log('Try again.') 
    }
}

setInterval(function(){
    
    if(nickName == ""){
        for(let i=0; i<$('.Message__ContentWrapper-sc-1pmavu-11').length; i++){
            let text = $('.Message__ContentWrapper-sc-1pmavu-11 > .Message__MessageElem-sc-1pmavu-6').eq(i).html()
            if(text.indexOf("Welcome to your Video Chat Room,") >= 0){
                i = $('.Message__ContentWrapper-sc-1pmavu-11').length
                nickName = text.replace("Welcome to your Video Chat Room, ", "")
                startListening()
            }
        }
    }

    if(countMessages == 0 && $('#scroller').length > 0){
        document.getElementById("scroller").addEventListener("DOMNodeInserted", readMessages, false)
        //document.getElementsByClassName("scrollbar-container scroll-bar ps")[0].addEventListener("DOMNodeInserted", userOnline, false)
        //document.getElementsByClassName("scrollbar-container scroll-bar ps")[0].addEventListener("DOMNodeRemoved", userOnline, false)
    }
}, 1000);


$.get(chrome.runtime.getURL('/popupWindows.html'), function(data) {
    $(data).appendTo('body')

    $('#windowPopup').draggable({containment: "parent"});

    $('.iconSend').click(function(){
        let text = $(this).attr('data-text')
        copiarAlPortapapeles(text)
        $('.Input__InputElem-sc-1aibbhv-27').focus()
        document.execCommand("paste")
        $('.Input__InputElem-sc-1aibbhv-27').keyup()
    })
});

function userOnline(){
    var objs = $('.scrollbar-container .scroll-bar .ps').find('.GuestItem__Wrapper-sc-1qir4ov-9 .gZhWla .guest-item');
    console.log("DOGGI: " + objs);
    var usersTemp = [];
    for(var i = 0; i < objs.length; i++){
        usersTemp.push(objs.find('.GuestItem__Name-sc-1qir4ov-11 .hACGKi').html());
    }

    var arrayFilter = usersTemp.filter(elemento => usersOnline.indexOf(elemento) == -1);
    console.log(usersTemp);
    console.log(arrayFilter);
    //Send arrayFilter to server, they are new users
}

function readMessages(){      
    
    if($('.Message__ContentWrapper-sc-1pmavu-11').length > countMessages){
        
        let user = nickName
        let message = ""
        let type = 1
        let private = 0
        let voice = 0

        if($('.Message__ContentWrapper-sc-1pmavu-11 > .Message__MessageElem-sc-1pmavu-6').eq(countMessages).siblings().length > 0){
            user = $('.Message__ContentWrapper-sc-1pmavu-11').eq(countMessages).find('.Message__From-sc-1pmavu-7').html()
            type = 2
        }

        message = $('.Message__ContentWrapper-sc-1pmavu-11 .Message__MessageElem-sc-1pmavu-6').eq(countMessages).html()

        console.log("User: " + user +  " // Message: " + message)

        sendMessageToServer(type, user, message, private, voice)
        
        countMessages++
    }
}


function sendMessageToServer(type, user, message, private, voice){

    $('.Message__ContentWrapper-sc-1pmavu-11').off('click');
    $('.Message__ContentWrapper-sc-1pmavu-11').on('click', consultMessage);

    recognition.start()

    $('.Message__ContentWrapper-sc-1pmavu-11').off('click');
    $('.Message__ContentWrapper-sc-1pmavu-11').on('click', consultMessage);

    

    if(user != "" && message != "" && $('.Option__Text-sc-1g6khun-1:contains("Private Chat")').length > 0){
        private = 1
    }
    
    if(user != "" && message != ""){
        var ajax = $.ajax({
            type: 'POST',
            url: "https://devstec.digital/icam/chatbot",
            data:{type: type, user: user, message: message, webCam: nickName, private: private, voice: voice},
            success: function(data){
                //console.log(data)

            }
        });
    }
}


function translateText(){
    var text = $('#inputText').val();

    if(ajax2 != null){
        ajax2.abort();
    }

    ajax2 = $.ajax({
        type: 'POST',
        url: "https://api.deepl.com/v2/translate?text=" + text + "&source_lang=ES&target_lang=EN&auth_key=d15a8e8e-94a7-9e17-547d-9331610be21c",
        data:{text: text, target_lang: "EN", auth_key: 'd15a8e8e-94a7-9e17-547d-9331610be21c'},
        success: function(data){
            var json = eval(data);
            console.log(json);
            $('#outputText').val(json['translations'][0]['text'])
        }
    });
}

function copiarAlPortapapeles(text) {
    if (!navigator.clipboard){
        var aux = document.getElementById("copyBox")
        aux.setAttribute("value", text)
        document.body.appendChild(aux)
        aux.select()
        document.execCommand("copy")
        document.body.removeChild(aux)
    } else{
        var aux = document.getElementById("copyBox")
        aux.setAttribute("value", text)
        aux.select();
        aux.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(text).then(
            function(){
                console.log("yeah!"); // success 
            })
        .catch(
            function() {
                console.log("err"); // error
        });
    }   
}

function cleanUp(){
    $('#outputText').val('');
    $('#inputText').val('');
}

function startListening(){
    console.log('START')
    recognition.start()
}

function consultMessage(array){

    var length;
    var nameUser = "default";
    var textMessage = "";
    var girl;
    console.log("CONSOLELOG: " + array.direct);

    if(array.direct){
        length = 2;
        textMessage = array.message;
        girl = "default";

    }else{
        length = $(this).children().length;
        nameUser = $(this).children().eq(0).children().eq(0).html();
        textMessage = $(this).children().eq(1).html();
        girl = nickName;
    }

    if(length > 1){

        if($('#barFixed').css('margin-left') == '-200px'){
            $('#barFixed').css('margin-left', '0px');
            var obj = $(this);
            setTimeout(function(){
                obj.click();
            }, 500);
            return;
        }

        
        if($('#translate').attr('data-state') == 'out'){
            $('#translate').click();
        }

        if($('#arrow').attr('data-state') != 'out'){
            $('#arrow').click();
        }

        $('#windowPopup').html("");

        

        $('#loading').fadeIn();

        
        
        if(ajax != null){
            ajax.abort();
        }
        
        ajax = $.ajax({
            type: 'POST',
            url: "https://devstec.digital/icam/diccionario",
            data:{message:textMessage, token:token, girl:girl, user:nameUser},
            success: function(data, xhr){
                
                console.log(xhr.status);
                var array = JSON.parse(data);

                token = array['token'];

                $('#windowPopup').html(array.html);

                $('.iconFeelBack').click(function(){
                    $('#inputText').val($(this).attr('data-translate'));
                    $('#outputText').val($(this).attr('data-response'));
                    $('#translate').click();
                });

                $('#userNameInfo').html($('#nameUser').html());
                
                $('.link').off('hover');
                $('.link').hover(function(){
                    console.log("LINK IN");
                    if($(this).attr('data-image') != ""){
                        $('#imageGlobe').attr('src', $(this).attr('data-image'));
                    }
                    $('#textGlobe').html($(this).attr('data-text'));

                    var left = $(this).offset().left + 20;
                    var top = $(this).offset().top - $('#globe').height() -20;
                    $('#globe').css({'left':left, 'top':top})
                    $('#globe').fadeIn();
                    }, function(){
                        $('#globe').fadeOut();
                    }
                );

                $('.iconSend').off('click');
                $('.iconSend').click(function(){
                    var text = $(this).attr('data-text')
                    console.log(text)
                    copiarAlPortapapeles(text)
                })

                $('#loading').fadeOut();
            },
            statusCode: {
                200: function(){
                         //document.getElementById(element).innerHTML = "🗸"
                         //location.reload()
                     },
                500: function(){
                         //document.getElementById(element).innerHTML = "🗸"
                         //location.reload()
                     } 
            }
        });
    }
}

function onPopup(state){

    if(state){

        topScroll = $(window).scrollTop();;

        $('#arrow').off('click');
        $('#translate').off('click');
        $('.iconFeelBack').off('click');
        cleanUp();

        $('#barFixed').css('margin-left', '0px');

        $('.link').off('hover');
        $('.link').hover(function(){
            $('#imageGlobe').attr('src', $(this).attr('data-image'));
            $('#textGlobe').html($(this).attr('data-text'));
    
            var left = $(this).offset().left + 30;
            var top = $(this).offset().top - $('#globe').height() - 30;
            $('#globe').css({'left':left, 'top':top})
            $('#globe').fadeIn();
            }, function(){
                $('#globe').fadeOut();
            }
            
        );

        $('#inputText').on("keyup", function(){
            translateText();
        });

        $('.iconFeelBack').click(function(){

            $('#inputText').val($(this).attr('data-translate'));
            $('#outputText').val($(this).attr('data-response'));
            $('#translate').click();

        });

        $('#arrow').click(function(){
            if($('#translate').attr('data-state') == 'out'){
                $('#translate').click();
            }

            if($('#settingsButton').attr('data-state') == 'out'){
                $('#settingsButton').click();
            }

            if($(this).attr('data-state') == 'in'){
                $(this).css('transform', 'scaleX(1)');
                $(this).attr('data-state', 'out');
        
                var height = parseFloat($('#barFixed').css('height')) + 50;
                
                $('#overFlow').css('height', (height+15) + 'px');
                $('#windowPopup').css('height', height + 'px');
                $('#overFlow').css('top', ($('#barFixed').offset().top - topScroll) + 'px');
                $('#overFlow').css('left', $('#barFixed').offset().left + 'px');
        
                $('#overFlow').css('width', '810px');
                $('#overFlow').css('margin-left', '100px');
                $('#windowPopup').css('margin-left', '0px');
                
            }else{
                $(this).css('transform', 'scaleX(-1)'); 
                $(this).attr('data-state', 'in');
        
                $('#windowPopup').css('margin-left', '-900px');
                $('#overFlow').css('margin-left', '0px');
                $('#overFlow').css('width', '0px');
            }
        });
        
        $('#translate').click(function(){

            if($('#arrow').attr('data-state') == 'out'){
                $('#arrow').click();
            }

            if($('#settingsButton').attr('data-state') == 'out'){
                $('#settingsButton').click();
            }
        
            if($(this).attr('data-state') == 'in'){
                $(this).css('transform', 'scaleX(1)');
                $(this).attr('data-state', 'out');
        
                var height = parseFloat($('#barFixed').css('height')) + 50;
                var top = $('#barFixed').offset().top + 100 - topScroll;
                
                $('#overFlow2').css('height', (height+15) + 'px');
                $('#overFlow2').css('top', top + 'px');
                $('#overFlow2').css('left', $('#barFixed').offset().left + 'px');
        
                $('#overFlow2').css('width', '810px');
                $('#overFlow2').css('margin-left', '100px');
                $('#translateGlobe').css('margin-left', '0px');
                
            }else{
                $(this).css('transform', 'scaleX(-1)');
                $(this).attr('data-state', 'in');
        
                $('#translateGlobe').css('margin-left', '-900px');
                $('#overFlow2').css('margin-left', '0px');
                $('#overFlow2').css('width', '0px');
            }
        });

        $('#settingsButton').click(function(){

            if($('#arrow').attr('data-state') == 'out'){
                $('#arrow').click();
            }

            if($('#translate').attr('data-state') == 'out'){
                $('#translate').click();
            }

            if($(this).attr('data-state') == 'in'){
                $(this).attr('data-state', 'out');

                var height = parseFloat($('#barFixed').css('height')) + 50;
                var top = $('#barFixed').offset().top + 100 - topScroll;
                
                $('#overFlow3').css('height', (height+15) + 'px');
                $('#overFlow3').css('top', top + 'px');
                $('#overFlow3').css('left', $('#barFixed').offset().left + 'px');
        
                $('#overFlow3').css('width', '810px');
                $('#overFlow3').css('margin-left', '100px');
                $('#settingsGlobe').css('margin-left', '0px');
                
            }else{
                $(this).attr('data-state', 'in');
                $('#settingsGlobe').css('margin-left', '-900px');
                $('#overFlow3').css('margin-left', '0px');
                $('#overFlow3').css('width', '0px');
            }
        });
        
        $('#barFixed').draggable({containment:'parent', drag:function(){
            $('#overFlow').css('top', ($('#barFixed').offset().top - topScroll) + 'px');
            $('#overFlow').css('left', $('#barFixed').offset().left + 'px');
        
            var top = $('#barFixed').offset().top + 100 - topScroll;
            $('#overFlow2').css('top', top + 'px');
            $('#overFlow2').css('left', $('#barFixed').offset().left + 'px');
            $('#overFlow3').css('top', top + 'px');
            $('#overFlow3').css('left', $('#barFixed').offset().left + 'px');
        }});

        $('#btTranslate').click(function(){ translateText(); });
        $('#btCopy').click(function(){ copiarAlPortapapeles($('#outputText').val()) });
        $('#btClean').click(function(){ cleanUp() });


        $('.Message__ContentWrapper-sc-1pmavu-11').off('click');
        $('.Message__ContentWrapper-sc-1pmavu-11').click({direct:false, message:""}, consultMessage);
        

        

        $('#exit').click(exit);

    }else{
        $('.link').off('hover');
        $('.Message__ContentWrapper-sc-1pmavu-11').off('click');
    }
}

function exit(){
    $('#barFixed').css('left', '0');
    $('#barFixed').css('margin-left', '-200px');

    if($('#translate').attr('data-state') == 'out'){
        $('#translate').click();
    }

    if($('#arrow').attr('data-state') == 'out'){
        $('#arrow').click();
    }

    chrome.storage.local.set({
        state: false
    })
}

$(window).scroll(function (event) {
    topScroll = $(window).scrollTop();
});

function feelback(question, response){
    ajax = $.ajax({
        type: 'POST',
        url: "https://devstec.digital/icam/feelback",
        data:{question:question, response:response},
        success: function(data){
            
        }
    });
}