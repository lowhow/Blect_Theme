<?php
namespace Framework\Test;

Class TestFrameworkConstant
{ 
	private $testResult = TRUE;
	private $totalFails = 0;
	private $totalTestSubjects = 0;
	private $constantNameList = [
			'FW_NAME', 
			'FW_VER',
			'FW_DIR',
			'FW_VENDOR_DIR',
			'FW_VENDOR_URI',
			'FW_THEME_DIR',
			'FW_THEME_URI',
			'FW_THEME_ADMIN_DIR',
			'FW_THEME_ADMIN_URI',
			'FW_THEME_LANG_DIR',
			'FW_THEME_LANG_URI',
			'FW_THEME_ASSETS_DIR',
			'FW_THEME_ASSETS_URI',
			'FW_THEME_ASSETS_CSS_DIR',
			'FW_THEME_ASSETS_CSS_URI',
			'FW_THEME_ASSETS_IMG_DIR',
			'FW_THEME_ASSETS_JS_DIR',
			'FW_THEME_ASSETS_JS_URI',
			'FW_THEME_ASSETS_FONTS_DIR',
			'FW_THEME_ASSETS_FONTS_URI',
		];


	public function runTest(){

		return $this->runTestFrameworkConstant();
	}


	public function getTotalFails()
	{
		return $this->totalFails;
	}


	public function getTotalTestSubjects(){
		return $this->totalTestSubjects = count( $this->constantNameList );
	}


	private function runTestFrameworkConstant()
	{

		$output = '';

		foreach ($this->constantNameList as $constantName) {
			if ( defined( $constantName ) ) {
				$output .= '[ + ]' . $constantName . '=' . constant( $constantName ) . "\n";
			}else{
				$output .= '[ - ]' . $constantName . '= undefined' . "\n";
				$this->testResult = FALSE;
				$this->totalFails++;
			}
		}

		echo $output;

		return $this->testResult;
	}
}