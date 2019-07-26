<?php
/* =================
 * Magnus Test Suite
 * =================
 * 
 * This is a standalone test runner due to the limited overall scope of this
 * application. Eventually, I may migrate to a standardized test runner like
 * PHPUnit, this is not the time for that though.
 *
 * ======
 * To use
 * ======
 *
 * To use, simply open up your command line tool and navigate to where this 
 * script is located and run "php testsuite.php". It is recommended that 
 * you use entr to automatically run this test if you're contributing as
 * entr will listen for changes and execute commands you dictate to it when
 * a change occurs.
 *
 * ============
 * Adding tests
 * ============
 * 
 * To add new tests, add a test function in the first section then your 
 * invocations in the second section.
 */

$testResults = [];

 /* =====
  * Tests
  * =====
  */

function isEqual($a, $b, string $failMessage = "Provided inputs are not equal, expected to be equal") {
	if ($a == $b) {
		return ['state' => '.', 'message' => '']; 
	}

	return ['state' => 'F', 'message' => $failMessage];
}

function isNotEqual($a, $b, string $failMessage = "Provided inputs are equal, expected to be equal.") {
	if ($a != $b) {
		return ['state' => '.', 'message' => '']; 
	}

	return ['state' => 'F', 'message' => $failMessage];
}

function canAccessFile($filePath, string $failMessage = "File cannot be found at the referenced directory.") {
	if (file_exists($filePath)) {
		return ['state' => '.', 'message' => ''];
	}

	return ['state' => 'F', 'message' => $failMessage];
}

function isInFile($needle, $haystack, $failMessage = "String cannot be found in file.") {
	$haystackPile = fopen($haystack, 'r');

	while (($line = fgets($haystackPile)) !== false) {
		if (strpos($line, $needle) !== false) {
			return ['state' => '.', 'message' => ''];
		}
	}

	return ['state' => 'F', 'message' => $failMessage];
}

/* ======
 * Config
 * ======
 */

$serverRoot   = dirname(__DIR__);

/* ======
 * Invoke
 * ======
 */

$testResults[] = isNotEqual(1, 0, 'We have some serious problems if 1 == 0');
$testResults[] = isEqual(1, 1, 'Also serious problems if 1 != 1');

/* =======
 * Results
 * =======
 */
 
$testStates   = "";
$testMessages = "";
$testCount    = 0;
$testPass     = 0;
$testFail     = 0;

foreach ($testResults as $testResult) {
	$testCount++;
	$testStates .= $testResult['state'];
	if ($testResult['state'] == "F") {
		$testMessages .= "Test ID: " . $testCount . ", " . $testResult['message'] . "\n";
		$testFail++;
		continue;
	}
	$testPass++;
}

echo $testStates . "\n\n";
echo "Tests ran: " . $testCount . " Tests passed: " . $testPass . " Tests Failed: " . $testFail . "\n\n";
echo $testMessages . "\n\n";
