<?php

class CustomerController extends CController {

    public $layout = 'backend';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to access 'index' and 'view' actions.
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated users to access all actions
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();

            $criteria->condition = "status = 'approved'";
            $filter_day = null;
            if (isset($_GET['filter_day'])) {
                $criteria->condition .= " AND order_day='{$_GET['filter_day']}' ";
                $filter_day = $_GET['filter_day'];
            }

            $count = Customer::model()->count($criteria);
            $pages = new CPagination($count);
            // elements per page
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);

            $criteria->order = 'id DESC';
            $models = Customer::model()->findAll($criteria);
            $this->render('index', array('models' => $models, 'total' => $count, 'pages' => $pages, 'filter_day' => $filter_day));

        endif;
    }

    public function actionDoneChecking() {
        $customer_id = $_REQUEST['customer_id'];
        $model = Customer::model()->findByPk($customer_id);
        if ($model->checkingDone == 1) {
            $newFlag = 0;
        } else {
            $newFlag = 1;
        }
        $model->checkingDone = $newFlag;
        $model->save();
        //$model->update(array('checkingDone'=>$newFlag));
        echo $newFlag == 1 ? 'CHECKED' : 'N-CHECKED';
    }

    public function actionClearChecking() {
        Customer::model()->updateAll(array('checkingDone' => 0));
    }

    public function actionAdd() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Customer();
            $data = Yii::app()->request->getPost('Customer');
            if ($data) {
                $model->setAttributes($data);
                $as = CUploadedFile::getInstance($model, 'customer_photo');
                if (!empty($as)): $model->customer_photo = $as;
                endif;
                if ($model->save()) {
                    if (!empty($as)):
                        $image_path = Yii::getPathOfAlias('webroot') . '/public/photos/customer/' . $model->customer_photo;
                        $model->customer_photo->saveAs($image_path);
                    endif;
                    Yii::app()->user->setFlash('saveMessage', 'Customer Information Saved Successfully....<a href="' . Yii::app()->request->baseUrl . '/index.php/customer/add">Add New</a> &nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/index.php/customer">View All</a>');
                    $this->refresh();
                }
            }
            $this->render('add', array('model' => $model,));
        endif;
    }

    public function actionEdit($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = Customer::model()->findByPk($id);
            if (!$model)
                throw new CHttpException(404);
            $data = Yii::app()->request->getPost('Customer');
            if ($data) {
                $model->setAttributes($data);
                $as = CUploadedFile::getInstance($model, 'customer_photo');
                if (!empty($as)): $model->customer_photo = $as;
                endif;

                if ($model->save()) {
                    if (!empty($as)):
                        $image_path = Yii::getPathOfAlias('webroot') . '/public/photos/customer/' . $model->customer_photo;
                        $model->customer_photo->saveAs($image_path);
                    endif;
                    Yii::app()->user->setFlash('saveMessage', 'Customer Information Modified Successfully...&nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/index.php/customer">View All</a>');
                    $this->refresh();
                }
            }
            $this->render('edit', array('model' => $model,));
        endif;
    }

    public function actionSearch() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:

            $model = new Customer();
            if ($_POST) {
                $customer_name = $_POST['customer_name'];

                $cond = '';
                if (!empty($cond) && !empty($customer_name)): $cond .= " && customer_name like '%$customer_name%'";
                elseif (empty($cond) && !empty($customer_name)): $cond .= " customer_name like '%$customer_name%'";
                endif;
                $criteria = new CDbCriteria();
                $criteria->condition = $cond;
                $criteria->order = 'id DESC';
                $model = Customer::model()->findAll($criteria);
                $this->render('search', array('models' => $model,));
            }
        endif;
    }

    public function actionDelete($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;


            $sellExt = new CDbCriteria(array('condition' => "customer_id = '$id'",));
            $sellVal = Sell::model()->findAll($sellExt);

            $payExt = new CDbCriteria(array('condition' => "customer_id = '$id'",));
            $payVal = Account_Received::model()->findAll($payExt);


            if (count($sellVal) or count($payVal)):
                Yii::app()->user->setFlash('saveMessage', 'Sorry! this Customer is available in one or more sell or accounts..');
                $this->redirect(array('customer/index'));
            else:
                $model = Customer::model()->findByPk($id);
                $model->delete();
                Yii::app()->user->setFlash('saveMessage', 'Customer deleted successfully.');
                $this->redirect(array('customer/index'));
            endif;

        endif;
    }

    public function actionView($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();
            $criteria->condition = "id = '$id'";
            $models = Customer::model()->findAll($criteria);
            $this->render('view', array('models' => $models,));

        endif;
    }

    public function actionPending() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();

            $count = Customer::model()->count($criteria);
            $pages = new CPagination($count);
            // elements per page
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);
            $criteria->condition = "status = 'pending'";
            $criteria->order = 'id DESC';
            $models = Customer::model()->findAll($criteria);
            $this->render('pending', array('models' => $models, 'pages' => $pages,));

        endif;
    }

    // cash transection report

    public function actionReceiable_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Account_Received();

            if ($_POST) {
                $customer_id = $_POST['customer_id'];

                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($_POST['start_date']));
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($_POST['end_date']));
                endif;
                $cond = "status = 0 && cash_sell=0";
                if (!empty($start_date) && !empty($end_date)): $cond .= " && order_date >= '$start_date' && order_date <= '$end_date'";
                elseif (!empty($start_date) && empty($end_date)): $cond .= " && order_date = '$start_date'";
                elseif (empty($start_date) && !empty($end_date)): $cond .= " && order_date <= '$end_date'";
                endif;
                if (!empty($customer_id)): $cond .= " && customer_id = '$customer_id'";
                endif;
                if (empty($customer_id)): $cond .= " && customer_id != ''";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Sell::model()->findAll($cond2);

                $sells = array();
                $amountSummary = array();
                foreach ($model as $result) {
                    $sells[$result->customer_id][] = $result;
                    if (!isset($amountSummary[$result->customer_id]['total'])) {
                        $amountSummary[$result->customer_id]['total'] = $result->amount_grand_total;
                        $amountSummary[$result->customer_id]['paid'] = $result->paid_amount;
                    } else {
                        $amountSummary[$result->customer_id]['total'] += $result->amount_grand_total;
                        $amountSummary[$result->customer_id]['paid'] += $result->paid_amount;
                    }
                }

                $data['model'] = $sells;
                $data['accountSummary'] = $amountSummary;

                $data['customer_id'] = $customer_id;
                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                $this->render('account_receiable_report', $data);
            } else {

                $this->render('account_receiable_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionEmail_Config() {

        require_once(getcwd() . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR . 'PHPMailerAutoload.php');

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = "muzahid.ginilab@gmail.com";
        $mail->Password = "Monjachai123!@#";

        return $mail;
    }

    public function actionSend_Email() {

        require_once(getcwd() . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR . 'PHPMailerAutoload.php');

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = "muzahid.ginilab@gmail.com";
        $mail->Password = "Monjachai123!@#";
        $mail->setFrom('from@example.com', 'First Last');
        $mail->addReplyTo('replyto@example.com', 'First Last');

        $mail->addAddress('muzahid_cse@live.com', 'John Doe');
        $mail->Subject = 'PHPMailer GMail SMTP test';
        $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

        $mail->AltBody = 'This is a plain-text message body';
        require_once(getcwd() . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'MPDF57' . DIRECTORY_SEPARATOR . 'mpdf.php');
        $invoice_no = '26071577';
        $cond = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'",));
        $models = Sell::model()->findAll($cond);
        $model_products = Sell_Product::model()->findAll($cond);
        $html = $this->renderPartial('pdfview', array('models' => $models, 'model_products' => $model_products,), TRUE);
        $mpdf = new mPDF();
        $mpdf->WriteHTML($html);
        $mpdf->Output($invoice_no . '.pdf', 'F');

        $mail->addAttachment('images/phpmailer_mini.png');
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

    public function actionSend_Receiable_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Account_Received();

            if ($_POST) {
                $customer_id = $_POST['customer_id'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($_POST['start_date']));
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($_POST['end_date']));
                endif;
                $cond = "status = 0 && cash_sell=0";
                if (!empty($start_date) && !empty($end_date)): $cond .= " && order_date >= '$start_date' && order_date <= '$end_date'";
                elseif (!empty($start_date) && empty($end_date)): $cond .= " && order_date = '$start_date'";
                elseif (empty($start_date) && !empty($end_date)): $cond .= " && order_date <= '$end_date'";
                endif;
                if (!empty($customer_id)): $cond .= " && customer_id = '$customer_id'";
                endif;
                if (empty($customer_id)): $cond .= " && customer_id != ''";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Sell::model()->findAll($cond2);
                require_once(getcwd() . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'Yiimail' . DIRECTORY_SEPARATOR . 'Yiimail.php');
                $mail = Yiimail();

                $sells = array();
                $amountSummary = array();
                foreach ($model as $result) {
                    $sells[$result->customer_id][] = $result;
                    if (!isset($amountSummary[$result->customer_id]['total'])) {
                        $amountSummary[$result->customer_id]['total'] = $result->amount_grand_total;
                        $amountSummary[$result->customer_id]['paid'] = $result->paid_amount;
                    } else {
                        $amountSummary[$result->customer_id]['total'] += $result->amount_grand_total;
                        $amountSummary[$result->customer_id]['paid'] += $result->paid_amount;
                    }
                    $customer_ids[$result->customer_id] = $result->customer_id;
                }


                foreach ($customer_ids as $customer_id) {
                    $data['customer_id'] = $customer_id;
                    $data['sells'] = $sells[$customer_id];
                    $data['accountSummary'][$customer_id] = $amountSummary[$customer_id];
                    $Customer = Customer::model()->findAllByPk($customer_id);

                    $message = "";
                    $message .= $this->renderPartial('send_receiable_report', $data, true);
                    $mail->addAddress($Customer['email_address'], $Customer['customer_name']);
                    //$mail->addAddress("mzahidul@gmail.com", $Customer['customer_name']);
                    // $mail->addAddress("muzahid_cse@live.com", $Customer['customer_name']);
                    $mail->Subject = 'Account Statement';
                    $mail->msgHTML($message);
                    $mail->AltBody = 'Account Receiable Report';
                    $mail->send();
                    $message = "";
                }
                if (!$mail->ErrorInfo) {
                    echo "DONE";
                }
            } else {
                $this->render('account_receiable_report_form', array('model' => $model));
            }
        endif;
    }

    public function actionCash_Receiable_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Account_Received();

            if ($_POST) {
                $customer_id = $_POST['customer_id'];

                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($_POST['start_date']));
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($_POST['end_date']));
                endif;

                $cond = "status = 0 && cash_sell=1";

                if (!empty($start_date) && !empty($end_date)): $cond .= " && order_date >= '$start_date' && order_date <= '$end_date'";
                elseif (!empty($start_date) && empty($end_date)): $cond .= " && order_date = '$start_date'";
                elseif (empty($start_date) && !empty($end_date)): $cond .= " && order_date <= '$end_date'";
                endif;
                if (!empty($customer_id)): $cond .= " && customer_id = '$customer_id'";
                endif;
                if (empty($customer_id)): $cond .= " && customer_id != ''";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Sell::model()->findAll($cond2);

                $sells = array();
                $amountSummary = array();
                foreach ($model as $result) {
                    $sells[$result->customer_id][] = $result;
                    if (!isset($amountSummary[$result->customer_id]['total'])) {
                        $amountSummary[$result->customer_id]['total'] = $result->amount_grand_total;
                        $amountSummary[$result->customer_id]['paid'] = $result->paid_amount;
                    } else {
                        $amountSummary[$result->customer_id]['total'] += $result->amount_grand_total;
                        $amountSummary[$result->customer_id]['paid'] += $result->paid_amount;
                    }
                }

                $this->render('account_receiable_report', array('model' => $sells, 'accountSummary' => $amountSummary));
            } else {
                $this->render('account_receiable_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionReceived_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Account_Received();

            if ($_POST) {
                $customer_id = $_POST['customer_id'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($_POST['start_date']));
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($_POST['end_date']));
                endif;
                $cond = '';

                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && receive_date >= '$start_date' && receive_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " receive_date >= '$start_date' && receive_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && receive_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " receive_date = '$start_date'";
                endif;
                if (!empty($cond) && !empty($customer_id)): $cond .= " && customer_id = '$customer_id'";
                elseif (empty($cond) && !empty($customer_id)): $cond .= " customer_id = '$customer_id'";
                endif;
                if (!empty($cond) && empty($customer_id)): $cond .= " && customer_id != ''";
                elseif (empty($cond) && empty($customer_id)): $cond .= " customer_id != ''";
                endif;
                if ($cond == '')
                    $cond .= ' amount > 0';
                else
                    $cond .= ' && amount > 0';

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $cond2->order = "receive_date desc";
                $model = Account_Received::model()->findAll($cond2);
                $this->render('account_received_report', array('model' => $model,));
            }
            else {
                $this->render('account_received_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionReceive_add($id = NULL) {


        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $user = Users::model()->find($cond);
            if ($user):
                if ($user->accounts_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endif;

            $username = Yii::app()->user->name;


            if (!empty($_POST) && !empty($_POST['customer_id']) && $_POST['receive_mode'] != '') {

                $user_id = Yii::app()->user->name;
                $invoice_no = $_POST['invoice_no'];
                $customer_id = $_POST['customer_id'];
                $receive_date = $_POST['receive_date'];
                $receive_mode = $_POST['receive_mode'];
                $amount = $_POST['amount'];
                $discount = (float) $_POST['discount'];

                $amount_grand_total = (float) $_POST['amount_grand_total'] - $discount;
                $paid_amount = $_POST['paid_amount'];
                $paid_total = $paid_amount + $amount;
                if ($paid_total == $amount_grand_total): $status = 1;
                else: $status = 0;
                endif;

                $created = date('Y-m-d', time());

//				if($receive_mode == 0):				 
//					 $criteria2 = new CDbCriteria();
//					 $criteria2->order = 'id DESC';
//					 $criteria2->limit = 1;
//					 $cash_values = Cash_In_Hand::model()->findAll($criteria2);					 
//                                        if(count($cash_values)):
//						 foreach($cash_values as $cash_value): $cash_amount = $cash_value->amount; $cash_id = $cash_value->id; endforeach;
//						  $command = Yii::app()->db->createCommand();
//						  $command->update('cash_in_hand', array( 'amount' => $cash_amount + $amount,), "id = '$cash_id'");
//					  else:
//						  $command = Yii::app()->db->createCommand();
//						  $command->insert('cash_in_hand', array('amount' => $amount));
//					  endif;
//					  
//					     $command->insert('cash_in_hand_transaction', array(
//									'transaction_date' => 	$receive_date,
//									'status'           => 	0,
//									'amount'           => 	$amount,
//						          ));
//				   endif;

                $command = Yii::app()->db->createCommand();
                $cond = "invoice_no = '$invoice_no'";

                $command->insert('account_receive', array(
                    'invoice_no' => $invoice_no,
                    'customer_id' => $customer_id,
                    'receive_date' => $receive_date,
                    'receive_mode' => $receive_mode,
                    'amount' => $amount,
                ));

                if ($status == 1 && @$_POST['cash_sell'] == 1) {
                    $customer_id = 0;
                }

                $crt = new CDbCriteria();
                $crt->condition = "invoice_no = '$invoice_no'";
                $sell_order = Sell::model()->find($crt);
                $command->update('sell_order', array('user_id' => $user_id, 'customer_id' => $customer_id, 'amount_grand_total' => $amount_grand_total, 'paid_amount' => $paid_total, 'status' => $status, 'discount_ratio' => $sell_order->discount_ratio + $discount), $cond);

                Yii::app()->user->setFlash('saveMessage', 'Payment Received Successfully....');
                $this->refresh();
            } else {
                $in_id = @$_POST['invoice_no'];
                if (!empty($in_id)): $id = $in_id;
                else: $id = $id;
                endif;
                $criteria = new CDbCriteria();
                $criteria->condition = "invoice_no = '$id'";
                $criteria->order = 'id DESC';
                $model = Sell::model()->findAll($criteria);
                $model2 = Sell_Product::model()->findAll($criteria);
                $this->render('receive_add', array('model' => $model, 'model2' => $model2, 'invoice_no' => $id,));
            }
        endif;
    }

    public function actionReceive_bulk_add() {

        if (!empty($_POST) && !empty($_POST['customer_id']) && $_POST['receive_mode'] != '') {
            $invoice_nos = explode(",", $_POST['invoice_no']);
            $customer_id = $_POST['customer_id'];
            $receive_date = $_POST['receive_date'];
            $receive_mode = $_POST['receive_mode'];
            $discount = (float) $_POST['discount'];
            $total_amount = $_POST['amount'];
            $model = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('sell_order')
                    ->where(array('in', 'invoice_no', $invoice_nos))
                    ->queryAll();

            foreach ($model as $inv) {
                $invoice = (object) $inv;
                $user_id = Yii::app()->user->name;
                $invoice_no = $invoice->invoice_no;
                $paid_amount = $invoice->paid_amount;

                $amount_grand_total = (float) $invoice->amount_grand_total - $paid_amount;

                if ($amount_grand_total > 0 && $total_amount > 0) {
                    if ($amount_grand_total < $total_amount || $amount_grand_total == $total_amount) {
                        $paid_total = $amount_grand_total;
                        $status = 1;
                        $discount = 0.0;
                    }   else {
                        $paid_total = $total_amount;
                        $status = 0;
                        $discount = (float) $_POST['discount'];
                    }
                    $total_amount -= $paid_total;
                }


                $created = date('Y-m-d', time());
                $command = Yii::app()->db->createCommand();
                $cond = "invoice_no = '$invoice_no'";

                $insert_array = array(
                    'invoice_no' => $invoice_no,
                    'customer_id' => $customer_id,
                    'receive_date' => $receive_date,
                    'receive_mode' => $receive_mode,
                    'amount' => $paid_total,
                );
                $command->insert('account_receive', $insert_array);

                $crt = new CDbCriteria();
                $crt->condition = "invoice_no = '$invoice_no'";
                $sell_order = Sell::model()->find($crt);
                if ($paid_amount > 0) {
                    $command->update('sell_order', array('user_id' => $user_id, 'customer_id' => $customer_id, 'amount_grand_total' => $invoice->amount_grand_total, 'paid_amount' => ($paid_total + $paid_amount), 'status' => $status, 'discount_ratio' => $sell_order->discount_ratio + $discount), $cond);
                } else {
                    $command->update('sell_order', array('user_id' => $user_id, 'customer_id' => $customer_id, 'amount_grand_total' => $invoice->amount_grand_total, 'paid_amount' => $paid_total, 'status' => $status, 'discount_ratio' => $sell_order->discount_ratio + $discount), $cond);
                }
            }
            Yii::app()->user->setFlash('saveMessage', 'Invoice : ' . $_POST['invoice_no'] . ' payment Received Successfully....');
            $this->render('bluk_receive', array('model' => array(), 'model2' => array(), 'invoices' => ''));
        } else {
            Yii::app()->user->setFlash('saveMessage', 'Payment Received Successfully....');
            $this->render('bluk_receive', array('model' => array(), 'model2' => array(), 'invoices' => ''));
        }
    }

    public function actionBulk_receive() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $user = Users::model()->find($cond);
            if ($user):
                if ($user->accounts_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endif;

            $username = Yii::app()->user->name;


            $model = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('sell_order')
                    ->where(array('in', 'invoice_no', $_POST['invoice_number']))
                    ->queryAll();

            $model2 = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('sell_order_product')
                    ->where(array('in', 'invoice_no', $_POST['invoice_number']))
                    ->queryAll();

            $this->render('bluk_receive', array('model' => $model, 'model2' => $model2, 'invoices' => implode(",", $_POST['invoice_number'])));

        endif;
    }

    public function actionCashTrans_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Cash_In_Hands();

            if ($_POST) {
                $status = $_POST['status'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $cond = '';

                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && transaction_date >= '$start_date' && transaction_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " transaction_date >= '$start_date' && transaction_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && transaction_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " transaction_date = '$start_date'";
                endif;
                if (!empty($cond) && !empty($status)): $cond .= " && status = '$status'";
                elseif (empty($cond) && !empty($status)): $cond .= " status = '$status'";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Cash_In_Hands::model()->findAll($cond2);


                $this->render('cash_transaction_report', array('model' => $model,));
            }
            else {
                $this->render('cash_transaction_report_form', array('model' => $model,));
            }
        endif;
    }

    // new update for B2B
    public function actionB2breport() {

        Driver::model()->findAll();

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Sell();
            if (count($_POST)) {
                $cond = "customer_id != '' && customer_id != 0";
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $customer_id = $_POST['customer_id'];

                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= "&& order_date >= '$start_date' && order_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= "order_date >= '$start_date' && order_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && order_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date)): $cond .= "order_date = '$start_date'";
                endif;
                if (!empty($cond) && !empty($customer_id)): $cond .= " && customer_id = '$customer_id'";
                elseif (empty($cond) && !empty($customer_id)): $cond .= "customer_id = '$customer_id'";
                endif;

                $criteria = new CDbCriteria();
                $criteria->condition = $cond;
                $criteria->order = 'id ASC';
                $model = Sell::model()->findAll($criteria);

                $data['drivers'] = Driver::model()->findAll();
                $data['cars'] = CarDetails::model()->findAll();
                $data['model'] = $model;


                $this->render('b2b_sell_report', $data);
            }
            else {
                $this->render('b2b_sell_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionDelivery_report() {

        if (Yii::app()->user->name == 'Guest') {
            $this->redirect(array('site/login'));
        } else {
            if ($_POST) {
                //                echo "<pre>";
                //                print_r($_POST);
                //                exit();
                $data['driver'] = Driver::model()->findByPk($_POST['driver_id']);
                $data['car'] = CarDetails::model()->findByPk($_POST['car_id']);
                foreach ($_POST as $key => $value) {
                    if (substr($key, 0, 9) == 'checkbox_') {
                        $command = Yii::app()->db->createCommand();
                        $command->insert('car_driver', array(
                            'driver_id' => $_POST['driver_id'],
                            'car_id' => $_POST['car_id'],
                            'date' => date("d-m-y", strtotime("NOW"))
                        ));

                        if (!empty($cond) && !empty($value)): $cond .= " || invoice_no = '$value'";
                            $invoices .= ', ' . $value;
                        elseif (empty($cond) && !empty($value)): $cond .= "invoice_no = '$value'";
                            $invoices .= $value;
                        endif;
                    }
                }
                $data['invoices'] = $invoices;
                $data['reports'] = Yii::app()->db->createCommand("SELECT *,SUM(amount_grand_total) As customer_amount FROM sell_order WHERE invoice_no IN  (" . $invoices . ") group by customer_id")
                        ->queryAll();

                $this->renderPartial('delivery_report', $data);
            }
        }
    }

    public function actionB2b_list() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            if ($_POST):

                $cond = '';
                $invoices = '';
                // Search checkbox in post array
                foreach ($_POST as $key => $value) {
                    // If checkbox found
                    if (substr($key, 0, 9) == 'checkbox_') {
                        // Unactivate Content based on checkbox value (id)
                        $command = Yii::app()->db->createCommand();
                        $command->update('sell_order', array('print_status' => 1,), "invoice_no = '$value'");

                        if (!empty($cond) && !empty($value)): $cond .= " || invoice_no = '$value'";
                            $invoices .= ', ' . $value;
                        elseif (empty($cond) && !empty($value)): $cond .= "invoice_no = '$value'";
                            $invoices .= $value;
                        endif;
                    }
                }

                if (count($cond)): $cond .= " && product_code = product_code";
                else: $cond .= "product_code = product_code";
                endif;
                $model = Sell_Product::model()->findAllBySql("select product_code, sum(quantity) AS quantity, amount FROM sell_order_product WHERE {$cond} GROUP BY product_code");

                $this->render('b2b_sell_item_list', array('model' => $model, 'invoices' => $invoices));
            endif;
        endif;
    }

    public function actionGenerate_b2b_list() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            if ($_POST):
                $invoices = $_POST['invoices'];
                $product_name = $_POST['product_name'];
                $quantity = $_POST['quantity'];
                $comment = $_POST['comment'];
                $q_total = $_POST['q_total'];

                $this->render('b2b_sell_item_list2', array('invoices' => $invoices, 'product_name' => $product_name, 'comment' => $comment, 'quantity' => $quantity, 'q_total' => $q_total));
            endif;
        endif;
    }

    public function actionBankTrans_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Cash_In_Banks();

            if ($_POST) {
                $status = $_POST['status'];

                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($_POST['start_date']));
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($_POST['end_date']));
                endif;

                $bank_id = $_POST['d_bank_id'];
                $account_no = $_POST['d_account_no'];

                $cond = '';

                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && transaction_date >= '$start_date' && transaction_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " transaction_date >= '$start_date' && transaction_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && transaction_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " transaction_date = '$start_date'";
                endif;
                if (!empty($cond) && !empty($status)): $cond .= " && status = '$status'";
                elseif (empty($cond) && !empty($status)): $cond .= " status = '$status'";
                endif;
                if (!empty($cond) && !empty($bank_id)): $cond .= " && bank_id = '$bank_id'";
                elseif (empty($cond) && !empty($bank_id)): $cond .= " bank_id = '$bank_id'";
                endif;
                if (!empty($cond) && !empty($account_no)): $cond .= " && account_no = '$account_no'";
                elseif (empty($cond) && !empty($account_no)): $cond .= " account_no = '$account_no'";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Cash_In_Banks::model()->findAll($cond2);
                $this->render('bank_transaction_report', array('model' => $model,));
            }
            else {
                $this->render('bank_transaction_report_form', array('model' => $model,));
            }
        endif;
    }

}
