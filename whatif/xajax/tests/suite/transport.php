<?php
	require_once("./options.inc.php");
	require_once('./testScriptPlugin.inc.php');
		
	$objResponse = new xajaxResponse();
	
	function testForm($strText, $formData, $arrArray) {
		global $objResponse;
		$data = "Text:\n" . $strText;
		$data .= "\n\nFormData:\n" . print_r($formData, true);
		$data .= "\n\nArray:\n" .print_r($arrArray, true); 
		$objResponse->alert($data);
		$objResponse->assign("status", "innerHTML", "<pre>".$data."</pre>");
		return $objResponse;
	}
	
	$testForm = $xajax->register(XAJAX_FUNCTION, "testForm");
	$testForm->useSingleQuote();
	$testForm->addParameter(XAJAX_INPUT_VALUE, "textField1");
	$testForm->addParameter(XAJAX_FORM_VALUES, "testForm1");
	$testForm->addParameter(XAJAX_JS_VALUE, "getTestArray()");
	
	$xajax->processRequest();
	
	echo '<' . '?xml version=1.0' . ' encoding=' . $xajax->getConfiguration('characterEncoding') . ' ?' . '>' . "\n";

	ob_start();
?>

		<script type="text/javascript">
			/* <![CDATA[ */
			function getTestArray()
			{
				var text = xajax.$('textField1').value;
				var testArray = new Array();
				testArray[0] = text;
				testArray[1] = text;
				testArray[2] = new Array();
				testArray[2][0] = text;
				testArray[2][1] = text; 
				testArray[3] = new Array();
				testArray[3][0] = text;
				testArray[3][1] = text;
				testArray[3][2] = new Array();
				testArray[3][2][0] = text;
				testArray[3][2][1] = text;
				
				return testArray;
			}
			/* ]]> */
		</script>
<?
	$objTestScriptPlugin->printHeader($xajax, "Character Encoding Test | xajax Tests", ob_get_clean());
	ob_start();
?>
		<h2>Text Test Form</h2>

		<p><a href="http://www.i18nguy.com/unicode-example.html" target="_blank">Here are some Unicode examples</a> you can paste into the text box below.</p>
		<p>You can see <a href="http://www.unicode.org/iuc/iuc10/languages.html" target="_blank">more examples and a list of standard encoding schemes here</a>.</p>

		<form id="testForm1" onsubmit="return false;">
			<p><input type="text" value="Enter test text here" id="textField1" name="textField1" size="60" /></p>
			<p><input type="submit" value="Submit Text" onclick="<?php $testForm->printScript() ?>;" /></p>
		</form>
<?
	$objTestScriptPlugin->printControlPanel(ob_get_clean());
	$objTestScriptPlugin->printStatusPanel();
	$objTestScriptPlugin->printLogPanel();
	$objTestScriptPlugin->printDescriptionPanel();
	$objTestScriptPlugin->printFooter();