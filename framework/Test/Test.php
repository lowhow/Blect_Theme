<?php
namespace Framework\Test;

class Test 
{ 
	public function __construct()
	{ 
		echo '<pre>';
		$this->runFrameworkTest();
		echo '<hr/>';
		$this->runWPSetupTest();
		echo '</pre>';
	}


	private function runFrameworkTest()
	{ 
		$testFrameworkConstant = new TestFrameworkConstant;

		echo 'Checking in on Constants definition...' . "\n";
		echo 'Total subjects = ' . $testFrameworkConstant->getTotalTestSubjects() . "\n\n";

		if ( $testFrameworkConstant->runTest() ) {
			echo '<p>TestFrameworkConstant: OK!</p>';
		}else{
			echo '<p>TestFrameworkConstant: Failed.<p>'; 
		}
	}


	private function runWPSetupTest()
	{ 
		$testWPSetup = new TestWPSetup();
		if ( $testWPSetup->runTest() ){
			echo '<p>TestWPSetup: OK!</p>';
		}else{
			echo '<p>TestWPSetup: Failed.<p>';
		}
	}

}