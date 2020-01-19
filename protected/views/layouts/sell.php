<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <meta name="referrer" content="no-referrer" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/public/images/favicon.ico" type="image/x-icon">
                <link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/menubar.css">
                    <link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/general.css">
                        <link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/register.css">
                            <link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/tables.css">
                                <link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/thickbox.css">
                                    <link rel="stylesheet" rev="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/datepicker.css">
                                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery-1.8.1.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
                                        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/css/jquery.autocomplete.css" />
                                        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/js/jquery.autocomplete.js"></script>
                                        <script src="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
                                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/thickbox.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
                                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/common.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
                                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/manage_tables.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
                                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/date.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
                                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/datepicker.js" type="text/javascript" language="javascript" charset="UTF-8"></script>        
                                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery.nicescroll.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>

                                        <link href="<?php echo Yii::app()->request->baseUrl; ?>/public/plugins/magnific/magnific-popup.css" rel="stylesheet" type="text/css"/>
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

                                        <body style="width: 100%">

                                            <div style="width: 100%">
                                                <?php echo $content; ?>
                                            </div>
                                        </body>
                                        </html>
