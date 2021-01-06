<p class="bottommargin-minier">Чтобы ссылки из меню вели на нужные страницы, следите за тем, чтобы заголовки страниц и меню совпадали.</p>
<p>Дочерние страницы и пункты меню указываются через "-" (тире) в нужной последовательности. Смотрите образец в теме.</p>

<div class="tabs tabs-alt tabs-tb clearfix ui-tabs ui-corner-all ui-widget ui-widget-content" id="">

	<ul class="tab-nav clearfix">
		<li><a href="#site_structure">Структура сайта</a></li>
		<li><a href="#menu_structure">Структура меню</a></li>
	</ul>

	<div class="tab-container">

		<div class="tab-content clearfix " id="site_structure">
			<div class="form-group">
				<textarea rows=22 name="content" class="form-control" ><?=$data['content']?></textarea>
			 </div>
		</div>
		
		<div class="tab-content clearfix" id="menu_structure">
			<div class="form-group">
				<textarea rows=22 name="menu" class="form-control"  ><?=$data['menu']?></textarea>
			 </div>
		
		</div>

	</div>

</div>




