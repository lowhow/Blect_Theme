
<div class="module module-red">
	<div class="module-heading">
		<h3 class="module-title"><i class="fa fa-fire fa-fw"></i> 本周热门文章</h3>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php 
			if ( function_exists( 'wpp_get_mostpopular' ) )
			{
				wpp_get_mostpopular('range=weekly&limit=10&stats_views=0&post_html="<li><h5><i class=\'fa fa-chevron-circle-right fa-fw text-red\'></i> <a class=\'h5\' href=\'{url}\'>{text_title}</a></h5></li>"'); 
			}
			?>
		</div>
	</div>
</div>