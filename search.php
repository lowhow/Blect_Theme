<?php
/**
 * The template for general search result page
 */
get_header();
global $helper; ?>
<?php get_template_part( 'partials/page-header/search' ); ?>
<div class="page-body">
	<div class="page-body-container container">
		<div class="page-body-inner row">
			<?php  /* Primary */ ?>
			<div id="primary" class="content-area col-md-8 margin-bottom-2x">
				<div id="content" class="site-content " role="main">
					<?php 
					if ( have_posts() && strlen( trim(get_search_query()) ) != 0 )
					{ 

						while ( have_posts() ) : the_post(); 
							get_template_part( 'partials/content/searchresults' );
						endwhile; 
						echo $helper->bootstrap_pagination();
					?>
					<script>

					highlightWord(document.getElementById( 'content' ), '<?php echo get_search_query(); ?>');

					function highlightWord(root,word){
					  	textNodesUnder(root).forEach(highlightWords);

					  	function textNodesUnder(root){
						    var walk=document.createTreeWalker(root,NodeFilter.SHOW_TEXT,null,false),
						        text=[], node;
						    while(node=walk.nextNode()) text.push(node);
						    return text;
					  	}
					    
					  	function highlightWords(n){
						    for (var i; (i=n.nodeValue.indexOf(word,i)) > -1; n=after){
						      	var after = n.splitText(i+word.length);
						      	var highlighted = n.splitText(i);
						      	var span = document.createElement('mark');
						      	span.className = 'highlighted';
						      	span.appendChild(highlighted);
						      	after.parentNode.insertBefore(span,after);
						    }
					  	}
					}
					</script>
					<?php
					}
					else
					{
					?>
						<div class="text-center h3 margin-bottom-2x">No results</div>
						<div class="search-box"><?php get_search_form(); ?></div>
					<?php 
					}
					?>
				</div><?php // END: #content ?>
			</div><?php // END: #primary ?>
			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>
		</div><?php // END: .page-body-inner ?>
	</div><?php // END: .page-body-container ?>
</div><?php // END: .page-body ?>
<?php get_footer(); ?>
