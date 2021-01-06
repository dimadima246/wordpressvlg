
<div class="clearfix preview_edit last_block topmargin bottommargin " style="">
	<div class="container " style="">
		<div class="center row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
		
		<button onclick="modal_dialog_open_constructor('choose_block_visual', 'page_id=<?=$_GET['page_id']?>&theme_id=<?=$_GET['theme_id']?>&no_replace=1')" type="button" class="btn btn-outline-secondary  btn-block">Добавить блок</div>
		
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>

<div id="dialogs"></div>

<script src="<?=HTTP_PATH?>/files/colpick-master/js/colpick.js"></script>

<input type="hidden" id="element_input" />
<input type="hidden" id="main_color" />
<input type="hidden" id="link_input" />
<input type="hidden" id="link_selection" />
<input type="hidden" id="link_target" />

<script>
window.theme_id = '<?=$_GET['theme_id']?>';
window.page_id = '<?=$_GET['page_id']?>';
window.panelka_focus = false;
window.contentData = false;

</script>

<script src="<?=HTTP_PATH?>/files/page_view.js?_<?=time()?>"></script>

<script>

bind_settings();
</script>