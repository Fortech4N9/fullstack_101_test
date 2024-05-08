<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Комментарии</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<style>
    .invalid-email {
        border-color: red;
        background-color: #E06E3F;
    }
</style>
<div class="container mt-5">
    <h2>Комментарии</h2>
    <div id="comment_form" class="mb-3">
        <input type="email" id="author" placeholder="Ваша почта" onclick="removeInvalid()" class="form-control mb-2">
        <textarea id="message" placeholder="Ваш комментарий" class="form-control mb-2"></textarea>
        <button onclick="addComment()" class="btn btn-primary">Добавить комментарий</button>
    </div>
    <div id="comments_table">
    
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    fetchComments();
    
    function removeInvalid() {
        let author = $('#author');
        author.removeClass('invalid-email');
    }
    
    function validateEmail(email) {
        let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\\.,;:\s@"]+\.)+[^<>()[\]\\.,;:\s@"]{2,})$/i;
        return re.test(String(email).toLowerCase());
    }
    
    function activateListeners(selector) {
        let clear;
        const handler = event => {
            event.preventDefault();
            clear();
            fetchComments(event.currentTarget.href);
        };
        const anchors = Array.from(document.querySelectorAll(selector));
        anchors.forEach(a => a.addEventListener('click', handler));
        clear = () => anchors.map(a => a.removeEventListener('click', handler));
    }
    
    function fetchComments(pageLink = '/home/fetch') {
        fetchComments.abort?.();
        const xhr = $.ajax({
            url: pageLink,
            method: 'GET',
            success: function (response) {
                $('#comments_table').html(response);
                activateListeners('.pagination a');
            }
        });
        fetchComments.abort = () => xhr.abort();
    };

    function addComment() {
        let author = $('#author');
        let message = $('#message');
        
        if (validateEmail(author.val())) {
            $.ajax({
                url: '/home/create',
                method: 'POST',
                data: {user_email: author.val(), comment_text: message.val()},
                success: function (response) {
                    fetchComments();
                }
            });
        } else {
            author.addClass('invalid-email');
        }
    }

    function deleteComment(id) {
        $.ajax({
            url: '/home/delete/' + id,
            method: 'GET',
            success: function (response) {
                fetchComments();
            }
        });
    }
</script>
</body>
</html>