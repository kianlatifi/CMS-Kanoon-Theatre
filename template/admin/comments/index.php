<?php
require_once(realpath(dirname(__FILE__) . "/../layouts/head-tag.php"));
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h5 "><i class="fas fa-newspaper"></i> Comments</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a role="button" href="#" class="btn btn-sm btn-success disabled">create</a>
    </div>
</div>
<section class="table-responsive">
    <table class="table table-striped table-sm">
        <caption>List of comments</caption>
        <thead>
            <tr>
                <th>#</th>
                <th>user</th>
                <th>article</th>
                <th>comment</th>
                <th>status</th>
                <th>setting</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment) { ?>
                <tr> <?php $article = $db->select("SELECT `title` FROM `articles` WHERE id = ? ;",[$comment['article_id']])->fetch() ;
                    $user = $db->select("SELECT `username` FROM `users` WHERE id = ? ;",[$comment['user_id']])->fetch() ; ?>
                    <td><a href="http://localhost/comment/show/<?php echo $comment['id'] ?>"><?php echo $comment['id'] ?></a></td>
                    <td><?php echo $user['username'] ?></td>
                    <td><?php echo $article['title'] ?></td>
                    <td><?php echo $comment['comment'] ?></td>
                    <td><?php echo $comment['status'] ?></td>
                    <td>
                        <?php if ($comment['status'] == 'seen') { ?>
                            <a role="button" class="btn btn-sm btn-success text-white" href="http://localhost/comment/approved/<?php echo $comment['id'] ?>">click to approved</a>
                        <?php } else { ?>
                            <a role="button" class="btn btn-sm btn-warning text-white" href="http://localhost/comment/approved/<?php echo $comment['id'] ?>">click to not approved</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>
<?php
require_once(realpath(dirname(__FILE__) . "/../layouts/footer.php"));
?>