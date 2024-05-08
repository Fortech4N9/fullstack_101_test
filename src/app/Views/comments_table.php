<?php if (!empty($comments) && is_array($comments)): ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <?php foreach (array_keys($comments[0]) as $key):?>
                    <?php if ($key === 'id'):?>
                        <th class="sort_column">
                            <span><?= $key ?></span>
                            <button class="sort_btn" onclick="sortByIdAsc()">asc</button>
                            <button class="sort_btn" onclick="sortByIdDesc()">desc</button>
                        </th>
                    <?php elseif ($key === 'created_at'):?>
                        <th class="sort_column">
                            <span><?= $key ?></span>
                            <button class="sort_btn" onclick="sortByDateAsc()">asc</button>
                            <button class="sort_btn" onclick="sortByIdDesc()">desc</button>
                        </th>
                    <?php else:?>
                        <th><?= $key ?></th>
                    <?php endif;?>
                <?php endforeach;?>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?= esc($comment['id']); ?></td>
                    <td><?= esc($comment['user_email']); ?></td>
                    <td><?= esc($comment['comment_text']); ?></td>
                    <td><?= esc($comment['created_at']); ?></td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteComment(<?= esc($comment['id']); ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Page navigation">
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
        font-size: calc(0.35em + 0.5vw);
    }
    
    .table{
        font-size: calc(0.35em + 0.5vw);
    }
    
    .btn{
        font-size: calc(0.35em + 0.5vw);
    }
    
    .table thead th{
        vertical-align: center;
    }
    
    .pagination li a{
        padding: 5px 20px;
        color: white;
        background: #007bff;
        border-radius: 3px;
        text-decoration: none;
    }
    
    .sort_column{
        display: flex;
        gap: 5px;
    }
    .sort_column span{
        margin: auto;
    }
    
    .sort_btn{
        padding: 5px;
        background: #007bff;
        border-color: #007bff;
        border-radius: 5px;
        color: white;
    }
    
    .sort_btn:hover{
        background-color: #009bff;
    }
</style>
<script>
    function sortByIdAsc() {
        let container = $('table tbody');
        let items = $('tr', container);
        items.sort(function (a, b) {
            return a.children[0].innerHTML - b.children[0].innerHTML;
        })
        items.detach().appendTo(container);
    }
    function sortByIdDesc() {
        let container = $('table tbody');
        let items = $('tr', container);
        items.sort(function (a, b) {
            return b.children[0].innerHTML - a.children[0].innerHTML;
        })
        items.detach().appendTo(container);
    }
    function sortByDateAsc() {
        let container = $('table tbody');
        let items = $('tr', container);
        items.sort(function (a, b) {
            let dateA = new Date(a.children[3].innerHTML);
            let dateB = new Date(b.children[3].innerHTML);

            return dateA.getTime() - dateB.getTime();
        })
        items.detach().appendTo(container);
    }
    function sortByDateDesc() {
        let container = $('table tbody');
        let items = $('tr', container);
        items.sort(function (a, b) {
            let dateA = new Date(a.children[3].innerHTML);
            let dateB = new Date(b.children[3].innerHTML);

            return dateB.getTime() - dateA.getTime();
        })
        items.detach().appendTo(container);
    }
</script>
