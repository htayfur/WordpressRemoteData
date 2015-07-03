<?php

/**
 * Plugin Name: Wordpress Remote Data
 * Plugin URI: https://github.com/kobrafightertr/WordpressRemoteData
 * Description: Wordpress Remote Data
 * Version: 1.0
 * Author: Hakan Tayfur
 * Author URI: http://kodbara.com
 * License: Please see License https://github.com/kobrafightertr/WordpressRemoteData/blob/master/LICENSE . Bu proje Kodbara http://kodbara.com) tarafından halka açık olarak geliştirilmiştir.
 */


require_once "../../../wp-load.php";

$password = "Sifre"; // change password value // şifreyi değiştirin

$getdata = $_POST['data'];
$getpassword = $_POST['password'];

if($password == $getpassword){
    $title = $getdata['title'];
    $keywords = $getdata['keywords'];
    $content = $getdata['content'];
    $category = $getdata['category'];
    $status = $getdata['status'];
    $author = $getdata['author'];

    if($category == NULL){
        $category = 1; // If the category is not defined, set as 1. // Eğer kategorisi yok ise 1 numaralı kategoriye tanımlanır.
    }
    if($status == NULL){
        $status = "draft"; // If the status is not defined, set as draft. // Eğer durum yoksa taslak olarak ekler
    }
    if($author == NULL){
        $author = 1; // If the user is not defined, set as 1. // Eğer kullanıcı tanımlı değilse 1 numaralı kullanıcıya ekler.
    }

    // Let's prepare the string. // Yazı dizisini hazırlayalım.

    $post = array(
        'post_title' => $title,
        'post_content' => $content,
        'post_status' => $status,
        'post_author' => $author,
        'tags_input' => $keywords,
        'post_category' => array($category) // Categories must be in sequence. // Kategori dizi içerisinde olmalı.
    );

    global $wbdb; // Wordpress database variable // Wordpress veritabanı değişkeni

    $exists = $wpdb->get_var("SELECT COUNT( * ) FROM $wpdb->posts WHERE `post_title` = '$title'");
    if (empty($exists)) {
        $addcontent = wp_insert_post($post, $wp_error);
        if ($addcontent) {
            echo 'EN:Post was added successfully. TR:Yazı başarıyla eklendi! <br />';
        } else {
            echo 'EN: There was a problem when adding post. TR: Yazı eklenirken bir problem oluştu! :<br />' . $wp_error;
        }
    } else {
        echo 'EN: Post already been added. TR: Yazı zaten eklenmiş.';
    }


}

?>