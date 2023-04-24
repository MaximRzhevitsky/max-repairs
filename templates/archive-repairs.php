<?php get_header();

    if($_POST['id']!== null || $_POST['title']!== null || $_POST['phone_customer']!== null || $_POST['company']!== null || $_POST['date_start']!== null && $_POST['date_finish'] !== null) :
        $instance=new Max_repairs_filter();

    if($_POST['id']!== null): $data=intval($_POST['id']);
    $instance->get_repairs_by_id($data); endif;

    if($_POST['title']!== null): $repeat_title=intval($_POST['title']);
    $instance->get_repairs_by_title($repeat_title);
    endif;

    if($_POST['phone_customer']!== null): $phone=($_POST['phone_customer']);
    $instance->get_repairs_by_post_meta('phone_customer',$phone); endif;

    if($_POST['company']!== null): $company=($_POST['company']);
    $instance->get_repairs_by_post_meta('company',$company); endif;

    if($_POST['date_start']!== null && $_POST['date_finish'] !== null):
    $after = $_POST['date_start'];
    $before = $_POST['date_finish'];
    $instance->get_repairs_by_date($after,$before);
    endif;
    else:
?>

<section class="page-section-space blog bg-default" id="content">
<!--        --><?php //if ( is_user_logged_in() ) : ?>
    <div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-4 left-search">
            <div class="q-search">
                <div class="q-search-wrap">
                    <form method="POST" action="<?php echo home_url("/repairs"); ?>">
                        <label><?php _e('Введіть номер телефону'); ?></label>
                        <input id="phone_customer" name="phone_customer">
                        <button type="submit" class="btn btn-yellow"><?php _e('Шукати'); ?></button></br></br>
                    </form>
                </div>
            </div>

            <div class="q-search">
                <div class="q-search-wrap">
                    <form method="POST" action="<?php echo home_url("/repairs"); ?>">
                        <label><?php _e('Введіть назву компанії'); ?></label>
                        <input id="company_customer" name="company">
                        <button type="submit" class="btn btn-yellow"><?php _e('Шукати'); ?></button></br></br>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-4 col-md-4 right-search">
            <div class="row">
                <div class="col-sm-4">
                    <form method="POST" action="<?php echo home_url("/repairs"); ?>">
                        <div class="input-group">
                            <div class="input-group-addon"><?php _e('від'); ?>&nbsp;</div>
                            <input type="date" class="form-control" name="date_start">
                        </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon"><?php _e('по'); ?>&nbsp;</div>
                        <input type="date" class="form-control" name="date_finish">
                    </div>
                </div>
                <input type="submit" value="<?php _e('Звіт'); ?>">
                </form>
            </div>
        </div>

    </div>
    </br></br></br></br></br></br></br></br>

    <p class="out"></p>
    <table id="table" width="100%">
        <thead>
        <tr role="row">
            <th>link</th>
            <th><?php _e('Дата'); ?></th>
            <th><?php _e('Номер'); ?></th>
            <th><?php _e('Телефон'); ?></th>
            <th><?php _e('Фірма'); ?></th>
            <th><?php _e('Інструмент'); ?></th>
            <th><?php _e('Скарга'); ?></th>
            <th><?php _e('Повтор'); ?></th>
            <th><?php _e('Узгоджено'); ?></th>
            <th><?php _e('Виконано'); ?></th>
            <th><?php _e('Видано'); ?></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

<?php
//else: ?>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="q-search">
                    <div class="q-search-wrap">
                        <form method="POST" action="<?php echo home_url("/repairs"); ?>">
                            <label><?php _e('Введіть номер телефону'); ?></label>
                            <input id="phone_customer" name="phone_customer">
                            <button type="submit" class="btn btn-yellow"><?php _e('Шукати'); ?></button></br></br>
                        </form>
                    </div>
                    <div class="q-search">
                        <div class="q-search-wrap">
                            <form method="POST" action="<?php echo home_url("/repairs"); ?>">
                                <label><?php _e('Введіть назву компанії'); ?></label>
                                <input id="company_customer" name="company">
                                <button type="submit" class="btn btn-yellow"><?php _e('Шукати'); ?></button></br></br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
    </div>
    </section>
<?php
//endif;
get_footer();
?>