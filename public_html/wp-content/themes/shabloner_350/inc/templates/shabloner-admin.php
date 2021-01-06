<?php


// Подключаемся к MySQL
include(get_template_directory().'/inc/MysqliDb.php') ;

global $db;
global $table_prefix;

$db = new MysqliDb (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$db->setPrefix($table_prefix);

include(get_template_directory().'/inc/functions.php') ;

?>

<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/bootstrap.css" />
<link rel="stylesheet" href="<?=get_template_directory_uri()?>/inc/styles.css" />
<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/font-icons.css" type="text/css" />

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<script src="<?=get_template_directory_uri()?>/js/plugins.js"></script>
<script src="<?=get_template_directory_uri()?>/js/jquery-ui.js"></script>

<script src="<?=get_template_directory_uri()?>/js/functions.js"></script>
<script src="<?=get_template_directory_uri()?>/js/shabloner.js"></script>


<div class="container main_block" >

<?php include(get_template_directory().'/inc/templates/main.php') ; ?>
  
</div>

<div class="modal fade " id="dialog" tabindex="-1" role="dialog" aria-labelledby="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content"></div>
</div>
</div>

<div class="container">
<div class="row ">
    <div class="col-sm">

 
<div class="form-group ">
		<label for="">Путь файла синхронизации (API)</label>
		
		<div class=" ">
		  <input  name="" type="text" class=" form-control "  value="<?=get_template_directory_uri().'/api.php'?>">
		</div>		
		
 </div>
 </div>

    <div class="col-sm">
<div class="form-group ">
		<label for="">Путь загрузки по FTP</label>
		
		<div class=" ">
		  <input  name="" type="text" class=" form-control "  value="<?php echo get_template_directory(); ?>">
		</div>		
		
 </div>
 </div>
 </div>
 </div>

