<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Предпросмотр изображения</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div> 

<div class="modal-body" data-width="1850px">

<img style="width:100%" src="<?=HTTP_PATH.'/images.php?url='.$_GET['image_file']?>" /> <!--  max-width:1800px; max-height:900px-->


</div>


<!--<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<button onclick="ajax_form('<?=$param?>_form', 'themes.add')" type="button" class="btn btn-primary">Создать</button>
</div>-->

<script>



</script>