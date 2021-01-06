<form action="" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=THEME_ID?>" />

		<div class="form-group ">
			<label for="license_key">Введите лицензионный ключ</label>
			
				<div class="input-group ">
				  <div class="input-group-prepend">
					<span class="input-group-text" id=""><i class="fas fa-key"></i></span>
				  </div>
				<input name="license_key" type="text" class="form-control " id="license_key" placeholder="XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX" value="<?=$_POST['license_key']?>" >
				
				</div>		
				
			<span class="form-text text-muted">Ключ находится в личном кабинете Шаблонера в разделе "<a target="_blank" href="<?=SHTTP_PATH?>/opt/services?act=my">Мои заказы</a>".</span>
				
		 </div>

<button class="btn btn-primary" type="submit">Активировать</button>


</form>  
