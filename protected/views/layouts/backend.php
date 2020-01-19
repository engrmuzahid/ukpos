<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
<meta name="referrer" content="no-referrer" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/public/images/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/phppos.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/menubar.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/general.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/popupbox.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/register.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/receipt.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/reports.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/tables.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/thickbox.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/datepicker.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/editsale.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/footer.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/css3.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jquery-ui-1.css">	
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/phppos_print.css" media="print">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jquery.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/cart.css">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jquery.autocomplete.css">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/public/plugins/magnific/magnific-popup.css" rel="stylesheet" type="text/css"/>
      
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery-1.8.1.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/thickbox.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/common.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/manage_tables.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/date.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/datepicker.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery_002.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery.jqprint.0.3.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/plugins/magnific/jquery.magnific-popup.js"></script>

    <script type="text/javascript">
	Date.format = 'mm/dd/yyyy';
	</script>
<style type="text/css">
html {
    overflow: auto;
}
</style>

</head>

<body>
<div id="menubar">
   <?php $this->beginContent('/layouts/site_top_menu'); ?> <?php $this->endContent(); ?>
</div>
<div id="content_area_wrapper">
<div id="content_area">
<br>
 <?php echo $content; ?>
</div>
</div>
 <?php $this->beginContent('/layouts/site_admin_footer'); ?><?php $this->endContent(); ?>
</body>
</html>
