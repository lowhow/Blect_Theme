<?php
namespace Framework\Test;
use Framework\WordPress\WPSetup;

Class TestWPSetup extends WPSetup
{
	private $testResult = TRUE;
	private $totalFails = 0;
	private $totalTestSubjects = 0;

	public function __construct()
	{
	}


	public function runTest()
	{ 
		$this->loadThemeTextDomainRunTest( 'fw', FW_THEME_LANG_DIR );
		$this->addRSSFeedRunTest( 'automatic-feed-links' );
	}


	public function getTotalFails()
	{
		return $this->totalFails;
	}


	public function loadThemeTextDomainRunTest( $textDomain, $langDir )
	{
		$output = '';
		$output = '[ VOID ] loadThemeTextDomain - (TODO: refine test)'. "\n";

		// if ( load_theme_textdomain( $textDomain, $langDir ) ){
		// 	$output .= '[ + ] loadThemeTextDomain - OK (TODO: refine test)' . "\n";
		// }else{
		// 	$output .= '[ - ] loadThemeTextDomain - FAILED' . "\n";
		// 	$this->testResult = FALSE;
		// 	$this->totalFails++;
		// }

		echo $output;
	}


	public function addRSSFeedRunTest( $feature )
	{
		$output = '';
		$output = '[ VOID ] addRSSFeed - (TODO: refine test)'. "\n";

		// if ( current_theme_supports( $feature ) ){
		// 	$output .= '[ + ] addRSSFeed - OK' . "\n";
		// }else{
		// 	$output .= '[ - ] addRSSFeed - FAILED' . "\n";
		// 	$this->testResult = FALSE;
		// 	$this->totalFails++;
		// }

		echo $output;
	}

} 	