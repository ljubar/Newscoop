<?php
require_once($_SERVER['DOCUMENT_ROOT']."/configuration.php");
?>
<table width="100%" cellspacing="20">
	<tr>
		<td valign="top" align="left" width="1%" nowrap>
		<?php
		require_once($Campsite['HTML_DIR'] . "/$ADMIN_DIR/localizer/menu.php");
		?>
		</td>
		<td valign="top" align="left">
		<?php
		if (isset($_REQUEST['display']))
			require_once($Campsite['HTML_DIR'] . "/$ADMIN_DIR/localizer/display.php");
		if (isset($_REQUEST['save']))
			require_once($Campsite['HTML_DIR'] . "/$ADMIN_DIR/localizer/save.php");
		?>
	</tr>
</table>