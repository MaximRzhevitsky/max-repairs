<?php
require MAX_REPAIRS_PLUGIN_DIR.'includes/meta-box-class/class-meta-boxes-templates.php';

if (is_admin()){

    $config_1 = array(
        'id'             => 'repairs_register_data',          // meta box id, unique per meta box
        'title'          => 'Рєестраційні данні',          // meta box title
        'pages'          => array('repairs'),      // post types, accept custom post types as well, default is array('post'); optional
        'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
        'priority'       => 'high',            // order of meta box: high (default), low; optional
        'fields'         => array(),            // list of meta fields (can be added by field arrays)
        'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
        'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
    );

    $repairs_meta_1 =  new AT_Meta_Box($config_1);
    $repairs_meta_1->addText('phone_customer',array('name'=> esc_html__('Телефон замовника','max_repairs')));
    $repairs_meta_1->addText('company',array('name'=> esc_html__('Фірма','max_repairs')));
    $repairs_meta_1->addText('instrument_type',array('name'=> esc_html__('Інструмент','max_repairs')));
    $repairs_meta_1->addTextarea('complaint',array('name'=> esc_html__('Скарга','max_repairs')));
    $repairs_meta_1->addCheckbox('repeat',array('name'=> 'Повтор '));
    $repairs_meta_1->addText('repeat_number',array('name'=> esc_html__('Попередній номер','max_repairs')));

    $repairs_meta_1->Finish();

    $prefix1 = 'repairs_works_';
    $config_2 = array(
        'id'             => 'works',          // meta box id, unique per meta box
        'title'          => 'Роботи',          // meta box title
        'pages'          => array('repairs'),      // post types, accept custom post types as well, default is array('post'); optional
        'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
        'priority'       => 'high',            // order of meta box: high (default), low; optional
        'fields'         => array(),            // list of meta fields (can be added by field arrays)
        'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
        'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
    );

    $repairs_meta_2 =  new AT_Meta_Box($config_2);
    //repeater block
    $repeater_fields_2[] = $repairs_meta_2->addTextarea($prefix1.'works',array('name'=> 'Найменування робіт'),true);
    $repeater_fields_2[] = $repairs_meta_2->addText($prefix1.'work_cost',array('name'=> 'Вартість робіт '),true);
    //   $repeater_fields[] = $repairs_meta2->addImage($prefix.'image_field_id',array('name'=> 'My Image '),true);

    $repairs_meta_2->addRepeaterBlock($prefix1.'re_',array(
        'inline'   => true,
        'name'     => 'Роботи',
        'fields'   => $repeater_fields_2,
        'sortable' => true
    ));

    $repairs_meta_2->Finish();

    $prefix2 = 'repairs_parts_';
    $config_3 = array(
        'id'             => 'parts',          // meta box id, unique per meta box
        'title'          => 'Запчастини',          // meta box title
        'pages'          => array('repairs'),      // post types, accept custom post types as well, default is array('post'); optional
        'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
        'priority'       => 'high',            // order of meta box: high (default), low; optional
        'fields'         => array(),            // list of meta fields (can be added by field arrays)
        'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
        'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
    );

    $repairs_meta_3 =  new AT_Meta_Box($config_3);
    //repeater block
    $repeater_fields_3[] = $repairs_meta_3->addText($prefix2.'parts',array('name'=> 'Запчастини'),true);
    $repeater_fields_3[] = $repairs_meta_3->addText($prefix2.'parts_cost',array('name'=> 'Вартість запчастини '),true);

    $repairs_meta_3->addRepeaterBlock($prefix2.'re_',array(
        'inline'   => true,
        'name'     => 'Запчастини',
        'fields'   => $repeater_fields_3,
        'sortable' => true
    ));

    $repairs_meta_3->Finish();

    $config_4 = array(
        'id'             => 'repairs_status',          // meta box id, unique per meta box
        'title'          => 'Виконання робіт',          // meta box title
        'pages'          => array('repairs'),      // post types, accept custom post types as well, default is array('post'); optional
        'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
        'priority'       => 'high',            // order of meta box: high (default), low; optional
        'fields'         => array(),            // list of meta fields (can be added by field arrays)
        'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
        'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
    );

    $repairs_meta_4 =  new AT_Meta_Box($config_4);

    $repairs_meta_4->addCheckbox('agreement',array('name'=> 'Узгоджено '));
    $repairs_meta_4->addCheckbox('ready',array('name'=> 'Виконано '));
    $repairs_meta_4->addCheckbox('given',array('name'=> 'Видано '));

    $repairs_meta_4->addImage('repairs_image',array('name'=> 'Фото '));

    $repairs_meta_4->Finish();
}