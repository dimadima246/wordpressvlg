<?php

list($url, $t) = explode('wp-content', $_SERVER['REQUEST_URI']);
$url .= 'wp-admin';

?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="<?=$url?>">&larr; Панель управления WordPress</a></li>
  </ol>
</nav>
