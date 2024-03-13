<div id="eventCommentsSideMenu" class="sideMenu-m" style="gap: 12px;">

    <button id="closeThismfMenu" style="border: none;background-color: none;padding: 30px;" onclick="closeEventComments()">
        <img src="./assets/svg/log-out.svg" alt="">
    </button>

    <div class=" hidden">
        <div class=" sideMenuTitle" style="align-items: center;align-content:center;margin-left: 14px;width: 100%;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <circle cx="6" cy="6" r="6" fill="#069B99" />
            </svg>
            <p class="header-P">Aquí puedes ver los comentarios del evento</p>
        </div>
    </div>

    <div class="-comment-section">
        <div class='addComment'>
            <div class="form-group " style="width: 100%;">
                <label for="postCommentArea">Publica un comentario</label>
                <textarea class="form-control" id="postCommentArea" name="txtAreaComments" rows="5" cols="5"></textarea>
            </div>
            <div class="commentAction">
                <img src="../../assets/svg/clip.svg" alt="right pointing arrow" id="postFileInComment">
                <img src="../../assets/svg/postComment.svg" alt="right pointing arrow" id="postComment">
            </div>
        </div>

        <div class="--comments-container">

            <!-- <div class="--comment-wrapper">
                <div class="comment-box">
                    <div class="comment-data">

                        <div class="--user-photo">

                            <div class="--user-photo-container">
                                <img src="../../assets/svg/default-user-photo.svg" alt="default user photo">
                            </div>
                        </div>
                        <div class="--coment-content">
                            <div class="--user-name">
                                <p class='comment-info-txt'>cote</p>
                                <img src="../../assets/svg/dots-horizontal-svgrepo-com.svg" alt="option dots" class="-comment-options" onclick="openCommentMenu(this)">
                                <div class="-comment-menu">
                                    <div class="comment-menu-option">
                                        <p>Eliminar</p>
                                    </div>
                                    <div class="comment-menu-option" onclick="openEditComment()">
                                        <p>Editar</p>
                                    </div>
                                </div>
                            </div>
                            <div class="--comment">
                                <textarea class="--comment-textArea" id="" cols="30" rows="10">asdlkajlsdkjalsdkj</textarea>
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
                    <div class="--reply-comment-data">
                        <div class="--reply-comment-data-header">
                            <div class="reply-com-user-data">
                                <div class="-rudata">
                                    <img src="../../assets/svg/default-user-photo.svg" alt="default user photo">
                                    <p> user Name</p>
                                    <p class="-comment-date-reply"> 2024-04-08</p>
                                </div>
                            </div>
                            <img src="../../assets/svg/dots-horizontal-svgrepo-com.svg" alt="option dots" class="-comment-options" onclick="openReplyMenu(this)">
                            <div class="-comment-menu">
                                <div class="comment-menu-option" onclick="deleteComment(this)">
                                    <p>Eliminar</p>
                                </div>
                                <div class="comment-menu-option" onclick="openEditComment(this)">
                                    <p>Editar</p>
                                </div>
                            </div>
                        </div>
                        <div class="reply-comment-text">
                            <textarea class="--reply-text_area" readonly> alskdjlaskjd lakj dlak jdsa</textarea>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>


    <div class="--replySection" id="replySection">
        <div class="--reply-header">
            <p>Repondiendo a: <span>Cote</span></p>
            <img class="closeReplieSection" src="../../assets/svg/cross-close-com.svg" alt="" onclick="closeReplieSection()">
        </div>
        <div class="--reply-body">
            <textarea class="--reply-text-area" id="replieText"></textarea>
            <div class="--reply-coment-action">
                <img src="../../assets/svg/postComment.svg" alt="right pointing arrow" id="postCommentReply" onclick="commentReplySelector()">
            </div>
        </div>
    </div>

    <div class="--replySection" id="commentEdit">
        <div class="--edit-header">
            <p>Editando comentario: <span>Cote</span></p>
            <img class="closeReplieSection" src="../../assets/svg/cross-close-com.svg" alt="" onclick="closeEditSection()">
        </div>
        <div class="--edit-body">
            <textarea class="--edit-text-area" id="editCommentText"></textarea>
            <div class="--edit-coment-action">
                <img src="../../assets/svg/postComment.svg" alt="right pointing arrow" id="postCommentReply" onclick="editComment()">
            </div>
        </div>
    </div>

</div>



<style>
    #postComment {
        cursor: pointer;
    }

    #postFileInComment {
        cursor: pointer;
    }

    .commentAction {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 24px 4px 16px;
    }
</style>