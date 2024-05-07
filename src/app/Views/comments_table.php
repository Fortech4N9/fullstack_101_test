<?php if (!empty($comments) && is_array($comments)): ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Email</th>
                <th>Comment</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?= esc($comment['user_email']); ?></td>
                    <td><?= esc($comment['comment_text']); ?></td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteComment(<?= esc($comment['id']); ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Page navigation example">
        <?= $pager->links(); ?>
    </nav>
<?php else: ?>
    <p>No comments found.</p>
<?php endif; ?>
<style>
    .pagination{
        gap: 10px;
    }
    .pagination li{
        text-align: center;
    }
    .pagination li a{
        padding: 5px 20px;
        color: white;
        background: #007bff;
        border-radius: 3px;
        text-decoration: none;
    }
</style>
