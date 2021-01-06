<div class="row">
    <div class="col-sm">
		 <div class="form-group">
			<label for="name">Путь файла синхронизации (API)</label>
			<input name="api_path" type="text" class="form-control" id="api_path" value="<?=$data['api_path']?>" >
		  </div>
	
		  <hr />
		  
		  <p>Бывает, что на хостинге установлено ограничение на размер загружаемых файлов и синхронизация по API не удается. <b>Если вы столкнулись с проблемой</b> синхронизации по API, укажите данные для загрузки по FTP.</p>
		  <p>Если проблем синхронизации по API нет, то указывать FTP данные не нужно.</p>
	
		 <div class="form-group">
			<label for="ftp_path">Путь загрузки по FTP</label>
			<input name="settings[ftp_path]" type="text" class="form-control" id="ftp_path" value="<?=$settings['ftp_path']?>" >
		  </div>
	
		 <div class="form-group">
			<label for="ftp_host">FTP хост</label>
			<input name="settings[ftp_host]" type="text" class="form-control" id="ftp_host" value="<?=$settings['ftp_host']?>" >
		  </div>
	
		 <div class="form-group">
			<label for="ftp_login">FTP логин</label>
			<input name="settings[ftp_login]" type="text" class="form-control" id="ftp_login" value="<?=$settings['ftp_login']?>" >
		  </div>
	
		 <div class="form-group">
			<label for="ftp_pass">FTP пароль</label>
			<input name="settings[ftp_pass]" type="text" class="form-control" id="ftp_pass" value="<?=$settings['ftp_pass']?>" >
		  </div>
		  
    </div>
	
	
    <div class="col-sm">
		
		 <div class="form-group">
			<label for="synchronization">Метод передачи</label>
			<select name="settings[synchronization]" class="form-control">
				<option <?php if($settings['synchronization'] == 'api') echo 'selected="selected"'; ?> value="api">Файл синхронизации API</option>
				<option <?php if($settings['synchronization'] == 'ftp') echo 'selected="selected"'; ?>  value="ftp">Загрузка по FTP</option>
			</select>
		  </div>
		<hr />
		<label class="bottommargin-minier">Результаты проверки</label>
		<p>Сохраните изменения перед проверкой.</p>
		<div class="font_preview bottommargin-xs">

			<div id="synch_check">
			
			
			
			</div>
			
			
		</div>	
		
		
		<button type="button" class="btn btn-success" onclick="connection_check()">Проверка соединения</button>
		
    </div>
</div>



 
<script>

function connection_check()
{
	$("#synch_check").html('<img src="<?=HTTP_PATH?>/files/images/ajax-loader.gif" />');
	
	$.ajax({
		type: "POST",
		url: '/ajax/check_connection?theme_id=<?=$_GET['id']?>',
		//dataType: 'json'
	})
	.done(function( data ) {
		$(".ajax-loader").hide();
		$("#synch_check").html(data)
		
	});
	
}




</script>