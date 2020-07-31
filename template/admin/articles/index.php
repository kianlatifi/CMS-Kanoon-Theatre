<?php
require_once(realpath(dirname(__FILE__) . "/../layouts/head-tag.php"));
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h5 "><i class="fas fa-newspaper"></i> Articles</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a role="button" href="http://localhost/article/create" class="btn btn-sm btn-success">create</a>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <caption>List of articles</caption>
        <thead>
            <tr>
                <th>#</th>
                <th>title</th>
                <th>summary</th>
                <th>view</th>
                <th>comments</th>
                <th>author</th>
                <th>category</th>
                <th>image</th>
                <th>setting</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article) { ?>
                <tr> <?php $category = $db->select("SELECT * FROM `categories` WHERE `id` = ? ;", [$article['cat_id']])->fetch(); ?>
                    <td><a class="text-primary" href="http://localhost/article/show/<?php echo $article['id'];?>">
                    <?php echo $article['id'] ?></a></td>
                    <td><?php echo $article['title'] ?></td>
                    <td><?php echo $article['summary'] ?></td>
                    <td><?php echo $article['view'] ?></td>
                    <td><?php echo $article['comments_count'] ?></td>
                    <td><?php echo $article['username'] ?></td>
                    <td><?php echo $category['name'] ?></td>
                    <td><img style="width: 80px;" src="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/' . $article['image']; ?>" alt=""></td>
                    <td>
                        <a role="button" class="btn btn-sm btn-primary text-white" href="http://localhost/article/edit/<?php echo $article['id']; ?>">edit</a>
                        <a role="button" class="btn btn-sm btn-danger text-white" href="http://localhost/article/delete/<?php echo $article['id']; ?>">delete</a>
                        <?php if ($article['status'] == 'disable') { ?>
                            <a role="button" class="btn btn-sm btn-success text-white" href="http://localhost/article/status/<?php echo $article['id']; ?>">enable</a>
                        <?php } else { ?>
                            <a role="button" class="btn btn-sm btn-warning text-white" href="http://localhost/article/status/<?php echo $article['id']; ?>">disable</a>
                            <?php if($article['status'] == 'important') { ?>
                            <a role="button" class="btn btn-sm btn-light" href="http://localhost/article/important/<?php echo $article['id']; ?>">not important</a>
                            <?php } else { ?>
                                <a role="button" class="btn btn-sm btn-dark text-white" href="http://localhost/article/important/<?php echo $article['id']; ?>">important</a>
                            <?php } ?>
                        <?php } ?>
                    </td>
                </tr> <?php } ?>
        </tbody>

    </table>
</div>



<?php
require_once(realpath(dirname(__FILE__) . "/../layouts/footer.php"));
?>