<?php

class testScriptPlugin extends xajaxResponsePlugin {
	var $bDeferScriptGeneration;

	/*
		Function: testScriptPlugin
		
		Constructor
	*/
	function testScriptPlugin() {
		$this->bDeferScriptGeneration = false;
	}

	/*
		Function: configure
		
		Sets/stores configuration options used by this plugin.
	*/
	function configure($sName, $mValue)
	{
		if ('deferScriptGeneration' == $sName)
		{
			if (true === $mValue || false === $mValue)
				$this->bDeferScriptGeneration = $mValue;
			else if ('deferred' === $mValue)
				$this->bDeferScriptGeneration = $mValue;
		}
	}

	/*
		Function: generateClientScript
		
		Called by the <xajaxPluginManager> during the client script generation
		phase.  This is used to generate a block of javascript code that will
		contain function declarations that can be used on the browser through
		javascript to initiate xajax requests.
	*/
	function generateClientScript()
	{
		if (false === $this->bDeferScriptGeneration || 'deferred' === $this->bDeferScriptGeneration)
		{
			echo "\n<style type='text/css' " . "charset='UTF-8'>\n";
			echo ".controlPanel {\n";
			echo "	float: left;\n";
			echo "	position: relative;\n";
			echo "	width: 60%;\n";
			echo "	border: 1px solid black;\n";
			echo "	margin-top: 1%;\n";
			echo "	padding: 3px;\n";
			echo "}\n";
			echo ".controlPanel_header {\n";
			echo "	text-align: center;\n";
			echo "	background-color: #bbbbbb;\n";
			echo "}\n";
			echo ".controlPanel_headerText {\n";
			echo "}\n";
			echo ".controlPanel_row {\n";
			echo "}\n";
			echo ".statusPanel {\n";
			echo "	float: left;\n";
			echo "	position: relative;\n";
			echo "	width: 30%;\n";
			echo "	border: 1px solid black;\n";
			echo "	margin-top: 1%;\n";
			echo "	margin-left: 1%;\n";
			echo "	padding: 3px;\n";
			echo "}\n";
			echo ".statusPanel_header {\n";
			echo "	text-align: center;\n";
			echo "	background-color: #bbbbbb;\n";
			echo "}\n";
			echo ".statusPanel_headerText {\n";
			echo "}\n";
			echo ".logPanel {\n";
			echo "	float: left;\n";
			echo "	position: relative;\n";
			echo "	width: 91%;\n";
			echo "	border: 1px solid black;\n";
			echo "	margin-top: 1%;\n";
			echo "	padding: 3px;\n";
			echo "}\n";
			echo ".logPanel_header {\n";
			echo "	text-align: center;\n";
			echo "	background-color: #bbbbbb;\n";
			echo "}\n";
			echo ".logPanel_headerText {\n";
			echo "}\n";
			echo ".logPanel_clear {\n";
			echo "}\n";
			echo ".logPanel_clearLink {\n";
			echo "}\n";
			echo ".descriptionPanel {\n";
			echo "	float: left;\n";
			echo "	position: relative;\n";
			echo "	width: 91%;\n";
			echo "	border: 1px solid #999999;\n";
			echo "	margin-top: 1%;\n";
			echo "	margin-bottom: 1px;\n";
			echo "	padding: 3px;\n";
			echo "	font-size: small;\n";
			echo "}\n";
			echo "</style>\n";

			echo "\n<script type='text/javascript' " . "charset='UTF-8'>\n";
			echo "/* <![CDATA[ */\n";
			echo "writeToLog = function() {\n";
			echo "	for (var i = 0; i < arguments.length; ++i)\n";
			echo "		xajax.$('log').innerHTML += arguments[i];\n";
			echo "}\n";
			echo "clearLog = function() {\n";
			echo "	xajax.$('log').innerHTML = '';\n";
			echo "}\n";
			echo "/* ]]> */\n";
			echo "</script>\n";
		}
	}
	
	function printHeader($xajax, $sTitle, $sOptional='',$onload='') {
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">' . "\n";
		echo '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n";
		echo "	<head>\n";
		echo "		<title>{$sTitle}</title>\n";
		echo "		<link rel='stylesheet' href='xajax_tests.css' type='text/css' >\n";
		echo $sOptional;
		$xajax->printJavascript();
		echo "	</head>\n";
		echo "	<body onload=\"".$onload."\">\n";
		echo "		<h1>{$sTitle}</h1>\n";
	}
	
	function printFooter() {
		echo "	</body>\n";
		echo "</html>\n";
	}
	
	function printControlPanel($sControls) {
		echo "		<div class='controlPanel'>\n";
		echo "			<div class='controlPanel_header'>\n";
		echo "				<div class='controlPanel_row'>\n";
		echo "					<span class='controlPanel_headerText'>Controls</span>\n";
		echo "					<div style='clear: both;'></div>\n";
		echo "				</div>\n";
		echo "			</div>\n";
		echo $sControls;
		echo "		</div>\n";
	}
	
	function printStatusPanel($sStatus='') {
		echo "<div class='statusPanel'>\n";
		echo "	<div class='statusPanel_header'>\n";
		echo "		<span class='statusPanel_headerText'>Status</span>\n";
		echo "	</div>\n";
		echo "	<div id='status'>{$sStatus}</div>\n";
		echo "</div>\n";
		echo "<div style='clear: both;'></div>\n";
	}
	
	function printLogPanel() {
		echo "<div class='logPanel'>\n";
		echo "	<div class='logPanel_header'>\n";
		echo "		<span class='logPanel_headerText'>Log\n";
		echo "			<span class='logPanel_clear'>\n";
		echo "				(<a class='logPanel_clearLink' href='#' onclick='clearLog(); return false;'>Clear</a>)\n";
		echo "			</span>\n";
		echo "		</span>\n";
		echo "	</div>\n";
		echo "	<div id='log'></div>\n";
		echo "</div>\n";
		echo "<div style='clear: both;'></div>\n";
	}
	
	function printDescriptionPanel($description='') {
		echo "<div class='descriptionPanel'>\n";
		echo $description;
		echo "</div>\n";
		echo "<div style='clear: both;'></div>\n";
	}
}

$objTestScriptPlugin = new testScriptPlugin();
$objPluginManager =& xajaxPluginManager::getInstance();
$objPluginManager->registerPlugin($objTestScriptPlugin);
