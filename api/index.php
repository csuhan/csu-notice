<?php
header("Access-Control-Allow-Origin: *");
require 'CSUNotice.php';
$notice = new \CSUNotice();

if(isset( $_GET['cn-lists']))
{
$json = $notice->get_lists($_GET['cn-lists']);
echo $json;
}

if(isset( $_GET['cn-article']))
{
    $json = $notice->get_article($_GET['cn-article']);
    echo $json;

}

if(isset($_GET['cn-lists-search']) && isset($_GET['cn-lists-search-page']))
{
    $json = $notice->get_lists($_GET['cn-lists-search-page'],$_GET['cn-lists-search']);
    echo $json;
}
