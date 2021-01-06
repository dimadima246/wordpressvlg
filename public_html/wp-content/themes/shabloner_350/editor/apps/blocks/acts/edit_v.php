<div class="tabs clearfix" id="tabs">

<ul class="tab-nav clearfix" id="" >
  <li class="">
    <a  href="#base" role="tab" >Основное</a>
  </li>
  <li class="">
    <a  href="#settings" role="tab"  >Настройки</a>
  </li>
  <li class="">
    <a href="#content_structure" role="tab"  >Структура контента</a>
  </li>
  <li class="">
    <a  href="#content" role="tab" >Контент</a>
  </li>
</ul>
<form action="" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=$_GET['id']?>" />
<div class="tab-container " id="myTabContent">
  <div class="tab-content " id="base" ><?php include($_APP['folder'].'/html/base.php'); ?></div>
  <div class="tab-content " id="settings" ><?php include($_APP['folder'].'/html/settings.php'); ?></div>
  <div class="tab-content " id="content_structure"><?php include($_APP['folder'].'/html/content_structure.php'); ?></div>
  <div class="tab-content " id="content" ><?php include($_APP['folder'].'/html/content.php'); ?></div>
</div>

<hr>

<button class="btn btn-primary" type="submit">Сохранить</button>
<button onclick="modal_dialog_open('block_copy', 'id=<?=$_GET['id']?>')" class="btn btn-success" type="button">Сохранить как ...</button>
<button onclick="block_delete(<?=$_GET['id']?>, 1)" class="btn btn-light" type="button">Удалить</button>

</form>  

</div>
