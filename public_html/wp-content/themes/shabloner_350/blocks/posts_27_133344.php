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

<div class="heading-block ">
	<h1><?=wp_title('')?></h1>
</div>

<div id="posts" class="small-thumbs">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
$post_link = esc_url( get_permalink() ); ?>
    
    <div class="entry clearfix">
		<?php if(has_post_thumbnail()) { ?>
		<div class="entry-image">
			<a href="<?=$post_link ?>"><img class="image_fade" src="<?php the_post_thumbnail_url()?>"></a>
		</div>
		<?php } ?>

    	<div class="entry-c">
    		<div class="entry-title">
    			<h3><a href="<?=$post_link ?>"><?php the_title(); ?></a></h3>
    		</div>
    		<ul class="entry-meta clearfix">
    			<li><i class="icon-calendar3"></i> <?=get_the_date('d.m.Y');?></li>
    		</ul>
    		<div class="entry-content">
    			<p class="t400"><?php the_excerpt(); ?></p>
    			<a href="<?=$post_link ?>" class="more-link">Читать далее...</a>
    		</div>
    	</div>
    </div>
<?php endwhile; ?>

<?php else: ?>
Не найдено
<?php endif; ?>
    
</div>

<?php the_posts_pagination(); ?>
    
        </div>
    </div>
</div>    
