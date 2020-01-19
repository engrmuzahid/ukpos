<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/960.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/text.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/login.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/form.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<div class="container_16">
  <div class="grid_6 prefix_5 suffix_5">
     <?php echo $content; ?>
  </div>
</div>
<br clear="all" />
</body>
</html>
