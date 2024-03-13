let _commentList = [];
let _tempCommentList = [];
let _tempCommentIdCounter = 0;
let _tempReplieIdCounter = 0;

let commentMenuIsOpen = false;
let _canCloseCommentMenu = false;
let replyMenuIsOpen = false;
let _canCloseReplyMenu = false;


let _assignedComments = [];
let _assignedCommentsReplies = [];

$('#openEventComments').on('click', function () {
    openEventComments()
});

$('#closeThismfMenu').on('click', function () {
    console.log('cloclocloclco')
});


$(document).on('click', function (event) {

    if (!_canCloseCommentMenu && !$(event.target).hasClass('comment-menu-option')){

        _canCloseCommentMenu = true;
        return
    }
    // console.log(event.target);
    closeAllCommentMenu()


})




function createComment(commentData) {

    let COMMENT = `<div class="--comment-wrapper">
        <div class="comment-box tempComment" temp_id=${commentData.temp_comment_id}>
            <div class="comment-data">
                <div class="--user-photo">
                    <div class="--user-photo-container">
                        <img src="../../assets/svg/default-user-photo.svg" alt="default user photo">
                    </div>
                </div>
                <div class="--coment-content">
                    <div class="--user-name" comment_id=${commentData.temp_comment_id}>
                        <div class="comment-info-container">
                            <p class='comment-info-txt'>${commentData.user_name}</p>
                            <p class='comment-date-txt'>${getTodayForCommentDisplay()}</p>
                        </div>
                        <img src="../../assets/svg/dots-horizontal-svgrepo-com.svg" alt="option dots" class="-comment-options" onclick="openCommentMenu(this)">
                        <div class="-comment-menu">
                            <div class="comment-menu-option" onclick="deleteTempComment(this)">
                                <p>Eliminar</p>
                            </div>
                            <div class="comment-menu-option" onclick="openEditComment(this)">
                                <p>Editar</p>
                            </div>
                        </div>
                    </div>
                    <div class="--comment">
                        <textarea readonly class="--comment-textArea" id="" cols="30" rows="10">${commentData.comment_text}</textarea>
                    </div>
                </div>
            </div>
            <div class="--comment-footer">
                <button class="--replyComment" onclick="openReplieSection(this)">
                    <img src="../../assets/svg/replyComment.svg" alt="replyCommentLogo">
                    <p> responder</p>
                </button>
                <p class="viewReplies" onclick="openReplies(this)"> ver respuestas</p>
                
            </div>
        </div>
        <div class="--comment-reply-wrapper">
        </div>
    </div>`

    return COMMENT;
}

function createAssignedComment(commentData) {

    let ownerClass = false;

    if (commentData.post_user_id == PERSONAL_IDS[0].usuario_id) {
        ownerClass = true;
    }

    const COMMENT = `
        <div class="--comment-wrapper">
        <div class="comment-box ${ownerClass ? 'ownComment' : ''} assignedComment" comment_id = ${commentData.comment_id}>
            <div class="comment-data">
                <div class="--user-photo">

                    <div class="--user-photo-container">
                        <img src="../../assets/svg/default-user-photo.svg" alt="default user photo">
                    </div>
                </div>
                <div class="--coment-content">
                    <div class="--user-name" comment_id=${commentData.comment_id}>
                        <div class="comment-info-container">
                            <p class='comment-info-txt'>${commentData.user_name}</p>
                            <p class='comment-date-txt'>${parseDatetimeToDate(commentData.post_date)}</p>
                        </div>
                        ${ownerClass ?
                        `<img src="../../assets/svg/dots-horizontal-svgrepo-com.svg" alt="option dots" class="-comment-options" onclick="openCommentMenu(this)">
                            <div class="-comment-menu">
                                <div class="comment-menu-option" onclick="deleteComment(this)">
                                    <p>Eliminar</p>
                                </div>
                                <div class="comment-menu-option" onclick="openEditComment(this)">
                                    <p>Editar</p>
                                </div>
                            </div>`
                        : ''}

                    </div>
                    <div class="--comment">
                        <textarea readonly class="--comment-textArea" id="" cols="30" rows="10">${commentData.text}</textarea>
                    </div>
                </div>
            </div>
            <div class="--comment-footer">
                <button class="--replyComment" onclick="openReplieSection(this)">
                    <img src="../../assets/svg/replyComment.svg" alt="replyCommentLogo">
                    <p> responder</p>
                </button>
                <p class="viewReplies" onclick="openReplies(this)"> ver respuestas</p>
                
            </div>
        </div>
        <div class="--comment-reply-wrapper">
        </div>
    </div>`;




    // <p>${commentText}</p>
    return COMMENT;
}

function createTempReply(replyData) {
    const TEMP_REPLY = `
        <div class="--reply-comment-data temp-reply" temp_reply_id="${replyData.temp_comment_id}">
            <div class="--reply-comment-data-header">
                <div class="reply-com-user-data">
                    <div class="-rudata">
                        <img src="../../assets/svg/default-user-photo.svg" alt="default user photo">
                        <p> ${replyData.user_name}</p>
                        <p class="-comment-date-reply"> ${getTodayForCommentDisplay()}</p>
                    </div>
                </div>
                <img src="../../assets/svg/dots-horizontal-svgrepo-com.svg" alt="option dots" class="-comment-options" 
                onclick="openReplyMenu(this)">
                <div class="-comment-menu">
                    <div class="comment-menu-option" onclick="deleteTempReply(this)">
                        <p>Eliminar</p>
                    </div>
                    <div class="comment-menu-option" onclick="openEditComment(this)">
                        <p>Editar</p>
                    </div>
                </div>
            </div>
            <div class="reply-comment-text">
                <textarea readonly class="--reply-text_area" readonly> ${replyData.replie_text}</textarea>
            </div>
    </div>`

    return TEMP_REPLY;
}
function createAssiReply(replyData) {
    const TEMP_REPLY = `
    <div class="--reply-comment-data assi-reply" reply_id="${replyData.reply_id}">
        <div class="--reply-comment-data-header">
            <div class="reply-com-user-data">
                <div class="-rudata">
                    <img src="../../assets/svg/default-user-photo.svg" alt="default user photo">
                    <p> ${replyData.user_name}</p>
                    <p class="-comment-date-reply"> ${replyData.post_date}</p>
                </div>
            </div>
            <img src="../../assets/svg/dots-horizontal-svgrepo-com.svg" alt="option dots" class="-comment-options" 
            onclick="openReplyMenu(this)">
            <div class="-comment-menu">
                <div class="comment-menu-option" onclick="deleteReply(this)">
                    <p>Eliminar</p>
                </div>
                <div class="comment-menu-option" onclick="openEditComment(this)">
                    <p>Editar</p>
                </div>
            </div>
        </div>
        <div class="reply-comment-text">
            <textarea readonly class="--reply-text_area" readonly> ${replyData.reply_text}</textarea>
        </div>
    </div>`

    return TEMP_REPLY;
}





async function deleteReply(element){

    const REPLY_ELEMENT = $(element).closest('.--reply-comment-data');
    
    if($(REPLY_ELEMENT).hasClass('assi-reply')){

        const REPLY_ID = $(element).closest('.--reply-comment-data').attr('reply_id');

        const REPLY_EXISTS = _assignedCommentsReplies.find((replies)=>{
            return replies.reply_id == REPLY_ID
        });
        
        if(!REPLY_EXISTS){
            return;
        }
        const DELETE_REPLY_REQUEST = {
            comment_id: REPLY_ID,
            user_id: PERSONAL_IDS[0].usuario_id,
            empresa_id: EMPRESA_ID
        }
        const DELETE_REPLY_RESPONSE = await deleteComment_sd(DELETE_REPLY_REQUEST);
    
        if (DELETE_REPLY_RESPONSE.error) {
            return;
        }
        $(element).closest('.--reply-comment-data').remove();
    }
}

async function deleteTempReply(element){

    let commentId = $(element).closest('.--comment-wrapper').find('.comment-box').attr('temp_id');
    let temp_reply_id = $(element).closest('.--reply-comment-data').attr('temp_reply_id');

    const TEMP_COMENT_DATA = _tempCommentList.find((tempComment) => {
        return tempComment.temp_comment_id == commentId;
    });
    
    if(!TEMP_COMENT_DATA){
        return; 
    };
    
    const REPLY_DATA = TEMP_COMENT_DATA.replies.find((tempReply)=>{
        return tempReply.temp_comment_id == temp_reply_id
    })
    if(!REPLY_DATA){
        return
    }

    _tempCommentList[_tempCommentList.indexOf(TEMP_COMENT_DATA)]
    .replies
    .splice(_tempCommentList[_tempCommentList.indexOf(TEMP_COMENT_DATA)].replies.indexOf(REPLY_DATA),1);

    $(element).closest('.--reply-comment-data').remove();
}


function getTodayForCommentDisplay() {

    const today = new Date();
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();

    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;

    const formattedToday = dd + '/' + mm + '/' + yyyy;
    return formattedToday
}

function parseDatetimeToDate(datetime){


    let dateToFormatt = new Date(datetime);
    return dateToFormatt.toLocaleDateString('es-CL')
}

function createAssignedReplie() {

}
function openEventComments() {
    $('#eventCommentsSideMenu').addClass('active');
}
function closeEventComments() {
    $('#eventCommentsSideMenu').removeClass('active');
}

let currentRepplieCommentObject = '';
function openReplieSection(element) {
    $('#replySection').addClass('active');
    currentRepplieCommentObject = $(element).closest('.comment-box');
}

function commentReplySelector() {

    if ($(currentRepplieCommentObject).hasClass('tempComment')) {
        commentTempReplie();
        return
    }

    commentAssignedComment();
}

function commentTempReplie() {

    

    const TEMP_COMMENT_REPLIE_TEXT = $('#replieText').val();


    let commentId = -1;

    if ($(currentRepplieCommentObject).hasClass('tempComment')) {
        commentId = $(currentRepplieCommentObject).attr('temp_id');

        const TEMP_COMENT_DATA = _tempCommentList.find((tempComment) => {
            return tempComment.temp_comment_id == commentId;
        });

        if (TEMP_COMENT_DATA) {
            _tempReplieIdCounter++;

            let tempReplyData = {
                temp_comment_id: _tempReplieIdCounter,
                post_user_id: PERSONAL_IDS[0].usuario_id,
                user_name: PERSONAL_IDS[0].user_name,
                replie_text: TEMP_COMMENT_REPLIE_TEXT
            }
            TEMP_COMENT_DATA.replies.push(tempReplyData);

            $(currentRepplieCommentObject)
                .closest('.--comment-wrapper')
                .find('.--comment-reply-wrapper')
                .append(createTempReply(tempReplyData));
        }
        closeReplieSection();
        return
    }

}


async function commentAssignedComment() {


    const ASSIGNED_COMMENT_REPLY_TEXT = $('#replieText').val();

    if ($(currentRepplieCommentObject).hasClass('assignedComment')) {

        commentId = $(currentRepplieCommentObject).attr('comment_id');


        const ASSIGNED_COMMENT_DATA = _assignedComments.find((assiComment) => {
            return assiComment.comment_id == commentId;
        });


        if (ASSIGNED_COMMENT_DATA) {

            let assignedReplyData = {
                post_user_id: PERSONAL_IDS[0].usuario_id,
                reply_text: ASSIGNED_COMMENT_REPLY_TEXT
            }

            const REPLY_ASSIGNED_COMMENT = await replyAssignedComment(assignedReplyData, EMPRESA_ID, event_data.event_id, commentId, PERSONAL_IDS[0].usuario_id);
           
            if (REPLY_ASSIGNED_COMMENT.success) {

                const ASSI_REPLY_DATA = {
                    'comment_id': ASSIGNED_COMMENT_REPLY_TEXT,
                    'reply_id': REPLY_ASSIGNED_COMMENT.reply_id,
                    'post_user_id': assignedReplyData.post_user_id,
                    'reply_text': assignedReplyData.reply_text,
                    'user_name': PERSONAL_IDS[0].user_name,
                    'post_date': getTodayForCommentDisplay()
                }
                _assignedCommentsReplies.push(ASSI_REPLY_DATA);

                $(currentRepplieCommentObject)
                    .closest('.--comment-wrapper')
                    .find('.--comment-reply-wrapper')
                    .append(createAssiReply(ASSI_REPLY_DATA));
            }
        }
        closeReplieSection();
        return
    }
}

function closeReplieSection() {
    $('.--replySection').removeClass('active');
}

let repliesOpen = false
function openReplies(element) {
    if (!repliesOpen) {
        repliesOpen = true
        $(element).text('ocultar')
        $(element).closest('.--comment-wrapper').find('.--comment-reply-wrapper').addClass('active')
        return
    }
    repliesOpen = false
    $(element).text('ver respuestas')
    $(element).closest('.--comment-wrapper').find('.--comment-reply-wrapper').removeClass('active')

}



async function addAndAssignCommentsToCreatedEvent(tempCommentsData, empresa_id, event_id) {
    return $.ajax({
        type: "POST",
        url: 'ws/comments/comments.php',
        data: JSON.stringify({
            'action': 'addAndAssignCommentsToEvent',
            'empresa_id': empresa_id,
            'event_id': event_id,
            'temp_comments': tempCommentsData
        }),
        dataType: 'json',
        success: function (response) {
            // console.log('REPONSE COMENTARIOS', response)
        },
        error: function (error) {
            // console.log("ERROR addAndAssignCommentsToEvent", error.responseText);
        }
    });
}


function replyAssignedComment(assignedReplyData, empresa_id, event_id, commentId, post_user_id) {
    // return {
    //     'assignedReplyData':assignedReplyData,
    //     'empresa_id':empresa_id,
    //     'event_id':event_id,
    //     'commentId':commentId,
    //     'post_user_id': post_user_id
    // }

    return $.ajax({
        type: "POST",
        url: 'ws/comments/comments.php',
        data: JSON.stringify({
            'action': 'replyAssignedComment',
            'assignedReplyData': assignedReplyData,
            'empresa_id': empresa_id,
            'event_id': event_id,
            'commentId': commentId,
            'post_user_id': post_user_id
        }),
        dataType: 'json',
        success: function (response) {
            // console.log('REPONSE COMENTARIOS', response)
        },
        error: function (error) {
            // console.log("ERROR addAndAssignCommentsToEvent", error.responseText);
        }
    });



}

function openCommentMenu(element) {
    $(element).closest('.--user-name').find('.-comment-menu').addClass('active');
    $(element).closest('.--user-name').find('.-comment-menu').css('display', 'flex');
    commentMenuIsOpen = true;

}
function openReplyMenu(element) {

    $(element).closest('.--reply-comment-data-header').find('.-comment-menu').addClass('active');
    $(element).closest('.--reply-comment-data-header').find('.-comment-menu').css('display', 'flex');
    replyMenuIsOpen = true;

}


function closeAllCommentMenu(){
    $('.-comment-menu').removeClass('active');
    $('.-comment-menu').css('display','none');
    commentMenuIsOpen = false;
    replyMenuIsOpen = false;
    _canCloseCommentMenu = false;
    _canCloseReplyMenu = false;
}

let lastCommentText = '';
let lastEditedCommentWrapper = ''
function openEditComment(element) {
    $('#commentEdit').addClass('active');

    const COMMENT_TEXT = $(element).closest('.--coment-content').find('.--comment-textArea').val();
    lastCommentText = COMMENT_TEXT;
    lastEditedCommentWrapper = $(element).closest('.--comment-wrapper');
    $('#editCommentText').val(COMMENT_TEXT)
}
function closeEditSection() {
    $('#commentEdit').removeClass('active');
}


async function editComment() {

    const EDITED_COMMENT_TEXT = $('#editCommentText').val();


    if (EDITED_COMMENT_TEXT === '' || lastCommentText === undefined || lastCommentText === null) {
        $('#editCommentText').val(lastCommentText);
        closeEditSection();
        return;
    }

    const COMMENT_ID = $(lastEditedCommentWrapper).find('.comment-box').attr('comment_id');

    const UPDATE_COMMENT_REQUEST = {
        old_comment_text: lastCommentText,
        updated_comment_text: EDITED_COMMENT_TEXT,
        comment_id: COMMENT_ID,
        user_id: PERSONAL_IDS[0].usuario_id,
        empresa_id: EMPRESA_ID
    }

    const UPDATE_COMMENT_RESPONSE = await updateComment(UPDATE_COMMENT_REQUEST);

    if (UPDATE_COMMENT_RESPONSE.error) {
        return
    }
    $(lastEditedCommentWrapper).find('.--comment-textArea').val(EDITED_COMMENT_TEXT);
    closeEditSection();
}



async function deleteComment(element) {
    const COMMENT_ID = $(element).closest('.--comment-wrapper').find('.comment-box').attr('comment_id');
    
    const COMMENT_EXISTS = _assignedComments.find((comment) => {
        return comment.comment_id == COMMENT_ID;
    });

    if (!COMMENT_EXISTS) {
        return;
    }

    const DELETE_COMMENT_REQUEST = {
        comment_id: COMMENT_ID,
        user_id: PERSONAL_IDS[0].usuario_id,
        empresa_id: EMPRESA_ID
    }


    const DELETE_COMMENT_RESPONSE = await deleteComment_sd(DELETE_COMMENT_REQUEST);

    if (DELETE_COMMENT_RESPONSE.error) {
        return;
    }

    $(element).closest('.--comment-wrapper').remove();
}
async function deleteTempComment(element) {
    const TEMP_COMMENT_ID = $(element).closest('.--comment-wrapper').find('.comment-box').attr('temp_id');

    const TEMP_COMMENT_EXISTS = _tempCommentList.find((tempComment) => {
        return tempComment.temp_comment_id == TEMP_COMMENT_ID;
    });

    if (!TEMP_COMMENT_EXISTS) {
        return;
    }

    _tempCommentList.splice(_tempCommentList.indexOf(TEMP_COMMENT_EXISTS),1);
   
    $(element).closest('.--comment-wrapper').remove();
}





async function updateComment(requestUpdateComment) {
    return $.ajax({
        type: "POST",
        url: 'ws/comments/comments.php',
        data: JSON.stringify({
            'action': 'updateComment',
            'request': requestUpdateComment
        }),
        dataType: 'json',
        success: function (response) {
            console.log('REPONSE COMENTARIOS', response)
        },
        error: function (error) {
            console.log("ERROR addAndAssignCommentsToEvent", error.responseText);
        }
    });
}

function deleteComment_sd(requestDeleteComment) {
    return $.ajax({
        type: "POST",
        url: 'ws/comments/comments.php',
        data: JSON.stringify({
            'action': 'deleteComment',
            'request': requestDeleteComment
        }),
        dataType: 'json',
        success: function (response) {
            console.log('REPONSE COMENTARIOS', response)
        },
        error: function (error) {
            console.log("ERROR addAndAssignCommentsToEvent", error.responseText);
        }
    });
}