<div class="item">


<div class="js_shop shop-item shop">
<div class="foto">

     <?php $img = get_field('card_img');
	   //echo '<pre>'; print_r($img); echo '</pre>';  ?>

<a href="<?=esc_url( get_permalink() )?>" >
<img src="<?=$img['url']?>" width="220" height="220" class="js_shop_img">
</a>
 </div>
<div class="overflow">
<div class="coll-1">
<p class="name">
<?php the_title( '<a class="shop-item-title" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>'); ?>

</p>
<div class="prepertys">
<?php the_field('card_table'); ?>

</div>
</div>
<div class="coll-2">
<p class="price" >
<?php $price = get_field('card_price'); echo numWithSpaces($price); ?> <span class="rub">
руб.</span>
</p>
<p class="smena">
за смену, без НДС:</p>
<p class="price2">
<?=numWithSpaces($price*1.18)?> <span class="rub">
руб.</span>
</p>
<p class="smena">
за смену, с НДС</p>

<div class="pts">
</div>

 <a href="<?=get_permalink()?>" class="red_button contact_me_but" id="contact_me_but">
подробнее</a>


</div>

</div>
<div class="clear">
</div>
</div>


     </div>