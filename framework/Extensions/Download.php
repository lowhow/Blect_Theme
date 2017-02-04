<?php namespace Framework\Extensions;
use Framework\Core\Observer as Observer;
use Framework\WordPress\Loader as Loader;

class Download implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle() 
	{
		$this->loader
		->add_action('init', $this, 'force_download');

		add_shortcode( 'fw_download', array( $this, 'download_shortcode' ) );

		return $this;
	}

	/**
	 * [force_download description]
	 * Note: 
	 * May have problem if SSL is not setup properly.
	 * @param  [type] $html [description]
	 * @return [type]       [description]
	 */
	public function force_download() 
	{	
	    if( isset($_GET['download']) && ! empty($_GET['download']) )
	    {
			$this->downloadFile( $_GET['download'] );
			exit();
		}
	}

	/*
	** Some files, such as mp3, are generally played throught the client browser.
	** If you prefer forcing download of such files, this is not a problem: 
	** The following code snippet will do that job properly.
	*/
	public function downloadFile( $file )
	{
        $file_name = $file;
        $mime = 'application/force-download';
		header('Pragma: public'); 	// required
		header('Expires: 0');		// no cache
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Type: '.$mime);
		header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
		header('Content-Transfer-Encoding: binary');
		header('Connection: close');
		readfile($file_name);		// push it out
		exit();
	}


	public function download_shortcode( $atts, $content )
	{
		$id = '';
		$href = '';
		$target = '';
		$class = '';
		if ( isset( $atts['id'] ) )
			$id = 'id="' . $atts['id'] . '"';
		if ( isset( $atts['href'] ) )
			$href = 'href="/?download=' . urlencode( $atts['href'] ) . '"';
		if ( isset( $atts['target'] ) )
			$target = 'target="' . $atts['target'] . '"';
		if ( isset( $atts['class'] ) )
			$class = 'class="' . $atts['class'] . '"';

		ob_start(); 
		?> 
		<a <?php echo $id ?> <?php echo $href ?> <?php echo $href ?> <?php echo $class ?>><?php echo $content; ?></a>
		<?php
        return ob_get_clean();
	}

}