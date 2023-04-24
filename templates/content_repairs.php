<?php $instance=new Newrepairs(); ?>

<div class="entry-meta">
    <header class="entry-header">
        <h5 class="entry-title"><?php _e('Акт виконаних робіт'); ?>&nbsp;№&nbsp;<?php the_title();?>
        </h5>
    </header>
    <div class="entry-content-left col-lg-12 col-md-12">
        <p><?php _e('Інструмент:');?>&nbsp;
            <?php $instrument=get_post_meta( get_the_ID(), 'instrument_type' );
            echo $instance->uppercase($instrument[0]) ?>
        </p>
        <p><?php _e('Замовник:');?>&nbsp;
            <?php $company = get_post_meta(get_the_ID(), 'company');
                  $phone= get_post_meta( get_the_ID(), 'phone_customer');
            if($company[0]!="") : echo $instance->uppercase($company[0]);
            else: echo $instance->uppercase($phone[0]);  endif;?>
        </p>
        <?php
        $parts_mass = get_post_meta( get_the_ID(), 'repairs_parts_re_',true ) ;
        $works_mass = get_post_meta( get_the_ID(),'repairs_works_re_',true ) ;

        if($works_mass || $parts_mass):
        $total_works_cost=0;
        $total_parts_cost=0;
        $total_repairs_cost=0;
        ?>

    <?php if($works_mass): ?>
        <div class="col-md-4 col-sm-12 <?php if($parts_mass): echo ' left'; endif;?>">
            <table class="act_form table table-bordered">
                <thead>
                <tr>
                    <th class="col_name" scope="col"><?php _e('Найменуванн яробіт (послуги)');?></th>
                    <th class="col_value" scope="col"><?php _e('Вартість');?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($works_mass as $work):?>
                <tr>
                <td>
                    <?php echo $instance->uppercase($work['repairs_works_works']); ?>
                </td>
               <td>
                   <?php echo $work['repairs_works_work_cost'];?> &nbsp;<?php _e('грн');
                   $total_works_cost += intval($work['repairs_works_work_cost']); echo '</br>'; ?>
               </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    <?php if($parts_mass): ?>

    <div class="col-md-4 col-sm-12 <?php if($works_mass): echo ' right'; endif;?>">
        <table class="act_form table table-bordered">
            <thead>
            <tr>
                <th class="col_name" scope="col"><?php _e('Запчастини');?></th>
                <th class="col_value" scope="col"><?php _e('Вартість');?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($parts_mass as $part):?>
            <tr>
                <td>
                    <?php echo $instance->uppercase($part['repairs_parts_parts']); ?>
                </td>
                <td>
                    <?php echo $part['repairs_parts_parts_cost'];?> &nbsp;<?php _e('грн');
                    $total_parts_cost += intval($part['repairs_parts_parts_cost']); echo '</br>'; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
    <?php endif; ?>
    <div class="total col-4">
        <?php $total_repairs_cost=$total_works_cost+$total_parts_cost;  ?>
        <table><tr><td> <?php _e('Загалом');?>&nbsp;&nbsp;&nbsp;<?php echo $total_repairs_cost; ?> &nbsp;<?php _e('грн'); ?></td></tr></table>
    </div>
    <?php endif;?>
    <?php
    if(has_post_thumbnail()):?>
        <div class="thumbnail-repairs">
            <p><?php _e('Доданє фото');?></p>
            <figure class="post-thumbnail">
                <?php
                the_post_thumbnail( 'medium',array('class'=>'img-fluid','alt'=>'blog-image'));?>
            </figure>
        </div>
    <?php endif;?>
</div>
</br></br></br>

</br></br></br>