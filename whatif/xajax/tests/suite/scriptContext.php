<?php
	/*
		File: scriptContext.php
		
		Test script that uses the context call option to provide an object (or array)
		that can be manipulated by the following commands via the 'this' keyword:
			- <xajaxResponse->script>
			- <xajaxResponse->call>
			- <xajaxResponse->waitFor>
			- <xajaxResponse->contextAssign>
			- <xajaxResponse->contextAppend>
			- etc...
	*/

	require_once("./options.inc.php");
	
	require_once('./testScriptPlugin.inc.php');
		
	$objResponse = new xajaxResponse();
	
	function modifyValue() {
		$objResponse = new xajaxResponse();
		$objResponse->script('if (undefined == this.value) this.value = 1; else this.value += 1;');
		$objResponse->call('this.logValue');
		return $objResponse;
	}
	
	function callFunction() {
	    $value = 'no value provided';
	    if (0 < func_num_args()) {
    	    $args = func_get_args();
    	    $value = $args[0];
    	}
		$objResponse = new xajaxResponse();
		$objResponse->call('this.myFunction', null, 0, -10.5, 'abc', true, false, $value);
		return $objResponse;
	}
	
	$req_Mv = $xajax->register(XAJAX_FUNCTION, 'modifyValue');
	$req_Cf = $xajax->register(XAJAX_FUNCTION, 'callFunction');
	
	$req_Mv_Mo = $xajax->register(XAJAX_FUNCTION, 'modifyValue', array('context' => 'myObject', 'alias' => 'modifyValue_myObject'));
	$req_Cf_Mo = $xajax->register(XAJAX_FUNCTION, 'callFunction', array('context' => 'myObject', 'alias' => 'callFunction_myObject'));
	
	$xajax->processRequest();

	ob_start();
?>
		<script type="text/javascript">
			/* <![CDATA[ */
			value = 0;
			logValue = function() {
				writeToLog('Value updated: ', value, '<br />');
			}
			myFunction = function() {
				writeToLog('Global myFunction called');
				if (0 < arguments.length) {
				    writeToLog(' with ', arguments.length, ' arguments:');
				    for (var argName = 0; argName < arguments.length; ++argName) {
				        writeToLog(' [', argName, ':');
				        if ('undefined' == typeof arguments[argName])
				            writeToLog('(undefined)');
				        else if (null == arguments[argName])
				            writeToLog('(null)');
				        else
				            writeToLog('(', typeof arguments[argName], '):', arguments[argName]);
				        writeToLog(']');
				    }
				}
				writeToLog('.<br />');
			}
			myObject = { value: 1000 };
			myObject.myFunction = function() {
				writeToLog('myObject.myFunction called');
				if (0 < arguments.length) {
				    writeToLog(' with ', arguments.length, ' arguments:');
				    for (var argName = 0; argName < arguments.length; ++argName) {
				        writeToLog(' [', argName, ':');
				        if ('undefined' == typeof arguments[argName])
				            writeToLog('(undefined)');
				        else if (null == arguments[argName])
				            writeToLog('(null)');
				        else
				            writeToLog('(', typeof arguments[argName], '):', arguments[argName]);
				        writeToLog(']');
				    }
				}
				writeToLog('.<br />');
			}
			myObject.logValue = function() {
				writeToLog('Value updated: ', this.value, '<br />');
			}
			myObject.callFunction = function() {
				xajax.request( { xjxfun: 'callFunction' }, { context: this } );
				return false;
			}
			/* ]]> */
		</script>
		<style type='text/css'>
			/* <![CDATA[ */
			.controlPanel_cell {
				float: left;
				position: relative;
				width: 33%;
			}
			.endRow {
				clear: both;
			}
			/* ]]> */
		</style>
<?php
	$objTestScriptPlugin->printHeader($xajax, "Script Context", ob_get_clean());
	ob_start();
?>
			<div class='controlPanel_row'>
				<div class='controlPanel_cell'>
					Global:
				</div>
				<div class='endRow'></div>
			</div>
			<div class='controlPanel_row'>
				<div class='controlPanel_cell'>
					<input type='submit' value='Increment Counter' 
						onclick='xajax.$("log").innerHTML += "Incrementing global counter<br />"; <?php $req_Mv->printScript(); ?>; return false;' />
				</div>
				<div class='controlPanel_cell'>
					<input type='submit' value='Call Function' 
						onclick='xajax.$("log").innerHTML += "Calling global function<br />"; <?php $req_Cf->printScript(); ?>; return false;' />
				</div>
				<div class='endRow'></div>
			</div>
			<div class='controlPanel_row'>
				<div class='controlPanel_cell'>
					Object level:
				</div>
				<div class='endRow'></div>
			</div>
			<div class='controlPanel_row'>
				<div class='controlPanel_cell'>
					<input type='submit' value='Increment Counter' 
						onclick='xajax.$("log").innerHTML += "Incrementing member counter<br />"; <?php $req_Mv_Mo->printScript(); ?>; return false;' />
				</div>
				<div class='controlPanel_cell'>
					<input type='submit' value='Call Function' 
						onclick='xajax.$("log").innerHTML += "Calling method<br />"; <?php $req_Cf_Mo->printScript(); ?>; return false;' />
				</div>
				<div class='controlPanel_cell'>
					<input type='submit' value='Call Function (alt method)' 
						onclick='xajax.$("log").innerHTML += "Calling method (alternate method)<br />"; myObject.callFunction(); return false;' />
				</div>
				<div class='endRow'></div>
			</div>
			<div class='controlPanel_row'>
				<div class='controlPanel_cell'>
					Miscellaneous:
				</div>
				<div class='endRow'></div>
			</div>
			<div class='controlPanel_row'>
				<div class='controlPanel_cell'>
					<input type='submit' value='Call Func (with:null)' 
						onclick='xajax.$("log").innerHTML += "Calling global function with a null parameter<br />"; <?php $req_Cf->setParameter(0, XAJAX_JS_VALUE, 'null'); $req_Cf->printScript(); ?>; return false;' />
				</div>
				<div class='controlPanel_cell'>
					<input type='submit' value='Call Func (with:undefined)' 
						onclick='var notDef = {}; xajax.$("log").innerHTML += "Calling global function with an undefined parameter<br />"; <?php $req_Cf->setParameter(0, XAJAX_JS_VALUE, 'notDef.x'); $req_Cf->printScript(); ?>; return false;' />
				</div>
				<div class='controlPanel_cell'>
					<input type='submit' value='Call Func (with:string)' 
						onclick='xajax.$("log").innerHTML += "Calling global function with a javascript string containing a number (should return as a string, not a number)<br />"; <?php $req_Cf->setParameter(0, XAJAX_QUOTED_VALUE, '10.5'); $req_Cf->printScript(); ?>; return false;' />
				</div>
				<div class='endRow'></div>
			</div>
<?php
	$objTestScriptPlugin->printControlPanel(ob_get_clean());
	$objTestScriptPlugin->printStatusPanel();
	$objTestScriptPlugin->printLogPanel();
	$objTestScriptPlugin->printDescriptionPanel(
		"The purpose of this test script is to show how you can use xajax to "
		. "invoke functions and access variables on the browser from the server, "
		. "whereby the javascript on the browser determines the location of those "
		. "functions and variables.  This is called Script Context; the context "
		. "of the script on the browser is maintained accross the server call.  "
		. "The script set's the current context (either global scope or a "
		. "javascript object), then calls the server script.  The server script "
		. "then uses the 'this' keyword to access the functions and variables that "
		. "it needs and xajax ensures that the proper context is maintained and "
		. "used for the processing of that xajax call."
		);
	$objTestScriptPlugin->printFooter();
?>
