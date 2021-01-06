<div class="section nobg  nopadding" style="
 
margin-top:unset;
margin-bottom:unset;
">
    <div class="" style="background-color: rgba(0, 0, 0, 0);
padding-top:60px;
padding-bottom:60px;
    ">  
        <div class="container clearfix">
        
<div class="text-muted bottommargin-sm"><?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?></div>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
$post_link = esc_url( get_permalink() ); ?>


<div class="heading-block ">
	<h1><?php the_title(); ?></h1>
	
</div>


<div class="t300">
<?php the_content(); ?>    
</div>
<?php endwhile; ?>

<?php else: ?>
Не найдено
<?php endif; ?>

    
        </div>
    </div>
</div>    
