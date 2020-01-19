<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/public/images/favicon.ico" type="image/x-icon">

<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/login.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery-1.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#login_form input:first").focus();
});
</script>
</head>

<body>
    <div id="container">
	<div id="top"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/header_logo.png" alt="">	</div>
	<?php echo $content; ?>
    <?php $this->beginContent('/layouts/site_footer'); ?><?php $this->endContent(); ?>
</div>

</body></html>

