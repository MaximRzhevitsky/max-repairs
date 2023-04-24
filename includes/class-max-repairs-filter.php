<?php
if ( ! class_exists( 'Max_repairs_filter' ) ) {


    class Max_repairs_filter
    {
        function get_repairs_by_id($data){
            $args = array(
                'post_type' => 'repairs',
                'post__in' => array( $data));
            $this->render_repairs($args);
        }

        function get_repairs_by_title($post_title) {
            $args = array(
                'post_type' => 'repairs',
                'title'=> $post_title,);
            $this->render_repairs($args);
        }

        function get_repairs_by_post_meta($key, $value)
        {
            $args = array(
                'post_type' => 'repairs',
                'meta_query' => array(
                    array('key' => $key,
                        'value' => $value,
                        'compare' => '=')));
            $this->render_repairs($args);
        }

        function get_repairs_by_date($after, $before)
        {
            $instance=new Newrepairs();
            $args = array(
                'post_type' => 'repairs',
                'meta_query' => array(
                    array('key' => 'ready',
                        'value' => 'on',
                        'compare' => '=')),
                'relation' => 'AND',
                'date_query' => array(
                    'after' => $after,
                    'before' => $before
                ),
                'orderby' => 'date');

            $repairs_by_date = new WP_Query($args);
            $count_posts = $repairs_by_date->post_count;
            $total_work_cost=0;
            $total_spare_cost=0;
            ?>
        <div class="col-lg-12 col-md-6 col-sm-12">
            <table class="table table-sm table-bordered table-order">
                <thead>
                <tr>
                    <th scope="col"><?php _e('Номер ремонту');?></th>
                    <th scope="col"><?php _e('Найменування');?></th>
                    <th scope="col"><?php _e('Запчастини');?></th>
                    <th scope="col"><?php _e('Вартість робіт');?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $date_filter = new WP_Query($args);
                if ( $date_filter->have_posts() ) :
                    while ( $date_filter->have_posts() ) :
                        $date_filter->the_post();
                        $count_posts = $date_filter->post_count; ?>
                         <tr>
        <td><?php the_title();?></td>
        <td>  <?php $instrument=get_post_meta( get_the_ID(), 'instrument_type' );
            echo $instance->uppercase($instrument[0]) ; ?></td>
        <td><?php $parts_mass = get_post_meta( get_the_ID(), 'repairs_parts_re_',true ) ;
            foreach ($parts_mass as $part): ?>
                <?php echo $part['repairs_parts_parts']?> &nbsp;-&nbsp;<?php echo $part['repairs_parts_parts_cost']?> &nbsp;<?php _e('грн'); echo '</br>'; ?>
                <?php $total_spare_cost += $part['repairs_parts_parts_cost'];
            endforeach; ?>
        </td>
        <td>
            <?php $works_mass = get_post_meta( get_the_ID(),'repairs_works_re_',true ) ;
            foreach ($works_mass as $work):?>
                <?php echo $work['repairs_works_works']?> &nbsp;-&nbsp;<?php echo $work['repairs_works_work_cost'];?> &nbsp;<?php _e('грн');
                $total_work_cost += $work['repairs_works_work_cost']; echo '</br>'; ?>
            <?php  endforeach; ?></td>
    </tr>
           <?php endwhile; endif;
                            ?>
        <tr>
            <td>
                <?php _e('Кількість ремонтів');?> &nbsp;-&nbsp;<?php echo $count_posts ; ?>
            </td>
            <td></td>
            <td>
                <?php _e('Витрати на запчастини');?> &nbsp;-&nbsp;<?php echo $total_spare_cost ; ?> &nbsp;<?php _e('грн'); ?>
            </td>
            <td> <?php _e('Загалом');?> &nbsp;-&nbsp;<?php echo $total_work_cost ; ?> &nbsp;<?php _e('грн'); ?></td>
        </tr>
                </tbody>
            </table>
        </div>
    <?php wp_reset_postdata();
        }

            public function render_repairs($args){
                $template=new Max_Repairs_Template_Loader();
                $listing_repairs = new WP_Query($args);
                if ( $listing_repairs->have_posts() ) :
                    while ( $listing_repairs->have_posts() ) :
                        $listing_repairs->the_post();
                        $template->get_template_part('content_repairs');
                    endwhile; endif;
                wp_reset_postdata();
            }
        }
    }