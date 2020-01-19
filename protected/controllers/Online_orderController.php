<?php

class Online_orderController extends CController {

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
    public function actionIndex() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
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

            $data['customers'] = Customer::model()->findAll(array('order' => 'customer_name'));
            $this->render('index', $data);

        endif;
    }

    public function actionPendinglist() {
        //   $online_server = "http://localhost/sylhet/";

        $online_server = "http://sylhetshop.co.uk/";
        $cSession = curl_init();
        curl_setopt($cSession, CURLOPT_URL, $online_server . "api/pending_order_listing");
        curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cSession, CURLOPT_HEADER, false);
        $result = curl_exec($cSession);
        curl_close($cSession);
        if ($result != "NOTFOUND") {
            $_result = json_decode($result);
//            print_r($_result);
//            exit();
            foreach ($_result as $order) {
                $order_data = $order->order;
                $existing_sale = Yii::app()->db->createCommand()
                                ->select('invoice_sl')
                                ->where("online_invoice_no = " . $order_data->online_invoice_no)
                                ->from('sell_order')->queryRow();

                if (!$existing_sale) {
                    unset($order_data->id);
                    $sale = Yii::app()->db->createCommand()
                                    ->select('invoice_sl,order_date')
                                    ->order("id DESC")
                                    ->from('sell_order')->queryRow();

                    $invoice_sl = $sale['invoice_sl'];
                    $order_date1 = date("dmy", strtotime($sale['order_date']));
                    $order_date2 = date('dmy');
                    if ($order_date1 == $order_date2):
                        $invoice_sl = $invoice_sl + 1;
                        $invoice_no = $order_date2 . $invoice_sl;
                    else:
                        $invoice_sl = 1;
                        $invoice_no = $order_date2 . $invoice_sl;
                    endif;


                    $order_data->invoice_no = $invoice_no;
                    $order_data->invoice_sl = $invoice_sl;
                    $command = Yii::app()->db->createCommand();

                    $command->insert('sell_order', $order_data);

                    $order_products = $order->products;
                    if (!empty($order_products)) {
                        foreach ($order_products as $product) {
                            $product_data = $product;
                            unset($product_data->id);
                            $product_data->invoice_no = $invoice_no;
                            $product_command = Yii::app()->db->createCommand();
                            $product_command->insert('sell_order_product', $product_data);
                        }
                    }
                }
            }
        }


        if ($_POST['Search']) {
            $cond = "t.order_type = 'online' && t.online_order_status = '" . $_POST['Search']['online_order_status'] . "'";
            $start_date = $_POST['Search']['start_date'];
            $end_date = $_POST['Search']['end_date'];
            if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($start_date));
            else: $start_date = "";
            endif;
            if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($end_date));
            else: $end_date = "";
            endif;


            if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && t.order_date >= '$start_date' && t.order_date <= '$end_date'";
            endif;


            if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && t.order_date = '$start_date'";
            elseif (empty($cond) && !empty($start_date)): $cond .= "t.order_date = '$start_date'";
            endif;

            if ($_POST['Search']['customer_id'] != "") {
                $cond .= " AND customer_id = '{$_POST['Search']['customer_id']}'";
            }

            $conddition = new CDbCriteria(array('condition' => $cond));
        } else {
            $conddition = new CDbCriteria(array('condition' => "t.order_type = 'online' && t.online_order_status = 'pending'"));
        }

        $conddition->order = "print_status DESC";
        $data['orders'] = Sell::model()->findAll($conddition);
        $this->renderPartial('orderlist', $data);
    }

    public function actionOrderlist() {
        //   $this->actionPendinglist();
        if ($_POST['Search']) {
            $cond = "t.order_type = 'online' && t.online_order_status = '" . $_POST['Search']['online_order_status'] . "'";
            $start_date = $_POST['Search']['start_date'];
            $end_date = $_POST['Search']['end_date'];
            if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($start_date));
            else: $start_date = "";
            endif;
            if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($end_date));
            else: $end_date = "";
            endif;


            if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && t.order_date >= '$start_date' && t.order_date <= '$end_date'";
            endif;


            if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && t.order_date = '$start_date'";
            elseif (empty($cond) && !empty($start_date)): $cond .= "t.order_date = '$start_date'";
            endif;

            if ($_POST['Search']['customer_id'] != "") {
                $cond .= " AND customer_id = '{$_POST['Search']['customer_id']}'";
            }

            $conddition = new CDbCriteria(array('condition' => $cond));
        } else {
            $conddition = new CDbCriteria(array('condition' => "t.order_type = 'online' && t.online_order_status = 'pending'"));
        }

        $conddition->order = "print_status DESC";
        $data['orders'] = Sell::model()->findAll($conddition);
        $this->renderPartial('orderlist', $data);
    }

}
