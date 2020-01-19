<?php 
date_default_timezone_set('Europe/London');
$tdate =  date("F d, Y, h:i A", time());
$ttime = date("h:i", time());
$tday = date("D", time());
$ttday = date("d", time());
$tap = date("A", time());
$tmonth = date("F", time());
$tyear = date("Y", time());

?>
	<table id="footer_info">
		<tbody>
        <tr>
			<td id="menubar_footer"> Welcome <b> <?php echo Yii::app()->user->name; ?> | </b>			<a href="<?php echo Yii::app()->request->baseUrl.'/site/logout'; ?>">Logout</a>			</td>
	
			<td id="menubar_date_time" class="menu_date"><?php echo $ttime; ?></td>
			<td id="menubar_date_day" class="menu_date mini_date"><?php echo $tday; ?><br><?php echo $tap; ?></td>
			<td id="menubar_date_spacer" class="menu_date">|</td>
			<td id="menubar_date_date" class="menu_date"><?php echo $ttday; ?></td>
			<td id="menubar_date_monthyr" class="menu_date mini_date"><?php echo $tmonth; ?><br><?php echo $tyear; ?></td>
		</tr>
	</tbody>
    </table>
    	
	<div id="footer_spacer"></div>

	<table id="footer">
		<tbody>
        <tr>
			<td id="footer_cred" colspan="2">&nbsp;</td>
		</tr>
	</tbody>
   </table>
