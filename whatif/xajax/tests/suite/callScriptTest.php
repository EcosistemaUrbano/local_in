<?php
/*
	File: callScriptTest.php
	
	Test script that uses the <xajaxResponse->call> command to execute
	a function call on the browser.
*/

	require_once("./options.inc.php");
	
	require_once('./testScriptPlugin.inc.php');

	function callScript()
	{
		$response = new xajaxResponse();
		$value2 = "this is a string";
		$response->call("myJSFunction", "arg1", 9432.12, array("myKey" => "some value", "key2" => $value2));
		return $response;
	}

	function callOtherScript()
	{
		$response = new xajaxResponse();
		$response->call("myOtherJSFunction");
		return $response;
	}

	$requestCallScript =& $xajax->register(XAJAX_FUNCTION, "callScript");
	$requestCallOtherScript =& $xajax->register(XAJAX_FUNCTION, "callOtherScript");

	$xajax->processRequest();

	$sRoot = dirname(dirname(dirname(__FILE__)));

	if (false == class_exists('xajaxControl')) {
		$sCore = '/xajax_core';
		include_once($sRoot . $sCore . '/xajaxControl.inc.php');
	}

	$sControls = '/xajax_controls';
	foreach (array(
		'/document.inc.php',
		'/structure.inc.php',
		'/content.inc.php',
		'/misc.inc.php'
		) as $sInclude)
		include $sRoot . $sControls . $sInclude;

	$buttonCallScript = new clsButton(array(
		'attributes' => array('id' => 'call_script'),
		'children' => array(new clsLiteral('Click Me'))
		));
	$buttonCallScript->setEvent('onclick', $requestCallScript);

	$buttonCallOtherScript = new clsButton(array(
		'attributes' => array('id' => 'call_other_script'),
		'children' => array(new clsLiteral('or Click Me'))
		));
	$buttonCallOtherScript->setEvent('onclick', $requestCallOtherScript);
	
	ob_start();
?>
	<script type="text/javascript">
		function myJSFunction(firstArg, numberArg, myArrayArg)
		{
			var newString = firstArg + " and " + (+numberArg + 100) + "\n";
			newString += myArrayArg["myKey"] + " | " + myArrayArg.key2;
			// alert(newString);
			xajax.$('myDiv').innerHTML = newString;
			writeToLog('myJSFunction called.<br>');
		}
		function myOtherJSFunction() {
			var newString = 'No parameters needed<br>for this function.';
			// alert(newString);
			xajax.$('myDiv').innerHTML = newString;
			writeToLog('myOtherJSFunction called.<br>');
		}
	</script>
		<style type='text/css'>
			/* <![CDATA[ */
			.controlPanel_cell {
				float: left;
				position: relative;
				width: 50%;
			}
			/* ]]> */
		</style>
<?php
	$objTestScriptPlugin->printHeader($xajax, "Call Script Test", ob_get_clean());
	ob_start();
?>
	<div class='controlPanel_cell'>
		<p><?php $buttonCallScript->printHTML(); ?></p>
		<p>Expecting:</p>
		<pre>arg1 and 9532.12
some value | this is a string</pre>
	</div>
	<div class='controlPanel_cell'>
		<p><?php $buttonCallOtherScript->printHTML(); ?></p>
		<p>Expecting:</p>
		<p>No parameters needed<br>for this function.</p>
	</div>
<?php
	$objTestScriptPlugin->printControlPanel(ob_get_clean());
	ob_start();
?>
<p>Result:</p>
<pre id="myDiv">[blank]</pre>
<?php
	$objTestScriptPlugin->printStatusPanel(ob_get_clean());
	$objTestScriptPlugin->printLogPanel();
	ob_start();
?>
	<p>This script demonstrates the ability for xajax to send data to and call javascript 
	functions on the client browser.
	<p>The first button, Click Me, will call a xajax function on the server, which will in
	turn send a response command back to the client to call myJSFunction.  myJSFunction accepts 
	three parameters which should match the text following 'Expecting:'.
	<p>The second button, or Click Me, will call a xajax function on the server which will return
	a response command back to the client to call myOtherJSFunction.  myOtherJSFunction does not
	accept any parameters and simply pops up and alert explaining so.
<?php
	$objTestScriptPlugin->printDescriptionPanel(ob_get_clean());
	$objTestScriptPlugin->printFooter();
?>
