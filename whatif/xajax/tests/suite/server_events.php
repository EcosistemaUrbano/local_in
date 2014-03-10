<?php
	/*
		File: server_events.php
		
		Test script that uses <xajax->register> to register an event and some event
		handlers to process requests from the client.
	*/

	require_once("./options.inc.php");
	require_once('./testScriptPlugin.inc.php');
	
	function eventHandlerOne()
	{
		$objResponse = new xajaxResponse();
		$objResponse->append('log', 'innerHTML', 'Message from event handler one.<br />');
		return $objResponse;
	}
	
	function eventHandlerTwo()
	{
		$objResponse = new xajaxResponse();
		$objResponse->append('log', 'innerHTML', 'Message from event handler two.<br />');
		return $objResponse;
	}
	
	class clsEventHandlers
	{
		function eventHandlerThree()
		{
			$objResponse = new xajaxResponse();
			$objResponse->append('log', 'innerHTML', 'Message from event handler three.<br />');
			$objResponse->setReturnValue('return value from event handler three.');
			return $objResponse;
		}
	}
	
	$objEventHandlers = new clsEventHandlers();
	$objEventHandlerThree = new xajaxUserFunction(array(&$objEventHandlers, 'eventHandlerThree'));
	
	$requestEvent = $xajax->register(XAJAX_EVENT, 'theOneAndOnly', array("mode" => "synchronous"));
	
	$xajax->register(XAJAX_EVENT_HANDLER, 'theOneAndOnly', 'eventHandlerOne');
	$xajax->register(XAJAX_EVENT_HANDLER, 'theOneAndOnly', 'eventHandlerTwo');
	$xajax->register(XAJAX_EVENT_HANDLER, 'theOneAndOnly', $objEventHandlerThree);
	
	$xajax->processRequest();

	ob_start();
?>
		<script type="text/javascript">
			/* <![CDATA[ */
			/* ]]> */
		</script>

		<style type='text/css'>
			/* <![CDATA[ */
			/* ]]> */
		</style>
<?
	$objTestScriptPlugin->printHeader($xajax, "Server-side Events", ob_get_clean());
	ob_start();	
?>
		<button onclick='alert("The event handlers returned ["+<?php $requestEvent->printScript(); ?>+"]");'>Fire event</button>
<?
	$objTestScriptPlugin->printControlPanel(ob_get_clean());
	$objTestScriptPlugin->printStatusPanel();
	$objTestScriptPlugin->printLogPanel();	
	ob_start();
?>	
		This script demonstrates xajax's ability to register multiple 'handler' functions that will be called (in the order they are registered)
		in response to a single request.  A variety of call options can be set for the event request including mode, method and context.
<?php
	$objTestScriptPlugin->printDescriptionPanel(ob_get_clean());
	$objTestScriptPlugin->printFooter();
