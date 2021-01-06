<div class="tabs clearfix" id="tabs">

<ul class="tab-nav clearfix" id="" >
  <li class="">
    <a  href="#base" role="tab" >Настройки</a>
  </li>
  <li class="">
    <a  href="#pages" role="tab"  >Страницы</a>
  </li>
  <li class="">
    <a href="#css" role="tab"  >CSS</a>
  </li>
  <li class="">
    <a href="#html" role="tab"  >HTML</a>
  </li>
</ul>
<form action="" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=THEME_ID?>" />
<div class="tab-container " id="myTabContent">
  <div class="tab-content " id="base" ><?php include($_APP['folder'].'/html/base.php'); ?></div>
  <div class="tab-content " id="pages" ><?php include($_APP['folder'].'/html/pages.php'); ?></div>
  <div class="tab-content " id="css" ><?php include($_APP['folder'].'/html/css.php'); ?></div>
  <div class="tab-content " id="html" ><?php include($_APP['folder'].'/html/html.php'); ?></div>
</div>

<hr>

<button class="btn btn-primary" type="submit">Сохранить</button>

<?php

list($url, $t) = explode('wp-content', $_SERVER['REQUEST_URI']);

?>
<a class="btn btn-link" href="<?=$url?>" target="_blank">Просмотр сайта</a>

</form>  

</div>
