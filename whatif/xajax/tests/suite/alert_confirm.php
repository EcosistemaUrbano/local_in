<?php
	/*
		File: alert_confirm.php
		
		Test script for the following <xajaxResponse> commands:
			- <xajaxResponse->alert>
			- <xajaxResponse->confirmCommands>
	*/
	
	require_once("./options.inc.php");
	
	require_once('./testScriptPlugin.inc.php');

	/*
		Function: sendAlert
		
		See <clsPage->sendAlert>
	*/
	function sendAlert($sValue) {
		global $page;
		return $page->sendAlert($sValue);
	}
	
	/*
		Function: sendConfirmCommands
		
		See <clsPage->sendAlert>
	*/
	function sendConfirmCommands() {
		global $page;
		return $page->sendConfirmCommands();
	}

	/*
		Class: clsPage
		
		Contains functions that will be registered and called from the browser.
	*/		
	class clsPage {
		/*
			Function: clsPage
			
			Constructor
		*/
		function clsPage() {
		}
		
		/*
			Function: sendAlert
			
			Generates a <xajaxResponse->alert> command that displays a message.
		*/
		function sendAlert($sValue) {
			$objResponse = new xajaxResponse();
			$objResponse->alert("Message from the sendAlert handler [{$sValue}].");
			return $objResponse;
		}
		
		/*
			Function: sendConfirmCommands
			
			Generates a <xajaxResponse->confirmCommands> command that will prompt
			the user if they want to see the alert, then a <xajaxResponse->alert>
			command.
		*/
		function sendConfirmCommands() {
			$objResponse = new xajaxResponse();
			$objResponse->confirmCommands(1, 'Do you want to see an alert next?');
			$objResponse->alert("Here is the alert!");
			return $objResponse;
		}
		
		function somePrivateFunction() {
		}
		
		function anotherPrivateFunction() {
		}
		
		function xajax_public() {
			// this is intended to return only the functions that should
			// be made available via xajax; however, for testing, we include
			// anotherPrivateFunction which will be excluded explicitly by
			// xajax_private.
			return array(
				'sendAlert', 
				'sendConfirmCommands',
				'anotherPrivateFunction'
				);
		}
		
		function xajax_private() {
			return array(
				'anotherPrivateFunction'
				);
		}
	}
	
	$page = new clsPage();
	$aPageRequests =& $xajax->register(XAJAX_CALLABLE_OBJECT, $page);
	$aPageRequests["sendalert"]->addParameter(XAJAX_QUOTED_VALUE, 'from callable object');
	
	$requestSendAlert =& $xajax->register(XAJAX_FUNCTION, 'sendAlert');
	$requestSendAlert->addParameter(XAJAX_QUOTED_VALUE, 'from function at global scope');
	$requestSendConfirmCommands =& $xajax->register(XAJAX_FUNCTION, 'sendConfirmCommands');
	
	$requestShowFormValues =& $xajax->register(
		XAJAX_FUNCTION, 
		new xajaxUserFunction('showFormValues', 'alert_confirm_external.inc.php'), 
		array('mode'=>'"synchronous"'));
	$requestShowFormValues->addParameter(XAJAX_FORM_VALUES, 'theForm');
	
	$requestSendBothEvent =& $xajax->register(XAJAX_EVENT, 'sendBoth');
	$requestSendBothEvent->addParameter(XAJAX_QUOTED_VALUE, 'from event handler');
	
	$xajax->register(XAJAX_EVENT_HANDLER, 'sendBoth', 'sendAlert');
	$xajax->register(XAJAX_EVENT_HANDLER, 'sendBoth', 'sendConfirmCommands');
	
	$xajax->processRequest();
	
	ob_start();
?>
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
	$objTestScriptPlugin->printHeader($xajax, "Alert / Confirm", ob_get_clean());
	ob_start();
?>
		<div class='controlPanel_cell'>
			<div>Functions at<br>Global Scope:</div>
			<a href='#' onclick='<?php $requestSendAlert->printScript(); ?>; return false;'>Send Alert</a><br />
			<a href='#' onclick='<?php $requestSendConfirmCommands->printScript(); ?>; return false;'>Send Confirm</a><br />
		</div>
		<div class='controlPanel_cell'>
			<div>Functions in a<br>Callable Object:</div>
			<a href='#' onclick='<?php $aPageRequests['sendalert']->printScript(); ?>; return false;'>Send Alert</a><br />
			<a href='#' onclick='<?php $aPageRequests['sendconfirmcommands']->printScript(); ?>; return false;'>Send Confirm</a><br />
		</div>
		<div style='clear: both; padding: 3px;'></div>
		<div class='controlPanel_cell'>
			<div>Functions registered as<br>Event Handlers:</div>
			<a href='#' onclick='<?php $requestSendBothEvent->printScript(); ?>; return false;'>Send Both</a><br />
		</div>
		<div class='controlPanel_cell'>
			<div>Using function at global scope from an external (include) file :</div>
			<a href='#' onclick='<?php $requestShowFormValues->printScript(); ?>; return false;'>Send Alert</a><br />
			<form id="theForm" method="post" action="#">
				<input name="test" value="test value" />
				<input name="other" value="other" />
			</form>
		</div>
<?php
	$objTestScriptPlugin->printControlPanel(ob_get_clean());
	$objTestScriptPlugin->printStatusPanel();
	$objTestScriptPlugin->printLogPanel();
	ob_start();
?>
	The purpose of this script is to test the invocation of the alert and
	confirm dialogs on the browser from the php script.  It also tests the
	use of 'global functions', 'callable objects' and 'event handlers'.  
	Last, it tests the ability to include a php script that contains the 
	request handler only at the time of the request.
<?php
	$objTestScriptPlugin->printDescriptionPanel(ob_get_clean());
	$objTestScriptPlugin->printFooter();
?>
