
<?php
$breads_count = count($_BREAD);
if($breads_count) { ?> 
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
	<?php foreach($_BREAD as $int => $item) {
	if($breads_count > $int+1) { ?>
	<li class="breadcrumb-item"><a href="<?=$item[0]?>"><?=$item[1]?></a></li>
	<?php } else { ?>
    <li class="breadcrumb-item active" aria-current="page"><?=$item[1]?></li>
	<?php } ?>
	<?php } ?>
  </ol>
</nav>
<?php } ?>