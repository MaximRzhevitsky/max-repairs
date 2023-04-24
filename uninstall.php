<?php

if(!defined('WP_UNINSTALL_PLUGIN')){
    die;
}

//delete posts

$repairs=get_posts(array('post_type'=>'repairs','numberposts'=>-1));
foreach ($repairs as $repair){
    wp_delete_post($repair->ID,true);
}