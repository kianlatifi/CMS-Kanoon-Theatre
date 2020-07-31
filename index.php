<?php
require_once ("admin-dashboard/Category.class.php");
require_once ("admin-dashboard/Article.class.php");
require_once ("admin-dashboard/Menu.class.php");
require_once ("admin-dashboard/CreateDB.php");
require_once ("admin-dashboard/WebSetting.class.php");
require_once ("admin-dashboard/User.class.php");
require_once ("admin-dashboard/Auth.class.php");
require_once ("admin-dashboard/Home.class.php");
require_once ("admin-dashboard/Comment.class.php");
require_once ("admin-dashboard/Dashboard.class.php");

use DataBase\CreateDB;
use AdminDashboard\Category;
use AdminDashboard\Article;
use AdminDashboard\Menu;
use AdminDashboard\WebSetting;
use AdminDashboard\User;
use AdminDashboard\Auth;
use AdminDashboard\Home;
use AdminDashboard\Comment;
use AdminDashboard\Dashboard;
// $createDB = new CreateDB();
// $createDB->run();

$domein = "/localhost";

function uri($uri,$class,$method,$requestMethod='GET'){
    $values=array();
    $subURIs=explode('/',$uri);
    $request_uri=$_SERVER['REQUEST_URI'];
    $request_uri=array_slice(explode('/',$_SERVER['REQUEST_URI']),1);
    if(sizeof($request_uri) != 1){
        $request_uri=array_filter($request_uri);
    }
    if ($request_uri[0]=="" or $request_uri[0]=="/")
        $request_uri[0] = "home";

    $breakk=false;
    if(sizeof($request_uri)==sizeof($subURIs) and $_SERVER['REQUEST_METHOD'] == $requestMethod){
        foreach (array_combine($subURIs,$request_uri) as $subURI => $request){
            if ($subURI[0]=="{" and $subURI[strlen($subURI) - 1] == "}"){
                array_push($values,$request);
            }
            else {
                if ($subURI != $request){
                    $breakk=true;
                    break;
                }
            }
        }
    }
    else $breakk=true;

    if(!$breakk){
        $class = "AdminDashboard\\".$class;
        $object= new $class;
        if(sizeof($values) > 0)
            if($requestMethod == 'POST')
                if (isset($_FILES)){
                    $request = array_merge($_POST,$_FILES);
                    $object->$method($request,implode(',',$values));
                }
                else
                    $object->$method($_POST,$request,implode(',',$values));
            else
                $object->$method(implode(',',$values));
        else
            if ($requestMethod=='POST')
                if (isset($_FILES)){
                    $request = array_merge($_POST,$_FILES);
                    $object->$method($request);
                }
                else 
                    $object -> $method($_POST);
            else
                $object->$method();

    }
    else {

    }



}














// dashboard
uri('admin','Dashboard','index');

// category
uri('category','Category','index');
uri('category/show/{id}','Category','show');
uri('category/create','Category','create');
uri('category/store','Category','store','POST');
uri('category/edit/{id}','Category','edit');
uri('category/update/{id}','Category','update','POST');
uri('category/delete/{id}','Category','delete');

// article
uri('article','Article','index');
uri('article/show/{id}','Article','show');
uri('article/create','Article','create');
uri('article/store','Article','store','POST');
uri('article/edit/{id}','Article','edit');
uri('article/update/{id}','Article','update','POST');
uri('article/delete/{id}','Article','delete');
uri('article/status/{id}','Article','status');
uri('article/important/{id}','Article','important');

// menu
uri('menu','Menu','index');
uri('menu/show/{id}','Menu','show');
uri('menu/create','Menu','create');
uri('menu/store','Menu','store','POST');
uri('menu/edit/{id}','Menu','edit');
uri('menu/update/{id}','Menu','update','POST');
uri('menu/delete/{id}','Menu','delete');

// user
uri('user','User','index');
uri('user/permission/{id}','User','permission');
uri('user/edit/{id}','User','edit');
uri('user/update/{id}','User','update','POST');
uri('user/delete/{id}','User','delete');

// web setting
uri('web-setting','WebSetting','index');
uri('web-setting/set','WebSetting','set');
uri('web-setting/store','WebSetting','store','POST');

// comments
uri('comment','Comment','index');
uri('comment/show/{id}','Comment','show');
uri('comment/approved/{id}','Comment','approved');
uri('comment/delete/{id}','Comment','delete');

// auth
uri('login','Auth','login');
uri('check-login','Auth','checkLogin','POST');
uri('register','Auth','register');
uri('register/store','Auth','registerStore','POST');
uri('log-out','Auth','logout');

// home
uri('home','Home','index');
uri('show-article/{id}','Home','show');
uri('show-category/{id}','Home','category');
uri('comment-store','Home','commentStore','POST');




