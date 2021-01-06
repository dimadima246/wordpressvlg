
<div id="">
<button class="btn btn-success " type="button"  onclick="modal_dialog_open('page_new', 'theme_id=<?=THEME_ID?>')">Новая страница</button>
</div>


<div class="h5 topmargin-sm bottommargin-minier">


<table class="table">
  <thead>
	<tr>
	  <th>Название</th>
	  <th>Тип</th>
	  <th>ID или постоянная ссылка</th>
	  <th></th>
	</tr>
  </thead>
  <tbody>
  
	<?php
	$pages = api('themes.pages_get', array('theme_id' => THEME_ID));
	foreach($pages['data'] as $page) {
	
	?>
	
	<tr>
	  <td>
	<?php if($_GET['page_id'] == $page['id']) echo '<span class="text-muted">'.$page['name'].'</span>'; else { ?> 
	<a href="index.php?app=page_view&theme_id=<?=THEME_ID?>&page_id=<?=$page['id']?>"><?=$page['name']?></a>
	<?php } ?>

	
	  </td>
	  
	  <td><?=str_replace('other', 'Произвольная', $page['role'])?></td>
	  	  
	  <td>
	  <?php if($page['slug']) echo $page['slug']; else echo '-'; ?>

	  </td>
	  
	  <td class="tright " >
	  
		<button data-toggle="tooltip" title="Настройки страницы" onclick="modal_dialog_open('page_edit', 'theme_id=<?=THEME_ID?>&id=<?=$page['id']?>')" type="button" class="btn btn-xs btn-primary "><i class="fa fa-cog"></i></button>
	  
		<button data-toggle="tooltip" title="Копировать страницу" onclick="modal_dialog_open('page_new', 'theme_id=<?=THEME_ID?>&from_page_id=<?=$page['id']?>')" type="button" class="btn btn-xs btn-info "><i class="fa fa-clone"></i></button>
		
		<button data-toggle="tooltip" title="Удалить страницу" onclick="page_delete('<?=$page['id']?>')" type="button" class="btn btn-xs btn-danger "><i class="fa fa-trash"></i></button>
	  
	  </td>
	</tr>
	<?php } ?>
  </tbody>
</table>

</div>