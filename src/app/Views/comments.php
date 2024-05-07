<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Комментарии</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Комментарии</h2>
    <div id="comment_form" class="mb-3">
        <input type="email" id="author" placeholder="Ваша почта" class="form-control mb-2">
        <textarea id="message" placeholder="Ваш комментарий" class="form-control mb-2"></textarea>
        <button onclick="addComment()" class="btn btn-primary">Добавить комментарий</button>
    </div>
    <div id="comments_table">

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    fetchComments();

    function activatePagination() {
        let clear;
        const handler = event => {
            event.preventDefault();
            clear();
            fetchComments(event.currentTarget.href);
        };
        const anchors = Array.from(document.querySelectorAll('.pagination a'));
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
                activatePagination();
            }
        });
        fetchComments.abort = () => xhr.abort();
    };

    function addComment() {
        let author = $('#author').val();
        let message = $('#message').val();

        $.ajax({
            url: '/home/create',
            method: 'POST',
            data: {user_email: author, comment_text: message},
            success: function (response) {
                fetchComments();
            }
        });
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