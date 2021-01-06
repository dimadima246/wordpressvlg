<div class="section   nopadding" style="
 
margin-top:unset;
margin-bottom:unset;
">
    <div class="" style="background-color: rgba(0, 0, 0, 0);
padding-top:60px;
padding-bottom:60px;
    ">  
        <div class="container clearfix">
        
<div class="heading-block divcenter center" style="max-width: 600px">
<h2 class="notransform t600 mb-2 editable block_133354 item-option_233723 field_title" style="">Новости</h2>
</div>


<div id="posts" class="post-grid grid-container grid-3 clearfix" data-layout="fitRows">

<?php query_posts('showposts=3');  if ( have_posts() ) : while ( have_posts() ) : the_post(); $post_link = esc_url( get_permalink() ); ?>

	<div class="entry clearfix nobottommargin ">
	    
		<?php if(has_post_thumbnail()) { ?>
		<div class="entry-image">
			<a href="<?=$post_link ?>"><img class="image_fade" src="<?php the_post_thumbnail_url()?>"></a>
		</div>
		<?php } ?>
		
		<div class="entry-title">
			<h3><a href="<?=$post_link ?>"><?php the_title(); ?></a></h3>
		</div>
		<ul class="entry-meta clearfix">
			<li><i class="icon-calendar3"></i> <?=get_the_date('d.m.Y');?></li>
		</ul>
		<div class="entry-content">
			<p class="t300"><?php the_excerpt(); ?></p>
			<a href="<?=$post_link ?>" class="more-link">Читать далее...</a>
		</div>
	</div>
<?php endwhile; ?>
<?php else: ?>
<?php endif; ?>  

</div>    
        </div>
    </div>
</div>    
