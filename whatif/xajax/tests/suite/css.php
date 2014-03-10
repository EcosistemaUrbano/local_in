<?php
	/*
		File: css.php
		
		Test script that uses <xajaxResponse->includeCSS> and <xajaxResponse->removeCSS>
		to effect the active style information on the page dynamically.
	*/

	error_reporting(E_ALL^E_NOTICE);
	ini_set("display_errors", 1);

	require_once("./options.inc.php");
	require_once('./testScriptPlugin.inc.php');
	
	$objResponse = new xajaxResponse();
	
	class clsFunctions {
		function clsFunctions() {
		}
		
		function loadCSS1() {
			global $objResponse;
			$objResponse->includeCSS('css1.css');
			$objResponse->append('log', 'innerHTML', 'CSS1 loaded.<br />');
			return $objResponse;
		}
		
		function unloadCSS1() {
			global $objResponse;
			$objResponse->removeCSS('css1.css');
			$objResponse->append('log', 'innerHTML', 'CSS1 unloaded.<br />');
			return $objResponse;
		}
		
		function loadCSS2() {
			global $objResponse;
			$objResponse->includeCSS('css2.css');
			$objResponse->append('log', 'innerHTML', 'CSS2 loaded.<br />');
			return $objResponse;
		}
		
		function unloadCSS2() {
			global $objResponse;
			$objResponse->removeCSS('css2.css');
			$objResponse->append('log', 'innerHTML', 'CSS2 unloaded.<br />');
			return $objResponse;
		}

		function loadCSS1_Print() {
			global $objResponse;
			$objResponse->includeCSS('css3.css');
			$objResponse->includeCSS('css1.css', 'print');
			$objResponse->append('log', 'innerHTML', 'CSS1 loaded for Print media.<br />');
			return $objResponse;
		}
		
		function unloadCSS1_Print() {
			global $objResponse;
			$objResponse->removeCSS('css3.css');
			$objResponse->removeCSS('css1.css', 'print');
			$objResponse->append('log', 'innerHTML', 'CSS1 unloaded for Print media.<br />');
			return $objResponse;
		}
		
		function loadCSS2_Print() {
			global $objResponse;
			$objResponse->includeCSS('css4.css');
			$objResponse->includeCSS('css2.css', 'print');
			$objResponse->append('log', 'innerHTML', 'CSS2 loaded for Print media.<br />');
			return $objResponse;
		}
		
		function unloadCSS2_Print() {
			global $objResponse;
			$objResponse->removeCSS('css4.css');
			$objResponse->removeCSS('css2.css', 'print');
			$objResponse->append('log', 'innerHTML', 'CSS2 unloaded for Print media.<br />');
			return $objResponse;
		}
	}
	
	$functions = new clsFunctions();
	
	$aFunctions = $xajax->register(XAJAX_CALLABLE_OBJECT, $functions);
	
	$xajax->processRequest();

	$sRoot = dirname(dirname(dirname(__FILE__)));

	if (false == class_exists('xajaxControl')) {
		$sCore = '/xajax_core';
		include_once($sRoot . $sCore . '/xajaxControl.inc.php');
	}

	$sControls = '/xajax_controls';
	include_once($sRoot . $sControls . '/document.inc.php');
	include_once($sRoot . $sControls . '/content.inc.php');
	include_once($sRoot . $sControls . '/group.inc.php');
	include_once($sRoot . $sControls . '/form.inc.php');
	include_once($sRoot . $sControls . '/misc.inc.php');
	
	$buttonLoadCSS1 = new clsButton(array(
		'attributes' => array(
			'class' => 'loadCSS1',
			'id' => 'loadCSS1'
			),
		'children' => array(new clsLiteral('Load CSS 1')),
		'event' => array('onclick', $aFunctions['loadcss1'])
		));

	$buttonUnloadCSS1 = new clsButton(array(
		'attributes' => array(
			'class' => 'initiallyHidden unloadCSS1',
			'id' => 'unloadCSS1'
			),
		'children' => array(new clsLiteral('Unload CSS 1')),
		'event' => array('onclick', $aFunctions['unloadcss1'])
		));
	
	$buttonLoadCSS2 = new clsButton(array(
		'attributes' => array(
			'class' => 'loadCSS2',
			'id' => 'loadCSS2'
			),
		'children' => array(new clsLiteral('Load CSS 2')),
		'event' => array('onclick', $aFunctions['loadcss2'])
		));

	$buttonUnloadCSS2 = new clsButton(array(
		'attributes' => array(
			'class' => 'initiallyHidden unloadCSS2',
			'id' => 'unloadCSS2'
			),
		'children' => array(new clsLiteral('Unload CSS 2')),
		'event' => array('onclick', $aFunctions['unloadcss2'])
		));


	
	$buttonLoadCSS1_Print = new clsButton(array(
		'attributes' => array(
			'class' => 'loadCSS1_Print',
			'id' => 'loadCSS1_Print'
			),
		'children' => array(new clsLiteral('Load CSS 1 (print)')),
		'event' => array('onclick', $aFunctions['loadcss1_print'])
		));

	$buttonUnloadCSS1_Print = new clsButton(array(
		'attributes' => array(
			'class' => 'initiallyHidden unloadCSS1_Print',
			'id' => 'unloadCSS1_Print'
			),
		'children' => array(new clsLiteral('Unload CSS 1 (print)')),
		'event' => array('onclick', $aFunctions['unloadcss1_print'])
		));
	
	$buttonLoadCSS2_Print = new clsButton(array(
		'attributes' => array(
			'class' => 'loadCSS2_Print',
			'id' => 'loadCSS2_Print'
			),
		'children' => array(new clsLiteral('Load CSS 2 (print)')),
		'event' => array('onclick', $aFunctions['loadcss2_print'])
		));

	$buttonUnloadCSS2_Print = new clsButton(array(
		'attributes' => array(
			'class' => 'initiallyHidden unloadCSS2_Print',
			'id' => 'unloadCSS2_Print'
			),
		'children' => array(new clsLiteral('Unload CSS 2 (print)')),
		'event' => array('onclick', $aFunctions['unloadcss2_print'])
		));

ob_start();
?>

		<script type='text/javascript'>
			/* <![CDATA[ */
			clearLog = function() {
				xajax.$('log').innerHTML = '';
			}
			/* ]]> */
		</script>
		<style type='text/css'>
			/* <![CDATA[ */
			.initiallyHidden {
				visibility: hidden;
			}
			.controls {
				width: 600px;
				border: 1px solid black;
			}
			.logger {
				margin-top: 3px;
				width: 600px;
				border: 1px solid black;
			}
			.log {
				padding: 2px;
			}
			.description {
				margin-top: 3px;
				padding: 2px;
				border: 1px solid #999999;
				font-size: smaller;
				width: 594px;
			}
			.clearLink {
				font-size: smaller;
			}
			/* ]]> */
		</style>
<?
	$objTestScriptPlugin->printHeader($xajax, "Load / Unload CSS files",ob_get_clean());

	ob_start();
?>

						<table cellspacing='0' cellpadding='0'>
							<tbody>
								<tr>
									<td align='center' valign='top' width="50%">
										<div><?php $buttonLoadCSS1->printHTML(); ?><?php $buttonUnloadCSS1->printHTML(); ?></div>
										<div><?php $buttonLoadCSS2->printHTML(); ?><?php $buttonUnloadCSS2->printHTML(); ?></div>
									</td>
									<td valign='top' rowspan='2'>
										<div class='frame'>
											<div class='headerText'>Header Text</div>
											<div class='bodyText'>This is the body text.</div>
											<div class='initiallyHidden tagline'>This is the tagline.</div>
										</div>
									</td>
								</tr>
								<tr>
									<td align='center' valign='top' width="50%">
										<div><?php $buttonLoadCSS1_Print->printHTML(); ?><?php $buttonUnloadCSS1_Print->printHTML(); ?></div>
										<div><?php $buttonLoadCSS2_Print->printHTML(); ?><?php $buttonUnloadCSS2_Print->printHTML(); ?></div>
									</td>
								</tr>
							</tbody>
						</table>
<?
	$objTestScriptPlugin->printControlPanel(ob_get_clean());

	$objTestScriptPlugin->printStatusPanel();
	$objTestScriptPlugin->printLogPanel();
	$objTestScriptPlugin->printDescriptionPanel("
		This test script demonstrates the ability to request the loading and unloading of CSS files from the server side. 
		Click the load button for either CSS1 or CSS2 and watch the browser apply the style changes to the page nearly 
		instantly.  Once loaded, the style changes can be removed with the unload button.  *NEW*  This test script now
		shows the use of the new media (optional parameter).  When you click the load or unload CSS1 and CSS2 for print,
		you can see the changes only in the print preview or on a printed page.
	");
	$objTestScriptPlugin->printFooter();