<?php
/**
 * Copyright (C) 2009	Kirill Krasnov
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

html_page_top1( plugin_lang_get( 'title' ) );
html_page_top2();
?>

<form action="<?php echo plugin_page( "search" ); ?>" method="post">
<?php echo form_security_field( 'plugin_Search_search_press' ) ?>
<table style="width:60%;max-width:1000px;min-width:300px;margin:auto;">
	<tr>
		<td style="padding:.25em;"><a href="<?php echo config_get( "path" ); ?>"><img src="<?php echo config_get( "logo_image" ); ?>" border=0 alt="MantisBT"></a></td>
		<td id=text style="padding:.25em;"><input name=text size=50 maxlength=300></td>
		<td style="padding:.25em;"><input type=submit value="<?php echo plugin_lang_get( 'search_button' ); ?>"></td>
	</tr>
</table>
</form>
<?php
html_page_bottom1( );