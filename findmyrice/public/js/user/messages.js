$(document).ready(function() {
    $('div#menuCustom > li').hover(
        function() {
            $(this).children('ul').fadeIn();
        }, function() {
            $(this).children('ul').fadeOut();
        }
    );
    
    $('div#markCustom > li').hover(
        function() {
            $(this).children('ul').fadeIn();
        }, function() {
            $(this).children('ul').fadeOut();
        }
    );
});

function check_all(para){
    
    if (document.getElementById('all_check').checked == true) {
        for (var i = ( para - 1 ) * 5 + 1 ; i < para * 5 + 1; i ++ ){
            document.getElementById('each_check' + i).checked = true;
        }
    } else {
        for (var i = ( para - 1 ) * 5 + 1 ; i < para * 5 + 1; i ++ ){
            document.getElementById('each_check' + i).checked = false;
        }
    }
    
}

function trash(){
    document.getElementById('user_messages').action = "/userMessage/trash";
    document.getElementById('user_messages').submit();
}

function sentTrash() {
    document.getElementById('sentUser_messages').action = "/userMessage/trash";
    document.getElementById('sentUser_messages').submit();
}

function trashTrash() {
    document.getElementById('trashUser_messages').action = "/userMessage/trash";
    document.getElementById('trashUser_messages').submit();
}

function unreadTrash() {
    document.getElementById('unreadUser_messages').action = "/userMessage/trash";
    document.getElementById('unreadUser_messages').submit();
}


function markRead(){
    document.getElementById('user_messages').action = "/userMessage/messages";
    document.getElementById('user_messages').submit();
}

function unreadMarkRead() {
    document.getElementById('unreadUser_messages').action = "/userMessage/messages";
    document.getElementById('unreadUser_messages').submit();
}

function markUnread(){
    document.getElementById('user_messages').action = "/userMessage/unread";
    document.getElementById('user_messages').submit();
}

function unreadMarkUnread(){
    document.getElementById('unreadUser_messages').action = "/userMessage/unread";
    document.getElementById('unreadUser_messages').submit();
}



function replyOver(para) {
    document.getElementById('reply' + para).src = "../../images/left_arrow_2.png";
    document.getElementById('reply_popup' + para).style.display = "block";
}

function replyOut(para) {
    document.getElementById('reply' + para).src = "../../images/left_arrow_1.png";
    document.getElementById('reply_popup' + para).style.display = "none";
}

function forwardOver(para) {
    document.getElementById('forward' + para).src = "../../images/right_arrow_3.png";
    document.getElementById('forward_popup' + para).style.display = "block";
}

function forwardOut(para) {
    document.getElementById('forward' + para).src = "../../images/right_arrow_1.png";
    document.getElementById('forward_popup' + para).style.display = "none";
}

function trashOver(para) {
    document.getElementById('trash' + para).src = "../../images/trash_icon_3.png";
    document.getElementById('trash_popup' + para).style.display = "block";
}

function trashOut(para) {
    document.getElementById('trash' + para).src = "../../images/trash_icon_1.png";
    document.getElementById('trash_popup' + para).style.display = "none";
}



function replyOver_detail(para) {
    document.getElementById('reply' + para).src = "../../images/detail_reply_2.png";
    document.getElementById('pReply' + para).style.color = "#0079b5";
}

function replyOut_detail(para) {
    document.getElementById('reply' + para).src = "../../images/detail_reply_1.png";
    document.getElementById('pReply' + para).style.color = "#000";
}

function forwardOver_detail(para) {
    document.getElementById('forward' + para).src = "../../images/detail_forward_3.png";
    document.getElementById('pForward' + para).style.color = "#0079b5";
}

function forwardOut_detail(para) {
    document.getElementById('forward' + para).src = "../../images/detail_forward_1.png";
    document.getElementById('pForward' + para).style.color = "#000";
}

function trashOver_detail(para) {
    document.getElementById('trash' + para).src = "../../images/detail_trash_2.png";
    document.getElementById('pTrash' + para).style.color = "#0079b5";
}

function trashOut_detail(para) {
    document.getElementById('trash' + para).src = "../../images/detail_trash_1.png";
    document.getElementById('pTrash' + para).style.color = "#000";
}




function pReplyOver_detail(para) {
    document.getElementById('reply' + para).src = "../../images/detail_reply_2.png";
    document.getElementById('pReply' + para).style.color = "#0079b5";
}

function pReplyOut_detail(para) {
    document.getElementById('reply' + para).src = "../../images/detail_reply_1.png";
    document.getElementById('pReply' + para).style.color = "#000";
}

function pForwardOver_detail(para) {
    document.getElementById('forward' + para).src = "../../images/detail_forward_3.png";
    document.getElementById('pForward' + para).style.color = "#0079b5";
}

function pForwardOut_detail(para) {
    document.getElementById('forward' + para).src = "../../images/detail_forward_1.png";
    document.getElementById('pForward' + para).style.color = "#000";
}

function pTrashOver_detail(para) {
    document.getElementById('trash' + para).src = "../../images/detail_trash_2.png";
    document.getElementById('pTrash' + para).style.color = "#0079b5";
}

function pTrashOut_detail(para) {
    document.getElementById('trash' + para).src = "../../images/detail_trash_1.png";
    document.getElementById('pTrash' + para).style.color = "#000";
}

function detailReply(){
    document.getElementById('beforUserClick').style.display = 'none';
    document.getElementById('afterUserClick').style.display = 'block';
}

function eachMessageOver(para){
    document.getElementById('icons' + para).style.display = 'block';
//    document.getElementById('messageName' + para).style.color = 'gray';
//    document.getElementById('messageCreatedAt' + para).style.color = 'gray';
//    document.getElementById('messageMessage' + para).style.color = 'gray';
}

function eachMessageOut(para){
    document.getElementById('icons' + para).style.display = 'none';
//    document.getElementById('messageName' + para).style.color = 'black';
//    document.getElementById('messageCreatedAt' + para).style.color = 'black';
//    document.getElementById('messageMessage' + para).style.color = 'black';
}

function eachMessageOverSent(para){
    document.getElementById('icons' + para).style.display = 'block';
//    document.getElementById('messageName' + para).style.color = 'gray';
//    document.getElementById('messageCreatedAt' + para).style.color = 'gray';
//    document.getElementById('messageMessage' + para).style.color = 'gray';
}

function eachMessageOutSent(para){
    document.getElementById('icons' + para).style.display = 'none';
//    document.getElementById('messageName' + para).style.color = 'blue';
//    document.getElementById('messageCreatedAt' + para).style.color = 'blue';
//    document.getElementById('messageMessage' + para).style.color = 'blue';
}



















