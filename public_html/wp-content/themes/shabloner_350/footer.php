	</div><!-- #wrapper end -->

	<div class="modal fade " id="dialog" tabindex="-1" role="dialog" aria-labelledby="dialog">
	<div class="modal-dialog" role="document">
	<div class="modal-content"></div>
	</div>
	</div>
	
	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script src="<?=get_template_directory_uri()?>/js/jquery.js"></script>
	<script src="<?=get_template_directory_uri()?>/js/plugins.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script id="functions_script" src="<?=get_template_directory_uri()?>/js/functions.js"></script>
	<script src="<?=get_template_directory_uri()?>/js/blocks.js"></script>
	<script src="<?=get_template_directory_uri()?>/js/shabloner.js"></script>
	
<?php wp_footer() ?>
<?=stripslashes(file_get_contents(get_template_directory().'/shcode.txt'))?></body>
</html>