<?php
	/*
		File: functions.php
		
		Test script that uses <xajaxResponse->setFunction>, <xajaxResponse->wrapFunction>,
		<xajaxResponse->script> and <xajaxResponse->call> to build, modify, remove and
		call javascript functions on the browser.
	*/

	require_once("./options.inc.php");
	require_once('./testScriptPlugin.inc.php');
	
	class clsRequests {
		function clsRequests() {
		}
		
		function insertFunction() {
			$objResponse = new xajaxResponse();
			$objResponse->setFunction('myFunction', '', 'xajax.$("log").innerHTML += "called myFunction<br />";');
			return $objResponse;
		}
		
		function wrapFunction() {
			$objResponse = new xajaxResponse();
			$objResponse->wrapFunction(
				'myFunction', 
				'', 
				array(
					'xajax.$("log").innerHTML += "entered wrapper function<br />";', 
					'xajax.$("log").innerHTML += "leaving wrapper function<br />";'
					), 
				''
				);
			return $objResponse;
		}
		
		function deleteFunction() {
			$objResponse = new xajaxResponse();
			$objResponse->script('myFunction = undefined;');
			return $objResponse;
		}
		
		function callFunction() {
			$objResponse = new xajaxResponse();
			$objResponse->call('myFunction');
			return $objResponse;
		}
	}
	
	$objRequests =& new clsRequests();
	$aRequests = $xajax->register(XAJAX_CALLABLE_OBJECT, $objRequests);
	
	$xajax->processRequest();
	
	ob_start();
?>
		<script type="text/javascript">
			/* <![CDATA[ */
			checkForFunction = function() {
				if (undefined == window['myFunction']) {
					xajax.$('status').innerHTML = 'myFunction <b>is not</b> present.';
					xajax.$('call').disabled = true;
					xajax.$('wrap').disabled = true;
				} else {
					xajax.$('status').innerHTML = 'myFunction <b>is</b> present.';
					xajax.$('call').disabled = false;
					xajax.$('wrap').disabled = false;
				}
				setTimeout('checkForFunction();', 1000);
			}
			writeLog = function(msg) {
				xajax.$("log").innerHTML += msg;
			}
			clearLog = function() {
				xajax.$('log').innerHTML = '';
			}
			/* ]]> */
		</script>
		<style type='text/css'>
			/* <![CDATA[ */
			.controls {
				border: 1px solid black;
				width: 300px;
				margin-bottom: 3px;
			}
			.status {
				margin-left: 3px;
				border: 1px solid black;
				width: 300px;
			}
			.log {
				margin-top: 3px;
				border: 1px solid black;
				width: 603px;
			}
			.description {
				margin-top: 4px;
				margin-bottom: 4px;
				font-size: small;
				border: 1px solid #999999;
				padding: 3px;
			}
			#control {
				height: 25px;
			}
			#status {
				height: 25px;
			}
			/* ]]> */
		</style>
<?php
	$objTestScriptPlugin->printHeader($xajax, "Javascript Functions", ob_get_clean());
?>
		<form id='mainForm' onsubmit='return false;'>
<?
ob_start();
?>
							<table class=''>
								<tbody>
									<tr>
										<td width='25%'>
											<div id='control'>&nbsp;</div>
										</td>
										<td align='center'>
											<input type='submit' value='Add' 
											onclick='writeLog("Adding / Resetting myFunction()<br />"); <?php $aRequests['insertfunction']->printScript(); ?>; return false;' />
										</td>
										<td align='center'>
											<input type='submit' value='Remove' 
												onclick='writeLog("Removing myFunction()<br />"); <?php $aRequests['deletefunction']->printScript(); ?>; return false;' />
										</td>
										<td align='center'>
											<input type='submit' id='call' value='Call' 
												onclick='writeLog("Calling myFunction()<br />"); <?php $aRequests['callfunction']->printScript(); ?>; return false;' />
										</td>
										<td align='center'>
											<input type='submit' id='wrap' value='Wrap' 
												onclick='writeLog("Wrapping myFunction()<br />"); <?php $aRequests['wrapfunction']->printScript(); ?>; return false;' />
										</td>
										<td width='25%'>
										</td>
									</tr>
								</tbody>
							</table>
<?
	$objTestScriptPlugin->printControlPanel(ob_get_clean());
?>
		</form>
<?php
	$objTestScriptPlugin->printStatusPanel();
	$objTestScriptPlugin->printLogPanel();
	ob_start();
?>
			This page tests the ability to add, remove, wrap and call javascript functions.  The status (above) will update every 
		second indicating whether the function (called myFunction) is present in the javascript environment on the browser. 
		Click the add button to have the xajax function "install" the function on the browser.  If it already exists, it will 
		be replaced.  Click the remove button to have the function removed from the javascript environment.<p>
		By clicking the call button, you can have the xajax enabled function invoke the function from the server.  The function, 
		if present, will pop up an alert indicating that it was called.<p>
		The wrap button will cause the xajax enabled function to generate a function wrapper around the existing javascript
		function.  The wrapper function will pop up an alert message before calling the original function, then another alert
		message once the function returns.  The wrapper function can be added around the original function any number of times.
		Each time the wrapper function is applied, it will add a new "layer" where the before and after alert messages are
		displayed.  Click the call button after wrapping the function to see the result.
<?php
	$objTestScriptPlugin->printDescriptionPanel(ob_get_clean());
	$objTestScriptPlugin->printFooter();
