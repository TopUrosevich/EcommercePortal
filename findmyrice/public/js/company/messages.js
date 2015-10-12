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

function  archive(){
    var rows = document.getElementsByName('each_check[]');
    
    var selectedRows = [];
    
    var l = rows.length;
    
    for (var i = 0; i < l; i++) {
        if (rows[1].checked) {
            selectedRows.push(rows[i]);
        }
    }
    
    var m = selectedRows.length;
    
    var html = [];
    
    for (i = 0; i < m ; i ++ ){
        
        html[i] = '<input type="hidden" name="'+ i +'" id="'+ i +'" value="'+ selectedRows.getAttribute('id') +'" />';
        
        document.getElementById('archive_data').innerHTML = html[i];
        
    }
    
    var html_c = '<input type="hidden" name="coun" id="coun" value="'+ m +'" />'
    
    document.getElementById('archive_data').innerHTML = html_c;
    
    document.getElementById('archive').submit();
}

function trash(){
    document.getElementById('uro_messages').action = "/companyMessage/trash";
    document.getElementById('uro_messages').submit();
}

function sentTrash() {
    document.getElementById('sent_messages').action = "/companyMessage/trash";
    document.getElementById('sent_messages').submit();
}

function trashTrash() {
    document.getElementById('trash_messages').action = "/companyMessage/trash";
    document.getElementById('trash_messages').submit();
}

function unreadTrash() {
    document.getElementById('unread_messages').action = "/companyMessage/trash";
    document.getElementById('unread_messages').submit();
}


function markRead(){
    document.getElementById('uro_messages').action = "/company/messages";
    document.getElementById('uro_messages').submit();
}

function unreadMarkRead() {
    document.getElementById('unread_messages').action = "/company/messages";
    document.getElementById('unread_messages').submit();
}

function markUnread(){
    document.getElementById('uro_messages').action = "/companyMessage/unread";
    document.getElementById('uro_messages').submit();
}

function unreadMarkUnread(){
    document.getElementById('unread_messages').action = "/companyMessage/unread";
    document.getElementById('unread_messages').submit();
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
    document.getElementById('beforClick').style.display = 'none';
    document.getElementById('afterClick').style.display = 'block';
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



















