<a class="btn btn-success pull-right" href="/blocks/?act=new">Новый блок</a>

<form id="ajax_form" class="form-inline">
  <div class="form-group mb-2">
    <input type="text" name="id"  class="form-control" placeholder="ID блока">
  </div>
  <div class="form-group mx-sm-2 mb-2">
    <input type="text" class="form-control" name="search" placeholder="Поиск">
  </div>
  <div class="form-group  mb-2">
	<select name="category_id" class="form-control" id="category_id">
	  <option value='0'>- Категория -</option>
	  <?php foreach(api('blocks.get_cats') as $cat) { ?>
	  <option <?php if($data['category_id'] == $cat['id']) echo 'selected="selected"'; ?> value='<?=$cat['id']?>'>
	  <?=$cat['name']?>
	  (<?=$cat['count']?>)
	  </option>
	  <?php }  ?>
	</select>
  </div>
  <div class="form-group mx-sm-2 mb-2">
    <select name="order" class="form-control">
	<option value="">- Сортировка -</option>
	<option value="id">ID</option>
	<option value="name">Имя</option>
	</select>
  </div>
  
  
  <div class="form-group  mb-2">
    <select name="order_by" class="form-control">
	<option value="">- Порядок -</option>
	<option value="asc">Возрастание</option>
	<option value="desc">Убывание </option>
	</select>
  </div>
   &nbsp;
  <button onclick="infinite_scroll_init('ajax_form'); infinite_scroll('ajax_form', 'ajax_content', '/ajax/scroll/blocks.get')"  type="button" class="btn btn-primary mb-2">Поиск</button>
  &nbsp;
  <button  type="reset" class="btn btn-light mb-2">Сброс</button>
  
  
</form>

<div id="ajax_content"></div>

<center class="ajax-loader"><img src="<?=HTTP_PATH?>/files/images/ajax-loader.gif" /></center>

<!--<hr>

<button type="button" onclick="infinite_scroll('ajax_form', 'ajax_content', '/ajax/scroll/blocks.get')" class="btn btn-block btn-light">Загрузить еще</button> -->


<script>


infinite_scroll_init('ajax_form');
infinite_scroll('ajax_form', 'ajax_content', '/ajax/scroll/blocks.get');


$('#ajax_form input, #ajax_form select').change(function() {
	infinite_scroll_init('ajax_form');
	infinite_scroll('ajax_form', 'ajax_content', '/ajax/scroll/blocks.get');
});


$(window).scroll(function () {
	if ($(window).height() + 200 + $(window).scrollTop() >= $(document).height()) 
	{
		//setTimeout(function() { 
		infinite_scroll('ajax_form', 'ajax_content', '/ajax/scroll/blocks.get');
		//}, 1000);
		
	}
});



</script>

