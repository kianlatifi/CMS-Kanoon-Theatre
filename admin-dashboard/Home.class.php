<?php
namespace AdminDashboard;

require_once(realpath(dirname(__FILE__) . "/DataBase.php"));

use DataBase\DataBase;

class Home
{
    public function index()
    {
        $db = new DataBase();
        $impArticles = $db->select("SELECT articles.*, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count, (SELECT username FROM users WHERE users.id = articles.user_id) AS username FROM articles WHERE `status` = 'important' ORDER BY `created_at` DESC LIMIT 0,6 ;")->fetchAll();
        $lastArticles = $db->select("SELECT articles.*, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count, (SELECT username FROM users WHERE users.id = articles.user_id) AS username FROM articles WHERE `status` != 'disable' ORDER BY `created_at` DESC LIMIT 0,6 ;")->fetchAll();
        $popularArticles = $db->select("SELECT articles.*, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count, (SELECT username FROM users WHERE users.id = articles.user_id) AS username FROM articles ORDER BY `view` DESC LIMIT 0,4 ;")->fetchAll();
        $sidebarPopularArticles = $popularArticles;
        $categories = $db->select("SELECT * FROM `categories` ORDER BY `id` DESC ;");
        $menus = $db->select("SELECT *, (SELECT COUNT(*) FROM `menus` AS `submenus` WHERE `submenus`.`parent_id` = `menus`.`id` ) AS `submenu_count` FROM `menus` WHERE `parent_id` IS NULL ;")->fetchAll();
        $submenus = $db->select("SELECT * FROM `menus` WHERE `parent_id` IS NOT NULL ;")->fetchAll();
        $setting = $db->select("SELECT * FROM `websetting`; ")->fetch();
        require_once(realpath(dirname(__FILE__) . "/../template/app/index.php"));
    }

    public function show($id)
    {
        $db = new DataBase();
        $setting = $db->select("SELECT * FROM `websetting`; ")->fetch();
        $article = $db->select("SELECT * FROM `articles` WHERE `id` = ? ;", [$id])->fetch();
        $username = $db->select("SELECT * FROM `users` WHERE `id` = ? ;", [$article['user_id']])->fetch();
        $commentsCount = $db->select("SELECT COUNT(*) FROM `comments` WHERE `article_id` = ?;", [$id])->fetch();
        $comments = $db->select("SELECT *, ( SELECT `username` FROM `users` WHERE `users`.`id` = `comments`.`user_id`) AS `username` FROM `comments` WHERE `article_id` = ? ORDER BY `created_at` DESC ;", [$id])->fetchAll();
        $db->update('articles', $id, ['view'], [$article['view'] + 1]);

        $popularArticles = $db->select("SELECT articles.*, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count, (SELECT username FROM users WHERE users.id = articles.user_id) AS username FROM articles ORDER BY `view` DESC LIMIT 0,4 ;")->fetchAll();
        $sidebarPopularArticles = $popularArticles;
        $categories = $db->select("SELECT * FROM `categories` ORDER BY `id` DESC ;", [$id]);
        $menus = $db->select("SELECT *, (SELECT COUNT(*) FROM `menus` AS `submenus` WHERE `submenus`.`parent_id` = `menus`.`id` ) AS `submenu_count` FROM `menus` WHERE `parent_id` IS NULL ;")->fetchAll();
        $submenus = $db->select("SELECT * FROM `menus` WHERE `parent_id` IS NOT NULL ;")->fetchAll();
        require_once(realpath(dirname(__FILE__) . "/../template/app/show-article.php"));
    }

    public function category($id)
    {
        $db = new DataBase();
        $category = $db->select("SELECT * FROM `categories` WHERE `id` = ? ;", [$id])->fetch();
        $articles = $db->select("SELECT articles.*, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count, (SELECT username FROM users WHERE users.id = articles.user_id) AS username FROM articles WHERE (articles.cat_id = ?) ;", [$id])->fetchAll();

        $setting = $db->select("SELECT * FROM `websetting`; ")->fetch();
        $popularArticles = $db->select("SELECT articles.*, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count, (SELECT username FROM users WHERE users.id = articles.user_id) AS username FROM articles ORDER BY `view` DESC LIMIT 0,4 ;")->fetchAll();
        $sidebarPopularArticles = $popularArticles;
        $categories = $db->select("SELECT * FROM `categories` ORDER BY `id` DESC ;", [$id]);
        $menus = $db->select("SELECT *, (SELECT COUNT(*) FROM `menus` AS `submenus` WHERE `submenus`.`parent_id` = `menus`.`id` ) AS `submenu_count` FROM `menus` WHERE `parent_id` IS NULL ;")->fetchAll();
        $submenus = $db->select("SELECT * FROM `menus` WHERE `parent_id` IS NOT NULL ;")->fetchAll();
        require_once(realpath(dirname(__FILE__) . "/../template/app/show-category.php"));

    }

    public function commentStore($request)
    {
        session_start();
        if(isset($_SESSION['user'])){
            if($_SESSION['user'] != null){
                $db= new DataBase();
                $db->insert('comments', ['user_id', 'article_id', 'comment'], [$_SESSION['user'], $request['article_id'], $request['comment']]);
                $this->redirectBack();
            }
            else
            $this->redirectBack();
        }
        else
        $this->redirectBack();
    }

    protected function redirectBack()
    {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
