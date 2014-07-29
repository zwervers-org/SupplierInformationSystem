<?php

include 'https://synergy/docs/SysControls.jQuery.js';

echo '<table>
<tr>
<td>
<form id="frmSearchAction" method="post" style="margin-bottom:0" action="https://synergy.otcholland.com/CRMSearch.aspx?SCAction=1" 
	onsubmit=SysSet("QS2",SysTrim2(SysGetElement("QS2").value,true));return SysGetElement("QS2").value.length &gt 0>
<input type="text" id="QS2" style="width:100px;height:20px;vertical-align:middle;">
<input type="button" style="vertical-align:middle;">
</form>';

?>