<?php

class B2b_SellController extends CController {

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
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();
            $criteria->condition = "customer_id != '0'";
            $count = Sell::model()->count($criteria);
            $pages = new CPagination($count);
            // elements per page
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);

            $criteria->order = 'id DESC';
            $models = Sell::model()->findAll($criteria);
            $this->render('index', array('models' => $models, 'pages' => $pages,));

        endif;
    }

    public function actionOrder() {
	set_time_limit(0);
        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        $userId = $user->id;
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $company = Yii::app()->db->createCommand()
                            ->select('*')
                            ->where("id = '1'")
                            ->from('company')->queryRow();

            $username = Yii::app()->user->name;
            $user = Yii::app()->db->createCommand()
                            ->select('*')
                            ->where("username = '$username'")
                            ->from('users')->queryRow();

            $this->layout = 'sell';

            $customers = Yii::app()->db->createCommand()
                            ->select('*')                    
                            ->where("is_alive > 0")
                            ->order('customer_name')
                            ->from('customer')->queryAll();



            $categories = Yii::app()->db->createCommand()
                            ->select('*')
                            ->order('sort_order, category_name')
                            ->from('product_category')->queryAll();

            $sub_categories = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('product_category')
                    ->where("parent_id <> '0'")
                    ->order('sort_order, category_name')
                    ->queryAll();

            $_products = Yii::app()->db->createCommand()
                            ->select('product.*')
                            ->order('product_name')
                            //->leftJoin('stock', 'stock.product_code = product.product_code')
                            //->group('product.product_code')
                            ->from('product')->queryAll();
                                                             
            $temp_products = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('sell_tempory')
                            ->where("user_id = '$username'")->queryAll();

            $stocks = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('stock')
                    ->group('stock.product_code')
                    ->queryAll();


            $products = array();
            foreach ($_products as $product) {
                $product['purchase_date'] = $product["purchase_date"] ? date('d/m/Y', strtotime($product["purchase_date"])) : '';
                $products[$product['product_category_id']][] = $product;
            }


            $categories = json_encode($categories);
            $sub_categories = json_encode($sub_categories);
            $products = json_encode($products);
            $org_customers = $customers;
            $customers = json_encode($customers);
            $temp_products = json_encode($temp_products);

            $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
            $suspend_id = isset($_GET['suspend']) ? $_GET['suspend'] : '';


            if (isset($_GET['customer_id'])) {
                $cond1 = new CDbCriteria(array('condition' => "id = '{$_GET['customer_id']}'",));
                $old_customer = Customer::model()->find($cond1);
            } else {
                $old_customer = null;
            }

            if (isset($_GET['old_order'])) {
                $command_ord = Yii::app()->db->createCommand();
                $command_ord->update('sell_order', array('print_status' => 1), "invoice_no = '{$_GET['old_order']}'");

                $cond = new CDbCriteria(array('condition' => "invoice_no = '{$_GET['old_order']}'",));
                $sale = Sell::model()->find($cond);
            } else {
                $sale = null;
            }

            $this->render('order', array(
                'old_customer' => $old_customer,
                'customer_id' => $customer_id,
                'categories' => $categories,
                'sub_categories' => $sub_categories,
                'suspend_id' => $suspend_id,
                'products' => $products,
                'customers' => $customers,
                'org_customers' => $org_customers,
                'temp_products' => $temp_products,
                'stocks' => json_encode($stocks),
                'old_order' => $sale,
                'company' => $company,
                'user' => $user
            ));

        endif;
    }

      public function actionShow_product_history() {
          
        $pcode = $_POST['pcode'];
        $custid = $_POST['custid'];
  
        $_products = Yii::app()->db->createCommand()
                        ->select('sell_order_product.amount as sell_price,sell_order.order_date,product.product_name')
                        ->join('sell_order_product', 'sell_order_product.invoice_no = sell_order.invoice_no')
                        ->join('product', 'product.product_code = sell_order_product.product_code')
                        ->where("sell_order.customer_id = '$custid' AND product.product_code = '$pcode'" )
                        ->order('sell_order.order_date DESC')
                        ->from('sell_order')->limit(5)->queryAll();


        $this->renderPartial('show_product_history', array('last_history' => $_products));
    }

    public function actionShow_last_history() {
        $pcode = $_POST['pcode'];
        $_products = Yii::app()->db->createCommand()
                        ->select('purchase_product.purchase_date,purchase_product.product_price,supplier.name,')
                        ->leftJoin('purchase', 'purchase.id = purchase_product.purchase_id')
                        ->leftJoin('supplier', 'supplier.id = purchase.supplier_id')
                        ->where("purchase_product.product_code = '$pcode'")
                        ->order('purchase_product.id DESC')
                        ->from('purchase_product')->limit(10)->queryAll();

        $this->renderPartial('show_last_history', array('last_history' => $_products));
    }

    public function actionSearch_customer() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;
            $criteria = new CDbCriteria;
            if ($_POST['Search']['customer_name'] != "") {
                $criteria->addCondition('(customer_name LIKE "' . $_POST['Search']['customer_name'] . '%" OR business_name LIKE "' . $_POST['Search']['customer_name'] . '%")');
            }
            if ($_POST['Search']['postcode'] != "") {
                $criteria->addCondition('business_post_code LIKE   "%' . $_POST['Search']['postcode'] . '%"  OR  home_post_code LIKE  "%' . $_POST['Search']['postcode'] . '%"');
            }
            if ($_POST['Search']['contact_no'] != "") {
                $criteria->addCondition('contact_no1 LIKE "%' . $_POST['Search']['contact_no'] . '%" OR  contact_no2 LIKE "%' . $_POST['Search']['contact_no'] . '%"');
            }
            $criteria->addCondition('is_alive > 0');
       
            $customers = Customer::model()->findAll($criteria);
            $this->renderPartial('customer_list', array(
                'org_customers' => $customers
            ));

        endif;
    }

    public function actionRetail() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        $userId = $user->id;
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $company = Yii::app()->db->createCommand()
                            ->select('*')
                            ->where("id = '1'")
                            ->from('company')->queryRow();

            $username = Yii::app()->user->name;
            $user = Yii::app()->db->createCommand()
                            ->select('*')
                            ->where("username = '$username'")
                            ->from('users')->queryRow();

            $this->layout = 'sell';

            $categories = Yii::app()->db->createCommand()
                            ->select('*')
                            ->order('sort_order, category_name')
                            ->from('product_category')->queryAll();

            $sub_categories = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('product_category')
                    ->where("parent_id <> '0'")
                    ->order('sort_order, category_name')
                    ->queryAll();

            $_products = Yii::app()->db->createCommand()
                            ->select('product.*')
                            ->order('product_name')
                            //->leftJoin('stock', 'stock.product_code = product.product_code')
                            //->group('product.product_code')
                            ->from('product')->queryAll();

            $temp_products = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('sell_tempory')
                            ->where("user_id = '$username'")->queryAll();

            $stocks = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('stock')
                    ->group('stock.product_code')
                    ->queryAll();


            $products = array();
            foreach ($_products as $product) {
                $product['purchase_date'] = $product["purchase_date"] ? date('d/m/Y', strtotime($product["purchase_date"])) : '';
                $products[$product['product_category_id']][] = $product;
            }


            $categories = json_encode($categories);
            $sub_categories = json_encode($sub_categories);
            $products = json_encode($products);
            $temp_products = json_encode($temp_products);

            $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
            $suspend_id = isset($_GET['suspend']) ? $_GET['suspend'] : '';


            if (isset($_GET['customer_id'])) {
                $cond1 = new CDbCriteria(array('condition' => "id = '{$_GET['customer_id']}'",));
                $old_customer = Customer::model()->find($cond1);
            } else {
                $old_customer = null;
            }

            if (isset($_GET['old_order'])) {
                $command_ord = Yii::app()->db->createCommand();
                $command_ord->update('sell_order', array('print_status' => 1), "invoice_no = '{$_GET['old_order']}'");

                $cond = new CDbCriteria(array('condition' => "invoice_no = '{$_GET['old_order']}'",));
                $sale = Sell::model()->find($cond);
            } else {
                $sale = null;
            }


            $this->render('retail', array(
                'old_customer' => $old_customer,
                'customer_id' => $customer_id,
                'categories' => $categories,
                'sub_categories' => $sub_categories,
                'suspend_id' => $suspend_id,
                'products' => $products,
                'temp_products' => $temp_products,
                'stocks' => json_encode($stocks),
                'old_order' => $sale,
                'company' => $company,
                'user' => $user
            ));

        endif;
    }

    public function actionSell() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        $userId = $user->id;
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $company = Yii::app()->db->createCommand()
                            ->select('*')
                            ->where("id = '1'")
                            ->from('company')->queryRow();

            $username = Yii::app()->user->name;
            $user = Yii::app()->db->createCommand()
                            ->select('*')
                            ->where("username = '$username'")
                            ->from('users')->queryRow();

            $this->layout = 'sell';

            $customers = Yii::app()->db->createCommand()
                            ->select('*')
                            ->order('customer_name')
                            ->from('customer')->queryAll();

            $categories = Yii::app()->db->createCommand()
                            ->select('*')
                            ->order('sort_order, category_name')
                            ->from('product_category')->queryAll();

            $sub_categories = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('product_category')
                    ->where("parent_id <> '0'")
                    ->order('sort_order, category_name')
                    ->queryAll();

            $_products = Yii::app()->db->createCommand()
                            ->select('product.*')
                            ->order('product_name')
                            //->leftJoin('stock', 'stock.product_code = product.product_code')
                            //->group('product.product_code')
                            ->from('product')->queryAll();

            $temp_products = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('sell_tempory')
                            ->where("user_id = '$username'")->queryAll();

            $stocks = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('stock')
                    ->group('stock.product_code')
                    ->queryAll();


            $products = array();
            foreach ($_products as $product) {
                $product['purchase_date'] = $product["purchase_date"] ? date('d/m/Y', strtotime($product["purchase_date"])) : '';
                $products[$product['product_category_id']][] = $product;
            }


            $categories = json_encode($categories);
            $sub_categories = json_encode($sub_categories);
            $products = json_encode($products);
            $org_customers = $customers;
            $customers = json_encode($customers);
            $temp_products = json_encode($temp_products);

            $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
            $suspend_id = isset($_GET['suspend']) ? $_GET['suspend'] : '';


            if (isset($_GET['customer_id'])) {
                $cond1 = new CDbCriteria(array('condition' => "id = '{$_GET['customer_id']}'",));
                $old_customer = Customer::model()->find($cond1);
            } else {
                $old_customer = null;
            }

            if (isset($_GET['old_order'])) {
                $command_ord = Yii::app()->db->createCommand();
                $command_ord->update('sell_order', array('print_status' => 1), "invoice_no = '{$_GET['old_order']}'");

                $cond = new CDbCriteria(array('condition' => "invoice_no = '{$_GET['old_order']}'",));
                $sale = Sell::model()->find($cond);
            } else {
                $sale = null;
            }


            $this->render('sell', array(
                'old_customer' => $old_customer,
                'customer_id' => $customer_id,
                'categories' => $categories,
                'sub_categories' => $sub_categories,
                'suspend_id' => $suspend_id,
                'products' => $products, 'customers' => $customers,
                'org_customers' => $org_customers,
                'temp_products' => $temp_products,
                'stocks' => json_encode($stocks),
                'old_order' => $sale,
                'company' => $company,
                'user' => $user
            ));

        endif;
    }

    public function actionAddTemporary() {
        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;


            if (!empty($_POST['cart_info'])) {

                $cart_items = json_decode($_POST['cart_info']);
                $p = 0;
                foreach ($cart_items as $product) {

                    $product_code2 = $product->product_code;
                    $_product = Product::model()->find('product_code=?', array($product_code2));
                    $product_name2 = $product->product_name;
                    $quantity2 = $product->quantity;
                    $price2 = $product->product_price > 0 ? $product->product_price : $_product->sell_price;
                    $amount_total2 = $price2 * $quantity2;
                    $discount2 = 0;
                    $vat2 = $_product->vat ? $_product->vat : 0;


                    $update_cond = "product_code = '$product_code2' && user_id = '$username'";
                    $update1 = new CDbCriteria(array('condition' => $update_cond,));
                    $itemExists = Sell_Tempory::model()->findAll($update1);

                    if (count($itemExists)):
                        $command = Yii::app()->db->createCommand();
                        $command->update('sell_tempory', array('p_price' => $price2, 'product_name' => $product_name2, 'quantity' => $quantity2, 'vat' => $vat2, 'discount' => $discount2,), $update_cond);
                    else:
                        $command = Yii::app()->db->createCommand();
                        $command->insert('sell_tempory', array(
                            'user_id' => $username,
                            'product_code' => $product_code2,
                            'product_name' => $product_name2,
                            'p_price' => $price2,
                            'quantity' => $quantity2,
                            'vat' => $vat2,
                            'discount' => $discount2,
                        ));
                    endif;
                }
            }

        endif;
    }

    public function actionSuspendOrder() {
        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            if (!empty($_POST)) {


                $model = new Sell();
                $model2 = new Stock();
                //code for invoice id 
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->limit = 1;
                $sales = Suspend_Sell::model()->findAll($criteria);

                if (count($sales)): foreach ($sales as $lastValues):
                        $suspand_id = $lastValues->id + 1;
                    endforeach;
                else: $suspand_id = 1;
                endif;
                ///////////////////

                $user_id = Yii::app()->user->name;


                $amount_sub_total = $_POST['total_cost'];
                $vat_total = $_POST['vat_total'];
                $price_grand_ttotal = $_POST['final_cost'];
                $cash_sell = @$_POST['cash_sell'] ? $_POST['cash_sell'] : 0;

                $order_date = date('Y-m-d', time());
                $customer_id = $_POST['customer_id'];

                if (!empty($_POST['cart_info'])) {

                    $cart_items = json_decode($_POST['cart_info']);
                    $p = 0;
                    foreach ($cart_items as $product) {

                        $product_code2 = $product->product_code;
                        $_product = Product::model()->find('product_code=?', array($product_code2));
                        $product_name2 = $product->product_name;
                        $quantity2 = $product->quantity;
                        $price2 = $product->product_price > 0 ? $product->product_price : $_product->sell_price;
                        $amount_total2 = $price2 * $quantity2;

                        $discount2 = 0;
                        if ($_POST['discount'] > 0)
                            $discount2 = $_POST['discount'];

                        $vat2 = $_product->vat ? $_product->vat : 0;
                        $en_sl = ++$p;

                        // sell order product  insert
                        $command = Yii::app()->db->createCommand();
                        $command->insert('suspend_sell_order_product', array(
                            'suspand_id' => $suspand_id,
                            'product_code' => $product_code2,
                            'product_name' => $product_name2,
                            'quantity' => $quantity2,
                            'amount' => $price2,
                            'amount_total' => $amount_total2,
                            'discount' => $discount2,
                            'vat' => $vat2,
                            'en_sl' => $en_sl,
                        ));
                    }
                    $discount_amount = $amount_sub_total * ($_POST['discount'] / 100);
                    // sell order insert

                    $return = "DONE";
                    try {


                    $command = Yii::app()->db->createCommand();
                    $command->insert('suspend_sell_order', array(
                        'id' => $suspand_id,
                        'order_date' => $order_date,
                        'customer_id' => $_POST['customer_id'],
                        'amount_sub_total' => $amount_sub_total,
                        'vat_total' => $vat_total,
                        'amount_grand_total' => $price_grand_ttotal,
                        'user_id' => $user_id,
                        'discount_ratio' => $discount_amount,
                        'suspend_day' => $_POST['suspend_date'],
                        'cash_sell' => $cash_sell
                    ));
                        //if suspended list again suspend then delete old one.
                        if ($_POST['suspend_id']) {
                            $command = Yii::app()->db->createCommand();
                            $command->delete('suspend_sell_order_product', "suspand_id = '{$_POST['suspend_id']}'");
                            $command->delete('suspend_sell_order', "id = '{$_POST['suspend_id']}'");
                        }
                            $return = "DONE";
                               // Yii::app()->user->setFlash('saveMessage', 'Sell Suspended Successfully....');
                    }
                    catch (Exception $ex){
                        $return = "ERROR";

                      //  Yii::app()->user->setFlash('saveMessage', 'Sell does not Suspended !');
                    }
                    $model_sellTempory = new Sell_Tempory();
                    $model_sellTempory->deleteAll("user_id = '$user_id'");

                    echo $return;
                }
            }
        endif;
    }
    public function actionAddOrder() {
        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
             $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;


            $existing_invoice_no = isset($_POST['existing_invoice_no']) ? $_POST['existing_invoice_no'] : "";

            if (!$existing_invoice_no) {
                //code for invoice id 
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->limit = 1;
                $sales = Sell::model()->findAll($criteria);

                if (count($sales)): foreach ($sales as $lastValues):
                        $invoice_sl = $lastValues->invoice_sl;
                        $order_date1 = date("dmy", strtotime($lastValues->order_date));
                        $order_date2 = date('dmy');
                        if ($order_date1 == $order_date2):
                            $invoice_sl = $invoice_sl + 1;
                            $invoice_no = $order_date2 . $invoice_sl;
                        else:
                            $invoice_sl = 1;
                            $invoice_no = $order_date2 . $invoice_sl;
                        endif;
                    endforeach;
                else: $invoice_no = date('dmy') . '1';
                    $invoice_sl = 1;
                endif;
            } else {
                $invoice_no = $existing_invoice_no;

                $existing_order = Sell::model()->find("invoice_no = '$invoice_no'");
                $invoice_sl = $existing_order->invoice_sl;
                $this->deleteSellProducts($invoice_no);
            }

            $user_id = Yii::app()->user->name;


            $amount_sub_total = $_POST['total_cost'];
            $vat_total = $_POST['vat_total'];
            $price_grand_ttotal = $_POST['final_cost'];
            $discount_amount = $_POST['discount_value']; // $amount_sub_total * ($_POST['discount'] / 100);

            $cash_payment = $_POST['cash_payment']; //$existing_invoice_no != "" ? $existing_order->cash_payment+$_POST['cash_payment'] : $_POST['cash_payment'];
            $cheque_payment = $_POST['cheque_payment']; //$existing_invoice_no != "" ? $existing_order->cheque_payment+$_POST['cheque_payment'] : $_POST['cheque_payment'];
            $credit_card_payment = $_POST['credit_card_payment']; //$existing_invoice_no != "" ? $existing_order->credit_card_payment+$_POST['credit_card_payment'] : $_POST['credit_card_payment'];


            $amount_payable = $cash_payment + $cheque_payment + $credit_card_payment;
            $cash_balance = @$_POST['cash_balance'];
            $order_date = $existing_invoice_no != "" ? $existing_order->order_date : date('Y-m-d', time());
            $customer_id = @$_POST['customer_id'];
            $pay_now = @$_POST['pay_now'];
            $pay_now2 = @$_POST['pay_now2'];
            $comment = @$_POST['comment'];

            $paid_amount = $amount_payable;
            if ($price_grand_ttotal > $amount_payable): $status = 0;
            else: $status = 1;
            endif;

            if (empty($customer_id)):
                echo "<script type=\"text/javascript\">alert('Customer Name Needed !!');" . "window.location = '" . Yii::app()->request->baseUrl . "/b2b_sell/order'</script>";
            endif;

//            print_r(array(
//                    'customer_id' => $customer_id,
//                    'amount_sub_total' => $amount_sub_total,
//                    'vat_total' => $vat_total,
//                    'amount_grand_total' => $price_grand_ttotal,
//                    'paid_amount' => $amount_payable,
//                    'cash_payment' => $cash_payment,
//                    'cheque_payment' => $cheque_payment,
//                    'credit_card_payment' => $credit_card_payment,
//                    'status' => $status,
//                    'user_id' => $user_id,
//                    'discount_ratio' => $discount_amount
//                        ));
 //        exit();
            // sell order insert
            $command = Yii::app()->db->createCommand();

            if ($existing_invoice_no != "") {
                $command->update('sell_order', array(
                    'customer_id' => $customer_id,
                    'amount_sub_total' => $amount_sub_total,
                    'vat_total' => $vat_total,
                    'amount_grand_total' => $price_grand_ttotal,
                    'paid_amount' => $amount_payable,
                    'cash_payment' => $cash_payment,
                    'cheque_payment' => $cheque_payment,
                    'credit_card_payment' => $credit_card_payment,
                    'status' => $status,                    
                   // 'online_order_status' => "accept",
                    'user_id' => $user_id,
                    'discount_ratio' => $discount_amount
                        ), "invoice_no = '$existing_invoice_no'");
            } else {
                $command->insert('sell_order', array(
                    'invoice_no' => $invoice_no,
                    'invoice_sl' => $invoice_sl,
                    'order_date' => $order_date,
                    'customer_id' => $customer_id,
                    'amount_sub_total' => $amount_sub_total,
                    'vat_total' => $vat_total,
                    'amount_grand_total' => $price_grand_ttotal,
                    'paid_amount' => $amount_payable,
                    'cash_payment' => $cash_payment,
                    'cheque_payment' => $cheque_payment,
                    'credit_card_payment' => $credit_card_payment,
                    'status' => $status,
                    'user_id' => $user_id,
                    'discount_ratio' => $discount_amount
                ));
            }
            if ($cheque_payment > 0) {
                $bank_comm = Yii::app()->db->createCommand();
                $bank_comm->insert('bank_transaction', array(
                    'bank_id' => 1,
                    'purpose_id' => 1,
                    'amount' => $cheque_payment,
                    'is_saving' => 1,
                    'type' => "cheque",
                    'user_name' => $username,
                    'date' => $order_date,
                ));
            }
            $command->update('customer', array('comment' => $comment,), "id = '$customer_id'");

            if (!empty($_POST['cart_info'])) {

                $cart_items = json_decode($_POST['cart_info']);
                $p = 0;
                foreach ($cart_items as $product) {
                    $product_code2 = $product->product_code;
                    $_product = Product::model()->find('product_code=?', array($product_code2));
                    $product_name2 = $product->product_name;
                    $quantity2 = $product->quantity;
                    $price2 = $product->product_price > 0 ? $product->product_price : $_product->sell_price;
                    $amount_total2 = $price2 * $quantity2;
                    $discount2 = 0;
                    $vat_on_profit = isset($product->vat_on_profit) ? $product->vat_on_profit : $_product->vat_on_profit;
                    $vat2 = $_product->vat_on_purchase + $vat_on_profit;
                    $en_sl = ++$p;

                    $cos = "product_code = '$product_code2'";
                    $cond = new CDbCriteria(array('condition' => "product_code = '$product_code2'",));
                    $stockExValues = Stock::model()->findAll($cond);

                    if (count($stockExValues)):
                        foreach ($stockExValues as $stockExValue): $quantity_stock = $stockExValue->product_balance - $quantity2;
                        endforeach;
                        // sell order product  insert
                        $command = Yii::app()->db->createCommand();
                        $command->insert('sell_order_product', array(
                            'invoice_no' => $invoice_no,
                            'product_code' => $product_code2,
                            'product_name' => $product_name2,
                            'quantity' => $quantity2,
                            'amount' => $price2,
                            'amount_total' => $amount_total2,
                            'discount' => $discount2,
                            'vat' => $vat2,
                            'en_sl' => $en_sl,
                        ));
                        $command->update('stock', array('product_balance' => $quantity_stock,), $cos);
                    else:
                        $command = Yii::app()->db->createCommand();
                        $command->insert('sell_order_product', array(
                            'invoice_no' => $invoice_no,
                            'product_code' => $product_code2,
                            'product_name' => $product_name2,
                            'quantity' => $quantity2,
                            'amount' => $price2,
                            'amount_total' => $amount_total2,
                            'discount' => $discount2,
                            'vat' => $vat2,
                            'en_sl' => $en_sl,
                        ));
                        $command->insert('stock', array(
                            'product_code' => $product_code2,
                            'product_balance' => -$quantity2
                        ));
                    endif;
                }

                if($amount_payable > 0){
                    $command3 = Yii::app()->db->createCommand();
                    $command3->insert('account_receive', array(
                        'invoice_no' => $invoice_no,
                        'customer_id' => $_POST['customer_id'],
                        'receive_date' => $order_date,
                        'receive_mode' => '0',
                        'amount' => $amount_payable,
                    ));
                }
                Yii::app()->user->setFlash('saveMessage', 'Sell Completed Successfully....<a href="' . Yii::app()->request->baseUrl . '/b2b_sell/order">Sale Again</a>');
                $model_sellTempory = new Sell_Tempory();
                $model_sellTempory->deleteAll("user_id = '$username'");
                if ($_POST['suspend_id']) {
                    $command = Yii::app()->db->createCommand();
                    $command->delete('suspend_sell_order_product', "suspand_id = '{$_POST['suspend_id']}'");
                    $command->delete('suspend_sell_order', "id = '{$_POST['suspend_id']}'");
                }
                $b2b = $_GET['b2b'];
                if ($b2b != "A4") {
                    $this->renderPartial('view2', array('invoice_no' => $invoice_no,));
                } else {
                    $this->renderPartial('view3', array('invoice_no' => $invoice_no,));
                }
            }


        endif;
    }

    public function actionAddOrderWithoutCustomer() {
        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;


            $existing_invoice_no = isset($_POST['existing_invoice_no']) ? $_POST['existing_invoice_no'] : "";

            if (!$existing_invoice_no) {
                //code for invoice id 
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->limit = 1;
                $sales = Sell::model()->findAll($criteria);

                if(count($sales)): foreach ($sales as $lastValues):
                        $invoice_sl = $lastValues->invoice_sl;
                        $order_date1 = date("dmy", strtotime($lastValues->order_date));
                        $order_date2 = date('dmy');
                        if($order_date1 == $order_date2):
                            $invoice_sl = $invoice_sl + 1;
                            $invoice_no = $order_date2 . $invoice_sl;
                        else:
                            $invoice_sl = 1;
                            $invoice_no = $order_date2 . $invoice_sl;
                        endif;
                    endforeach;
                else: $invoice_no = date('dmy') . '1';
                    $invoice_sl = 1;
                endif;
            } else {
                $invoice_no = $existing_invoice_no;
                $existing_order = Sell::model()->find("invoice_no = '$invoice_no'");
                $invoice_sl = $existing_order->invoice_sl;
                $this->deleteSellProducts($invoice_no);
            }
            $user_id = Yii::app()->user->name;
            $amount_sub_total = $_POST['total_cost'];
            $vat_total = $_POST['vat_total'];
            $price_grand_ttotal = $_POST['final_cost'];
            $discount_amount = $amount_sub_total * ($_POST['discount'] / 100);
            $cash_payment = $existing_invoice_no != "" ? $existing_order->cash_payment + $_POST['cash_payment'] : $_POST['cash_payment'];
            $cheque_payment = $existing_invoice_no != "" ? $existing_order->cheque_payment + $_POST['cheque_payment'] : $_POST['cheque_payment'];
            $credit_card_payment = $existing_invoice_no != "" ? $existing_order->credit_card_payment + $_POST['credit_card_payment'] : $_POST['credit_card_payment'];

            $amount_payable = $cash_payment + $cheque_payment + $credit_card_payment;
            $cash_balance = @$_POST['cash_balance'];
            $order_date = $existing_invoice_no != "" ? $existing_order->order_date : date('Y-m-d', time());
            $pay_now = @$_POST['pay_now'];
            $pay_now2 = @$_POST['pay_now2'];
            $comment = @$_POST['comment'];
            $paid_amount = $amount_payable;

            if ($price_grand_ttotal > $amount_payable):
                $status = 0;
            else:
                $status = 1;
            endif;


            // sell order insert
            $command = Yii::app()->db->createCommand();
            if ($existing_invoice_no != "") {
                $command->update('sell_order', array(
                    'amount_sub_total' => $amount_sub_total,
                    'vat_total' => $vat_total,
                    'amount_grand_total' => $price_grand_ttotal,
                    'paid_amount' => $amount_payable,
                    'cash_payment' => $cash_payment,
                    'cheque_payment' => $cheque_payment,
                    'credit_card_payment' => $credit_card_payment,
                    'status' => $status,
                    'user_id' => $user_id,
                    'discount_ratio' => $discount_amount
                        ), "invoice_no = '$existing_invoice_no'");
            } else {
                $command->insert('sell_order', array(
                    'invoice_no' => $invoice_no,
                    'invoice_sl' => $invoice_sl,
                    'order_date' => $order_date,
                    'amount_sub_total' => $amount_sub_total,
                    'vat_total' => $vat_total,
                    'amount_grand_total' => $price_grand_ttotal,
                    'paid_amount' => $amount_payable,
                    'cash_payment' => $cash_payment,
                    'cheque_payment' => $cheque_payment,
                    'credit_card_payment' => $credit_card_payment,
                    'status' => $status,
                    'user_id' => $user_id,
                    'discount_ratio' => $discount_amount
                ));
            }

            //$command->update('customer', array('comment' => $comment,), "id = '$customer_id'");

            if (!empty($_POST['cart_info'])) {

                $cart_items = json_decode($_POST['cart_info']);
                $p = 0;
                foreach ($cart_items as $product) {
                    $product_code2 = $product->product_code;
                    $_product = Product::model()->find('product_code=?', array($product_code2));
                    $product_name2 = $product->product_name;
                    $quantity2 = $product->quantity;
                    $price2 = $product->product_price > 0 ? $product->product_price : $_product->sell_price;
                    $amount_total2 = $price2 * $quantity2;
                    $discount2 = 0;
                    $vat_on_profit = isset($product->vat_on_profit) ? $product->vat_on_profit : $_product->vat_on_profit;
                    $vat2 = $_product->vat_on_purchase + $vat_on_profit;
                    $en_sl = ++$p;

                    $cos = "product_code = '$product_code2'";
                    $cond = new CDbCriteria(array('condition' => "product_code = '$product_code2'",));
                    $stockExValues = Stock::model()->findAll($cond);

                    if (count($stockExValues)):
                        foreach ($stockExValues as $stockExValue): $quantity_stock = $stockExValue->product_balance - $quantity2;
                        endforeach;
                        // sell order product  insert
                        $command = Yii::app()->db->createCommand();
                        $command->insert('sell_order_product', array(
                            'invoice_no' => $invoice_no,
                            'product_code' => $product_code2,
                            'product_name' => $product_name2,
                            'quantity' => $quantity2,
                            'amount' => $price2,
                            'amount_total' => $amount_total2,
                            'discount' => $discount2,
                            'vat' => $vat2,
                            'en_sl' => $en_sl,
                        ));
                        $command->update('stock', array('product_balance' => $quantity_stock,), $cos);
                    else:
                        $command = Yii::app()->db->createCommand();
                        $command->insert('sell_order_product', array(
                            'invoice_no' => $invoice_no,
                            'product_code' => $product_code2,
                            'product_name' => $product_name2,
                            'quantity' => $quantity2,
                            'amount' => $price2,
                            'amount_total' => $amount_total2,
                            'discount' => $discount2,
                            'vat' => $vat2,
                            'en_sl' => $en_sl,
                        ));
                        $command->insert('stock', array(
                            'product_code' => $product_code2,
                            'product_balance' => -$quantity2
                        ));
                    endif;
                }
 
                
                if($amount_payable > 0){
                    $command3 = Yii::app()->db->createCommand();
                    $command3->insert('account_receive', array(
                        'invoice_no' => $invoice_no,
                        'receive_date' => $order_date,
                        'receive_mode' => '0',
                        'amount' => $amount_payable,
                    ));
                }
                Yii::app()->user->setFlash('saveMessage', 'Sell Completed Successfully....<a href="' . Yii::app()->request->baseUrl . '/b2b_sell/order">Sale Again</a>');
                $model_sellTempory = new Sell_Tempory();
                $model_sellTempory->deleteAll("user_id = '$username'");

                $this->render('view2', array('invoice_no' => $invoice_no));
            }
        endif;
    }

    public function actionAddSell() {
        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;


            $existing_invoice_no = isset($_POST['existing_invoice_no']) ? $_POST['existing_invoice_no'] : "";

            if (!$existing_invoice_no) {
                //code for invoice id 
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->limit = 1;
                $sales = Sell::model()->findAll($criteria);

                if (count($sales)): foreach ($sales as $lastValues):
                        $invoice_sl = $lastValues->invoice_sl;
                        $order_date1 = date("dmy", strtotime($lastValues->order_date));
                        $order_date2 = date('dmy');
                        if ($order_date1 == $order_date2):
                            $invoice_sl = $invoice_sl + 1;
                            $invoice_no = $order_date2 . $invoice_sl;
                        else:
                            $invoice_sl = 1;
                            $invoice_no = $order_date2 . $invoice_sl;
                        endif;
                    endforeach;
                else: $invoice_no = date('dmy') . '1';
                    $invoice_sl = 1;
                endif;
            } else {
                $invoice_no = $existing_invoice_no;

                $existing_order = Sell::model()->find("invoice_no = '$invoice_no'");
                $invoice_sl = $existing_order->invoice_sl;

                //$this->deleteSell(array($invoice_no));
                //delete products
                $this->deleteSellProducts($invoice_no);
            }

            $user_id = Yii::app()->user->name;


            $amount_sub_total = $_POST['total_cost'];
            $vat_total = $_POST['vat_total'];
            $price_grand_ttotal = $_POST['final_cost'];
            $discount_amount = $amount_sub_total * ($_POST['discount'] / 100);

            $cash_payment = @$_POST['cash_payment']; //$existing_invoice_no != "" ? $existing_order->cash_payment+$_POST['cash_payment'] : $_POST['cash_payment'];
            $cheque_payment = @$_POST['cheque_payment']; //$existing_invoice_no != "" ? $existing_order->cheque_payment+$_POST['cheque_payment'] : $_POST['cheque_payment'];
            $credit_card_payment = isset($_POST['credit_card_payment']) ? $_POST['credit_card_payment'] : 0; //$existing_invoice_no != "" ? $existing_order->credit_card_payment+$_POST['credit_card_payment'] : $_POST['credit_card_payment'];


            $amount_payable = $cash_payment + $cheque_payment + $credit_card_payment;
            $cash_balance = @$_POST['cash_balance'];
            $order_date = $existing_invoice_no != "" ? $existing_order->order_date : date('Y-m-d', time());
            $customer_id = @$_POST['customer_id'];
            $pay_now = @$_POST['pay_now'];
            $pay_now2 = @$_POST['pay_now2'];
            $comment = @$_POST['comment'];

            $paid_amount = $amount_payable;
            if ($price_grand_ttotal > $amount_payable): $status = 0;
            else: $status = 1;
            endif;

            if (empty($customer_id)):
                echo "<script type=\"text/javascript\">alert('Customer Name Needed !!');" . "window.location = '" . Yii::app()->request->baseUrl . "/b2b_sell/order'</script>";
            endif;

            // sell order insert
            $command = Yii::app()->db->createCommand();
            if ($existing_invoice_no != "") {
                $command->update('sell_order', array(
                    'customer_id' => $customer_id,
                    'amount_sub_total' => $amount_sub_total,
                    'vat_total' => $vat_total,
                    'amount_grand_total' => $price_grand_ttotal,
                    'paid_amount' => $amount_payable,
                    'cash_payment' => $cash_payment,
                    'cheque_payment' => $cheque_payment,
                    'credit_card_payment' => $credit_card_payment,
                    'status' => $status,
                    'user_id' => $user_id,
                    'discount_ratio' => $discount_amount,
                    'cash_sell' => 1
                        ), "invoice_no = '$existing_invoice_no'");
            } else {
                $command->insert('sell_order', array(
                    'invoice_no' => $invoice_no,
                    'invoice_sl' => $invoice_sl,
                    'order_date' => $order_date,
                    'customer_id' => $customer_id,
                    'amount_sub_total' => $amount_sub_total,
                    'vat_total' => $vat_total,
                    'amount_grand_total' => $price_grand_ttotal,
                    'paid_amount' => $amount_payable,
                    'cash_payment' => $cash_payment,
                    'cheque_payment' => $cheque_payment,
                    'credit_card_payment' => $credit_card_payment,
                    'status' => $status,
                    'user_id' => $user_id,
                    'discount_ratio' => $discount_amount,
                    'cash_sell' => 1
                ));
            }

            $command->update('customer', array('comment' => $comment,), "id = '$customer_id'");

            if (!empty($_POST['cart_info'])) {

                $cart_items = json_decode($_POST['cart_info']);
                $p = 0;
                foreach ($cart_items as $product) {
                    $product_code2 = $product->product_code;
                    $_product = Product::model()->find('product_code=?', array($product_code2));
                    $product_name2 = $product->product_name;
                    $quantity2 = $product->quantity;
                    $price2 = $product->product_price > 0 ? $product->product_price : $_product->sell_price;
                    $amount_total2 = $price2 * $quantity2;
                    $discount2 = 0;
                    $vat_on_profit = isset($product->vat_on_profit) ? $product->vat_on_profit : $_product->vat_on_profit;
                    $vat2 = $_product->vat_on_purchase + $vat_on_profit;
                    $en_sl = ++$p;

                    $cos = "product_code = '$product_code2'";
                    $cond = new CDbCriteria(array('condition' => "product_code = '$product_code2'",));
                    $stockExValues = Stock::model()->findAll($cond);

                    if (count($stockExValues)):
                        foreach ($stockExValues as $stockExValue): $quantity_stock = $stockExValue->product_balance - $quantity2;
                        endforeach;
                        // sell order product  insert
                        $command = Yii::app()->db->createCommand();
                        $command->insert('sell_order_product', array(
                            'invoice_no' => $invoice_no,
                            'product_code' => $product_code2,
                            'product_name' => $product_name2,
                            'quantity' => $quantity2,
                            'amount' => $price2,
                            'amount_total' => $amount_total2,
                            'discount' => $discount2,
                            'vat' => $vat2,
                            'en_sl' => $en_sl,
                        ));
                        $command->update('stock', array('product_balance' => $quantity_stock,), $cos);
                    else:
                        $command = Yii::app()->db->createCommand();
                        $command->insert('sell_order_product', array(
                            'invoice_no' => $invoice_no,
                            'product_code' => $product_code2,
                            'product_name' => $product_name2,
                            'quantity' => $quantity2,
                            'amount' => $price2,
                            'amount_total' => $amount_total2,
                            'discount' => $discount2,
                            'vat' => $vat2,
                            'en_sl' => $en_sl,
                        ));
                        $command->insert('stock', array(
                            'product_code' => $product_code2,
                            'product_balance' => -$quantity2
                        ));
                    endif;
                }

                $command3 = Yii::app()->db->createCommand();
                $command3->insert('account_receive', array(
                    'invoice_no' => $invoice_no,
                    'customer_id' => $_POST['customer_id'],
                    'receive_date' => $order_date,
                    'receive_mode' => 'cash',
                    'amount' => $amount_payable,
                ));

                Yii::app()->user->setFlash('saveMessage', 'Sell Completed Successfully....<a href="' . Yii::app()->request->baseUrl . '/b2b_sell/order">Sale Again</a>');
                $model_sellTempory = new Sell_Tempory();
                $model_sellTempory->deleteAll("user_id = '$username'");
                if ($_POST['suspend_id']) {
                    $command = Yii::app()->db->createCommand();
                    $command->delete('suspend_sell_order_product', "suspand_id = '{$_POST['suspend_id']}'");
                    $command->delete('suspend_sell_order', "id = '{$_POST['suspend_id']}'");
                }
                $this->renderPartial('view3', array('invoice_no' => $invoice_no));
            }


        endif;
    }

    // Business Sell
    public function actionAdd() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $username = Yii::app()->user->name;

            if (!empty($_POST['product_code'])) {
                // code for search product
                $username = Yii::app()->user->name;


                // code for reinsert datagride value
                $product_cod = $_POST['product_code22'];
                $product_name = $_POST['product_name'];
                $quantity = $_POST['quantity'];
                $price = $_POST['price'];
                $discount = $_POST['discount'];
                $vat = $_POST['vat'];

                if (!empty($product_cod)):
                    // delete privious data

                    for ($p = 0; $p < sizeof($product_cod); $p++):

                        $product_code2 = $product_cod[$p];
                        $product_name2 = $product_name[$p];
                        $quantity2 = $quantity[$p];
                        $price2 = $price[$p];
                        $discount2 = $discount[$p];
                        $vat2 = $vat[$p];

                        $update_cond = "product_code = '$product_code2' && user_id = '$username'";
                        $update1 = new CDbCriteria(array('condition' => $update_cond,));
                        $itemExists = Sell_Tempory::model()->findAll($update1);

                        if (count($itemExists)):
                            $command = Yii::app()->db->createCommand();
                            $command->update('sell_tempory', array('p_price' => $price2, 'product_name' => $product_name2, 'quantity' => $quantity2, 'vat' => $vat2, 'discount' => $discount2,), $update_cond);
                        else:
                            $command = Yii::app()->db->createCommand();
                            $command->insert('sell_tempory', array(
                                'user_id' => $username,
                                'product_code' => $product_code2,
                                'product_name' => $product_name2,
                                'p_price' => $price2,
                                'quantity' => $quantity2,
                                'vat' => $vat2,
                                'discount' => $discount2,
                            ));
                        endif;
                    endfor;
                endif;

                // end temporary reinsert
                $customer_id = $_POST['customer_id'];
                $product_code = $_POST['product_code'];
                $product_id = $_POST['product_id'];
                $existing_invoice_no = isset($_POST['existing_invoice_no']) ? $_POST['existing_invoice_no'] : "";
                $model = new Product();
                $criteria = new CDbCriteria();
                if ($product_id)
                    $criteria->condition = "product_code = '$product_id'";
                else
                    $criteria->condition = "product_code = '$product_code'";
                $criteria->order = 'id DESC';
                $model = Product::model()->find($criteria);
                if ($model):

                    $product_code = $model->product_code;
                    $p_name = $model->product_name;
                    $p_price = $model->sell_price;
                    $min_stock = $model->min_stock;
                    $vat = $model->vat;



                    $cond = "user_id = '$username' && product_code = '$product_code'";
                    $cond2 = "product_code = '$product_code'";
                    $q1 = new CDbCriteria(array('condition' => $cond,));
                    $dataExists = Sell_Tempory::model()->findAll($q1);
                    $q2 = new CDbCriteria(array('condition' => $cond2,));
                    $stockVals = Stock::model()->findAll($q2);
                    $s_balance = 0;
                    if (count($stockVals)): foreach ($stockVals as $stockVal): $s_balance = $stockVal->product_balance;
                        endforeach;
                    endif;


                    if (count($dataExists)):
                        foreach ($dataExists as $data):
                            $pre_qty = $data->quantity;
                        endforeach;
                        $qty = $pre_qty + 1;

                        $model_sellTempory = new Sell_Tempory();
                        $model_sellTempory->deleteAll($cond);
                        $command = Yii::app()->db->createCommand();
                        $command->insert('sell_tempory', array(
                            'user_id' => $username,
                            'product_code' => $product_code,
                            'product_name' => $p_name,
                            'p_price' => $p_price,
                            'quantity' => $qty,
                            'vat' => $vat,
                            'discount' => $discount2,
                        ));

                    else:
                        $command = Yii::app()->db->createCommand();
                        $command->insert('sell_tempory', array(
                            'user_id' => $username,
                            'product_code' => $product_code,
                            'product_name' => $p_name,
                            'p_price' => $p_price,
                            'quantity' => 1,
                            'vat' => $vat,
                        ));
                    endif;
                else:
                    echo "<script type=\"text/javascript\">alert('Item Not Available !!');</script>";
                endif;
                $existing_order = array();
                if ($existing_invoice_no != "") {
                    $existing_order = Sell::model()->find("invoice_no = '$existing_invoice_no'");
                }
                $this->render('add', array('model' => $models, 'customer_id' => $customer_id, 'old_order' => $existing_order));
            }
            // Sell details save info
            elseif (!empty($_POST) && empty($_POST['product_code'])) {
                if (!empty($_POST['remove_item'])) {
                    $model_temp_sell = Sell_Tempory::model()->findByPk($_POST['remove_item']);
                    $model_temp_sell->delete();
                    $customer_id = $_POST['customer_id'];
                    $this->render('add', array('customer_id' => $customer_id));
                } else {
                    $model = new Sell();
                    $model2 = new Stock();
                    $existing_invoice_no = isset($_POST['existing_invoice_no']) ? $_POST['existing_invoice_no'] : "";
                    if (!$existing_invoice_no) {
                        //code for invoice id 
                        $criteria = new CDbCriteria();
                        $criteria->order = 'id DESC';
                        $criteria->limit = 1;
                        $sales = Sell::model()->findAll($criteria);
                        if (count($sales)): foreach ($sales as $lastValues):
                                $invoice_sl = $lastValues->invoice_sl;
                                $order_date1 = date("dmy", strtotime($lastValues->order_date));
                                $order_date2 = date('dmy');
                                if ($order_date1 == $order_date2):
                                    $invoice_sl = $invoice_sl + 1;
                                    $invoice_no = $order_date2 . $invoice_sl;
                                else:
                                    $invoice_sl = 1;
                                    $invoice_no = $order_date2 . $invoice_sl;
                                endif;
                            endforeach;
                        else:
                            $invoice_no = date('dmy') . '1';
                            $invoice_sl = 1;
                        endif;
                    } else {
                        $invoice_no = $existing_invoice_no;
                        $existing_order = Sell::model()->find("invoice_no = '$invoice_no'");
                        $invoice_sl = $existing_order->invoice_sl;

                        //$this->deleteSell(array($invoice_no));
                        //delete products
                        $this->deleteSellProducts($invoice_no);
                    }



                    ///////////////////

                    $user_id = Yii::app()->user->name;


                    $amount_sub_total = $_POST['price_grand_total'];
                    $vat_total = $_POST['vat_total'];
                    $price_grand_ttotal = $_POST['price_grand_ttotal'];

                    $cash_payment = $existing_invoice_no != "" ? $existing_order->cash_payment + $_POST['cash_payment'] : $_POST['cash_payment'];
                    $cheque_payment = $existing_invoice_no != "" ? $existing_order->cheque_payment + $_POST['cheque_payment'] : $_POST['cheque_payment'];
                    $credit_card_payment = $existing_invoice_no != "" ? $existing_order->credit_card_payment + $_POST['credit_card_payment'] : $_POST['credit_card_payment'];


                    $amount_payable = $cash_payment + $cheque_payment + $credit_card_payment;
                    $cash_balance = $_POST['cash_balance'];
                    $order_date = $existing_invoice_no != "" ? $existing_order->order_date : date('Y-m-d', time());
                    $customer_id = $_POST['customer_id'];
                    $pay_now = $_POST['pay_now'];
                    $pay_now2 = $_POST['pay_now2'];
                    $comment = $_POST['comment'];

                    $paid_amount = $amount_payable;
                    if ($price_grand_ttotal > $amount_payable): $status = 0;
                    else: $status = 1;
                    endif;

                    $product_code = $_POST['product_code22'];
                    $p_name = $_POST['product_name'];
                    $quantity = $_POST['quantity'];
                    $price = $_POST['price'];
                    $discount = $_POST['discount'];
                    $vat = $_POST['vat'];

                    if (empty($customer_id)):
                        echo "<script type=\"text/javascript\">alert('Customer Name Needed !!');" . "window.location = '" . Yii::app()->request->baseUrl . "/b2b_sell/add'</script>";
                    endif;

                    // sell order insert
                    $command = Yii::app()->db->createCommand();
                    if ($existing_invoice_no != "") {
                        $command->update('sell_order', array(
                            'amount_sub_total' => $amount_sub_total,
                            'vat_total' => $vat_total,
                            'amount_grand_total' => $price_grand_ttotal,
                            'paid_amount' => $amount_payable,
                            'cash_payment' => $cash_payment,
                            'cheque_payment' => $cheque_payment,
                            'credit_card_payment' => $credit_card_payment,
                            'status' => $status,
                            'user_id' => $user_id,
                            'discount_ratio' => $_POST['total_discount']
                                ), "invoice_no = '$existing_invoice_no'");
                    } else {
                        $command->insert('sell_order', array(
                            'invoice_no' => $invoice_no,
                            'invoice_sl' => $invoice_sl,
                            'order_date' => $order_date,
                            'customer_id' => $customer_id,
                            'amount_sub_total' => $amount_sub_total,
                            'vat_total' => $vat_total,
                            'amount_grand_total' => $price_grand_ttotal,
                            'paid_amount' => $amount_payable,
                            'cash_payment' => $cash_payment,
                            'cheque_payment' => $cheque_payment,
                            'credit_card_payment' => $credit_card_payment,
                            'status' => $status,
                            'user_id' => $user_id,
                            'discount_ratio' => $_POST['total_discount']
                        ));
                    }

                    $command->update('customer', array('comment' => $comment,), "id = '$customer_id'");

                    if (!empty($product_code)):

                        for ($p = 0; $p < sizeof($product_code); $p++):

                            $product_code2 = $product_code[$p];
                            $product_name2 = $p_name[$p];
                            $quantity2 = $quantity[$p];
                            $price2 = $price[$p];
                            $amount_total2 = $price2 * $quantity2;
                            $discount2 = $discount[$p];
                            $vat2 = $vat[$p];
                            $en_sl = $p + 1;

                            $update_cond = "product_code = '$product_code2' && user_id = '$user_id'";
                            $command = Yii::app()->db->createCommand();
                            $command->update('sell_tempory', array('p_price' => $price2, 'product_name' => $product_name2, 'quantity' => $quantity2, 'vat' => $vat2, 'discount' => $discount2,), $update_cond);

                            $cos = "product_code = '$product_code2'";
                            $cond = new CDbCriteria(array('condition' => "product_code = '$product_code2'",));
                            $stockExValues = Stock::model()->findAll($cond);

                            if (count($stockExValues)):
                                foreach ($stockExValues as $stockExValue): $quantity_stock = $stockExValue->product_balance - $quantity2;
                                endforeach;
                                // sell order product  insert
                                $command = Yii::app()->db->createCommand();
                                $command->insert('sell_order_product', array(
                                    'invoice_no' => $invoice_no,
                                    'product_code' => $product_code2,
                                    'product_name' => $product_name2,
                                    'quantity' => $quantity2,
                                    'amount' => $price2,
                                    'amount_total' => $amount_total2,
                                    'discount' => $discount2,
                                    'vat' => $vat2,
                                    'en_sl' => $en_sl,
                                ));
                                $command->update('stock', array('product_balance' => $quantity_stock,), $cos);
                            else:
                                $command = Yii::app()->db->createCommand();
                                $command->insert('sell_order_product', array(
                                    'invoice_no' => $invoice_no,
                                    'product_code' => $product_code2,
                                    'product_name' => $product_name2,
                                    'quantity' => $quantity2,
                                    'amount' => $price2,
                                    'amount_total' => $amount_total2,
                                    'discount' => $discount2,
                                    'vat' => $vat2,
                                    'en_sl' => $en_sl,
                                ));
                                $command->insert('stock', array(
                                    'product_code' => $product_code2,
                                    'product_balance' => -$quantity2
                                ));
                            endif;
                        endfor;
 
                if($amount_payable > 0){
                    $command3 = Yii::app()->db->createCommand();
                    $command3->insert('account_receive', array(
                        'invoice_no' => $invoice_no,
                        'customer_id' => $_POST['customer_id'],
                        'receive_date' => $order_date,
                        'receive_mode' => '0',
                        'amount' => $amount_payable,
                    ));
                }
                Yii::app()->user->setFlash('saveMessage', 'Sell Completed Successfully....<a href="' . Yii::app()->request->baseUrl . '/b2b_sell/add">Sale Again</a>');
                        $model_sellTempory = new Sell_Tempory();
                        $model_sellTempory->deleteAll("user_id = '$username'");
                        $this->render('view2', array('model' => $model, 'invoice_no' => $invoice_no,));
                    //$this->refresh();

                    endif;
                }
            }
            else {
                $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
                $invoice_no = isset($_GET['invoice_no']) ? $_GET['invoice_no'] : '';
                $this->render('add', array('model' => $model, 'customer_id' => $customer_id, 'invoice_no' => $invoice_no));
            }
        endif;
    }

    public function actionSell_clear() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $user_id = Yii::app()->user->name;
            $model_sellTempory = new Sell_Tempory();
            $model_sellTempory->deleteAll("user_id = '$user_id'");
            $this->redirect(array('b2b_sell/add'));
        endif;
    }

// sell suspend2	
    public function actionSuspend() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $username = Yii::app()->user->name;

            // Sell details save info
            if (!empty($_POST)) {
               // print_r($_POST);
                //exit();
                $model = new Sell();
                $model2 = new Stock();
                //code for invoice id 
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->limit = 1;
                $sales = Suspend_Sell::model()->findAll($criteria);

                if (count($sales)): foreach ($sales as $lastValues):
                        $suspand_id = $lastValues->id + 1;
                    endforeach;
                else: $suspand_id = 1;
                endif;
                ///////////////////


                $user_id = Yii::app()->user->name;


//                $amount_sub_total = $_POST['price_grand_total'];               
//                $price_grand_ttotal = $_POST['price_grand_ttotal'];
              
                $vat_total = $_POST['vat_total'];
                $amount_sub_total = $_POST['total_cost']; 
                $price_grand_ttotal = $_POST['final_cost'];

                $order_date = date('Y-m-d', time());
                $customer_id = $_POST['customer_id'];
                $pay_now = $_POST['pay_now'];
                $pay_now2 = $_POST['pay_now2'];

                $suspand_id = $suspand_id;
                $product_code = $_POST['product_code22'];
                $product_name = $_POST['product_name'];
                $quantity = $_POST['quantity'];
                $price = $_POST['price'];
                $discount = $_POST['discount'];
                $vat = $_POST['vat'];

                if (!empty($product_code)):


                    for ($p = 0; $p < sizeof($product_code); $p++):

                        $product_code2 = $product_code[$p];
                        $product_name2 = $product_name[$p];
                        $quantity2 = $quantity[$p];
                        $price2 = $price[$p];
                        $amount_total2 = $price2 * $quantity2;
                        $discount2 = $discount[$p];
                        $vat2 = $vat[$p];
                        $en_sl = $p + 1;

                        // sell order product  insert
                        $command = Yii::app()->db->createCommand();
                        $command->insert('suspend_sell_order_product', array(
                            'suspand_id' => $suspand_id,
                            'product_code' => $product_code2,
                            'product_name' => $product_name2,
                            'quantity' => $quantity2,
                            'amount' => $price2,
                            'amount_total' => $amount_total2,
                            'discount' => $discount2,
                            'vat' => $vat2,
                            'en_sl' => $en_sl,
                        ));
                    endfor;

                    // sell order insert
                    $command = Yii::app()->db->createCommand();
                    $command->insert('suspend_sell_order', array(
                        'id' => $suspand_id,
                        'order_date' => $order_date,
                        'customer_id' => $_POST['customer_id'],
                        'amount_sub_total' => $amount_sub_total,
                        'vat_total' => $vat_total,
                        'amount_grand_total' => $amount_sub_total,
                        'user_id' => $user_id,
                    ));
                    Yii::app()->user->setFlash('saveMessage', 'Sell Suspended Successfully....');
                    $model_sellTempory = new Sell_Tempory();
                    $model_sellTempory->deleteAll("user_id = '$username'");
                    $this->render('add', array('model' => $model,));
                endif;
            }
        //$this->refresh();
        endif;
    }

    // sell Cancel2
    public function actionSell_Cancel() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $username = Yii::app()->user->name;
            // Sell details save info
            if (!empty($_POST)) {
                //code for invoice id 
                $model_sellTempory = new Sell_Tempory();
                $model_sellTempory->deleteAll("user_id = '$username'");
                if ($_POST['ajax_call']) {
                    echo 'done';
                } else
                    $this->render('add', array('model' => $model,));
            }
        endif;
    }

    public function actionReportSummary() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->report_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Sell();
            $this->render('report_summary_form', array('model' => $model,));

        endif;
    }

    public function actionSummaryListing() {
        if (count($_POST)) {
            $cond = "customer_id != 0";
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($start_date));
            else: $start_date = "";
            endif;
            if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($end_date));
            else: $end_date = "";
            endif;

            $invoice_no = $_POST['invoice_no'];
            $user_id = $_POST['user_id'];

            if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && order_date >= '$start_date' && order_date <= '$end_date'";
            endif;
            if (!empty($cond) && !empty($invoice_no)): $cond .= " && invoice_no = '$invoice_no'";
            elseif (empty($cond) && !empty($invoice_no)): $cond .= "invoice_no = '$invoice_no'";
            endif;
            if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && order_date = '$start_date'";
            elseif (empty($cond) && !empty($start_date)): $cond .= "order_date = '$start_date'";
            endif;
            if (!empty($cond) && !empty($user_id)): $cond .= " && user_id = '$user_id'";
            elseif (empty($cond) && !empty($user_id)): $cond .= "user_id = '$user_id'";
            endif;

            if ($_POST['customer_id'] != "") {
                $cond .= " AND customer_id = '{$_POST['customer_id']}'";
            }


            if ($cond != "")
                $cond = " WHERE $cond";

            $sql = "SELECT order_date,
                    COUNT(*) as total_orders,                    
                    SUM(cash_payment) as cash_amount,
                    SUM(cheque_payment) as cheque_amount,
                    SUM(credit_card_payment) as card_amount,                    
                    SUM(vat_total) as total_vat,
                    SUM(amount_grand_total) as total_amount,
                    SUM(paid_amount) as total_paid_amount
                    FROM sell_order
                    $cond 
                    GROUP BY order_date
                    ORDER BY order_date";

            $results = Yii::app()->db->createCommand($sql)->queryAll();

            //echo $sql;exit;
            //print_r($results); exit;

            $orders = array();

            foreach ($results as $result) {
                $orders[$result['order_date']] = $result;
            }

            $this->renderPartial('sell_report_summary', array('orders' => $orders));
        }
    }

    public function actionReport() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;
            $model = new Sell();
            $this->render('sell_report_form', array('model' => $model,));
        endif;
    }

    public function create_pdf($invoice_no) {
        require_once(getcwd() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR .'mpdf' . DIRECTORY_SEPARATOR . 'mpdf.php');

        $cond = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'",));
        $models = Sell::model()->findAll($cond);
        $model_products = Sell_Product::model()->findAll($cond);

        $html = $this->renderPartial('create_pdf', array('models' => $models, 'model_products' => $model_products,), TRUE);

        $mpdf = new mPDF();

        $mpdf->WriteHTML($html);
        $mpdf->Output('invoices/' . $invoice_no . '.pdf', 'F');
        return getcwd() . DIRECTORY_SEPARATOR . 'invoices' . DIRECTORY_SEPARATOR . $invoice_no . '.pdf';
    }

    public function actionReportListing() {
        if (count($_POST)) {
            $cond = "customer_id > 0";
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($start_date));
            else: $start_date = "";
            endif;
            if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($end_date));
            else: $end_date = "";
            endif;

            $invoice_no = $_POST['invoice_no'];
            $user_id = $_POST['user_id'];

            if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && order_date >= '$start_date' && order_date <= '$end_date'";
            endif;
            if (!empty($cond) && !empty($invoice_no)): $cond .= " && invoice_no = '$invoice_no'";
            elseif (empty($cond) && !empty($invoice_no)): $cond .= "invoice_no = '$invoice_no'";
            endif;
            if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && order_date = '$start_date'";
            elseif (empty($cond) && !empty($start_date)): $cond .= "order_date = '$start_date'";
            endif;
            if (!empty($cond) && !empty($user_id)): $cond .= " && user_id = '$user_id'";
            elseif (empty($cond) && !empty($user_id)): $cond .= "user_id = '$user_id'";
            endif;

            $cust_cond = "";
            if ($_POST['customer_id'] != "") {
                $cond .= " AND customer_id = '{$_POST['customer_id']}'";
                $cust_cond = "customer_id = '{$_POST['customer_id']}'";
            }


            if ($_POST['payment_type'] != "") {
                if ($_POST['payment_type'] == "cash") {
                    $cond .= " AND cash_sell = 1";
                    $cust_cond = "cash_sell = 1";
                } else {
                    $cond .= " AND cash_sell != 1";
                    $cust_cond = "cash_sell != 1";
                }
            }

            if ($_POST['payment_method'] != "") {
                if ($_POST['payment_method'] == "cash") {
                    $cond .= " AND (cash_payment >= 0 AND cheque_payment = 0 AND credit_card_payment =0)";
                } else if ($_POST['payment_method'] == "card") {
                    $cond .= " AND (cash_payment = 0 AND cheque_payment = 0 AND credit_card_payment >= 0)";
                } else if ($_POST['payment_method'] == "cheque") {
                    $cond .= " AND (cash_payment = 0 AND cheque_payment >=0 AND credit_card_payment = 0)";
                }
            }

            $criteria = new CDbCriteria();
            $criteria->condition = $cond;
            $criteria->order = 'id DESC';

            $criteria->select = "sum(amount_grand_total) as total_amount, sum(paid_amount) as total_paid_amount, count(invoice_no) as total";


            $result = Sell::model()->find($criteria);


            $pages = new CPagination($result->total);
            // elements per page
            $pages->pageSize = 500;
            $pages->applyLimit($criteria);


            $criteria->select = "*";
            $model = Sell::model()->findAll($criteria);

            #last 4 months records
            $last_orders = array();
            if ($cust_cond != "") {
                for ($i = 3; $i >= 0; $i--) {
                    $month_ = $i > 0 ? date('m', strtotime("-$i Months")) : date('m');
                    $smonth = $i > 0 ? date('M', strtotime("-$i Months")) : date('M');

                    $next_i = date('m') - $month_ - 1;


                    //echo "<br>Month_:$month_<br>Nexti:$next_i<br>";
                    //$prev_i = $next_i-1;
                    //$max_month = strtotime($month_) //$next_i > 0 ? date('m', strtotime("-$next_i Months")) : ($next_i < 0 ? date('m', strtotime("+".abs($next_i)." Months")) : date('m'));

                    $year_ = $i > 0 ? date('Y', strtotime("-$i Months")) : date('Y');

                    //$next_year = $next_i > 0 ? date('Y', strtotime("-$next_i Months")) : ($next_i < 0 ? date('Y', strtotime("+".abs($next_i)." Months")) : date('Y'));
                    //echo $month_."->".$next_month."<br>";

                    $min_date = "$year_-$month_-01";
                    $max_date = date("Y-m-d", strtotime("+1 month", strtotime($min_date))); // "$next_year-$next_month-01";
                    //echo ""

                    $user_cond = "";
                    if ($user_id) {
                        $user_cond = " AND user_id = '$user_id'";
                    }

                    $sql = "SELECT sum(amount_grand_total) as total_amount, sum(paid_amount) as total_paid_amount, count(invoice_no) as total"
                            . " FROM sell_order WHERE $cust_cond AND order_date >= '$min_date' AND order_date < '$max_date' $user_cond";
                    $last_orders[$smonth] = Yii::app()->db->createCommand($sql)->queryRow();
                    //echo $sql."<br>";
                }
               // exit();
            }
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    $is_online = $user->is_online;
                endforeach;
            else:
                $is_online = "1";
            endif;

            $this->renderPartial('sell_report', array(
                'model' => $model, 'sell_info' => $result, 'pages' => $pages, 'is_online' => $is_online,
                'customer_id' => $_POST['customer_id'] != "" ? $_POST['customer_id'] : 0,
                'last_orders' => $last_orders,
                'from_date' => $start_date, 'to_date' => $end_date
            ));
        }
    }

    public function actionDaily_Sell_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Sell();
            if (count($_POST)) {
                $report_date = $_POST['report_date'];
                if (!empty($report_date)): $report_date = date('Y-m-d', strtotime($report_date));
                else: $report_date = "";
                endif;

                $user_id = $_POST['user_id'];
                $cond = "customer_id != '0'";
                if (!empty($cond) && !empty($report_date)): $cond .= " && order_date = '$report_date'";
                elseif (empty($cond) && !empty($report_date)): $cond .= "order_date = '$report_date'";
                endif;
                if (!empty($cond) && !empty($user_id)): $cond .= " && user_id = '$user_id'";
                elseif (empty($cond) && !empty($user_id)): $cond .= "user_id = '$user_id'";
                endif;

                $criteria = new CDbCriteria();
                $criteria->condition = $cond;
                $criteria->order = 'id ASC';
                $model = Sell::model()->findAll($criteria);
                $this->render('daily_sell_report', array('model' => $model, 'report_date' => $report_date,));
            }
            else {
                $this->render('daily_sell_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionProfit_Loss_Report() {

        set_time_limit(60);
        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->report_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Sell();
            if (count($_POST)) {
                $cond = '';
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($start_date));
                else: $start_date = "";
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($end_date));
                else: $end_date = "";
                endif;

                if (!empty($start_date) && !empty($end_date)): $cond .= "so.order_date >= '$start_date' AND so.order_date <= '$end_date' AND so.customer_id > 0";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && so.order_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date)): $cond .= "so.order_date = '$start_date' and so.customer_id > 0";
                endif;

//                $criteria = new CDbCriteria();
//                $criteria->select = "DISTINCT product_code";
//                $criteria->condition = $cond;
//                $criteria->order = 'id DESC';                
//                $model = Sell_Product::model()->findAll($criteria);

                $model = Yii::app()->db->createCommand()
                                ->select('sop.product_code, COUNT( sop.product_code ) AS total_sell_qty, 
                            SUM(sop.amount_total) AS total_sell_amount, SUM(sop.vat) AS total_vat,
                            IF(p.product_name != "", p.product_name, sop.product_name) as product_name,
                            IF(p.purchase_cost != "", p.purchase_cost, (select product_price from purchase_product where purchase_product.product_code=sop.product_code and product_price > 0 order by id desc limit 0,1)) AS purchase_cost')
                                ->from('sell_order_product sop')
                                ->join('sell_order so', 'so.invoice_no=sop.invoice_no')
                                ->leftJoin('product p', 'sop.product_code=p.product_code')
                                ->where($cond)
                                ->group('sop.product_code')->queryAll();

                $this->render('profit_loss_report', array('model' => $model, 'start_date' => $start_date, 'end_date' => $end_date,));
            }
            else {
                $this->render('profit_loss_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionRemove($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $model = Sell_Tempory::model()->findByPk($id);
            $model->delete();
        //$this->redirect(array('b2b_sell/add'));
        endif;
    }

    public function actionSellEntry() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $username = Yii::app()->user->name;
            $product_code2 = $_POST['product_code2'];
            $model = new Product();
            $criteria = new CDbCriteria();
            $criteria->condition = "product_code = '$product_code2' OR product_name = '$product_code2'";
            $criteria->order = 'id DESC';
            $models = Product::model()->findAll($criteria);

            if ($models):
                foreach ($models as $model):
                    $product_code = $model->product_code;
                endforeach;
            endif;

            $qty = $_POST['qty'];
            $invoice_no = $_POST['invoice_no2'];

            $cond2 = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'",));
            $models = Sell_Product::model()->findAll($cond2);
            foreach ($models as $model):
                $product_code2 = $model->product_code;
                if ($product_code2 == $product_code):
                    $match = "yes";
                    $match_quantity = $model->quantity;
                    break;
                else: $match = "no";
                    $match_quantity = "";
                endif;
            endforeach;

            if ($match == "yes" && $match_quantity >= $qty):
                $cond = "user_id = '$username' && product_code = '$product_code'";
                $q1 = new CDbCriteria(array('condition' => $cond,));
                $dataExists = Sell_Return_Tempory::model()->findAll($q1);

                if (count($dataExists)):
                    $command = Yii::app()->db->createCommand();
                    $model_Rdtemporary = new Sell_Return_Tempory();
                    $model_Rdtemporary->deleteAll($cond);
                    $command->insert('sell_return_tempory', array(
                        'user_id' => $username,
                        'product_code' => $product_code,
                        'quantity' => $qty,
                    ));
                else:
                    $command = Yii::app()->db->createCommand();
                    $command->insert('sell_return_tempory', array(
                        'user_id' => $username,
                        'product_code' => $product_code,
                        'quantity' => $qty,
                    ));
                endif;
               // $this->redirect(array('b2b_sell/sell_return'));
                $this->redirect(array('b2b_sell/sell_return', 'invoice_no2' => $invoice_no));
            else:
                echo "<script type=\"text/javascript\">alert('This product is not available in your invoice or given quantity is much more from sell quantity !!');" . "window.location = '".Yii::app()->request->baseUrl."/b2b_sell/sell_return'</script>";
            endif;

        endif;
    }

    public function actionSellRemove($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $model = Sell_Return_Tempory::model()->findByPk($id);
            $model->delete();
            $this->redirect(array('b2b_sell/sell_return'));
        endif;
    }

    public function actionView($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:

            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->sale_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $invoice_no = $id;
            $cond = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'"));
            $models = Sell::model()->findAll($cond);
            $model_products = Sell_Product::model()->findAll($cond);
            $this->render('view', array('models' => $models, 'model_products' => $model_products,'invoice_no'=>$invoice_no));
        endif;
    }

    public function actionView2($id) {


        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->sale_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $invoice_no = $id;
            $cond = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'",));
            $models = Sell::model()->findAll($cond);
            $model_products = Sell_Product::model()->findAll($cond);
            $this->render('view2', array('models' => $models, 'model_products' => $model_products,));
        endif;
    }

    public function actionView3($invoice_no) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->sale_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $invoice_no = $invoice_no;
            $cond = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'",));
            $models = Sell::model()->findAll($cond);
            $model_products = Sell_Product::model()->findAll($cond);
            $this->render('view2', array('models' => $models, 'model_products' => $model_products));
        endif;
    }

    public function actionSuspended() {

        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->b2b_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $filter_day = null;
            if (isset($_GET['filter_day'])) {
                $cond = new CDbCriteria(array('condition' => "suspend_day = '{$_GET['filter_day']}'"));
                $models = Suspend_Sell::model()->findAll($cond);
                $filter_day = $_GET['filter_day'];
            } else
                $models = Suspend_Sell::model()->findAll();
            $this->render('suspended_list', array('models' => $models, 'filter_day' => $filter_day));
        endif;
    }

    public function actionUnsuspend($id) {
        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $user_id = Yii::app()->user->name;
            $invoice_no = $id;

            $command = Yii::app()->db->createCommand();
            $command->delete('sell_tempory', "user_id = '$user_id'");

            $cond = new CDbCriteria(array('condition' => "suspand_id = '$invoice_no'",));
            $models = Suspend_Sell_Product::model()->findAll($cond);

            $cond = new CDbCriteria(array('condition' => "id = '$id'",));
            $suspand_sale = Suspend_Sell::model()->find($cond);
            $discount = 0;
            if (count($models)):
                foreach ($models as $data):
                    $product_code = $data->product_code;
                    $product_name = $data->product_name;
                    $discount = $suspand_sale->discount_ratio;
                    $vat = $data->vat;
                    $quantity = $data->quantity;
                    $amount = $data->amount;

                    $command = Yii::app()->db->createCommand();
                    $command->insert('sell_tempory', array(
                        'user_id' => $user_id,
                        'product_code' => $product_code,
                        'product_name' => $product_name,
                        'p_price' => $amount,
                        'quantity' => $quantity,
                        'vat' => $vat,
                    ));

                endforeach;
            endif;
            if ($suspand_sale->cash_sell > 0)
                $this->redirect(Yii::app()->baseUrl . "/b2b_sell/sell?customer_id=$suspand_sale->customer_id&suspend=$id&discount=$discount");
            else
                $this->redirect(Yii::app()->baseUrl . "/b2b_sell/order?customer_id=$suspand_sale->customer_id&suspend=$id&discount=$discount");
        endif;
    }

    // for suspended sell2
    public function actionDelete3($id) {


        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->b2b_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $invoice_no = $id;
            $command = Yii::app()->db->createCommand();
            $command->delete('suspend_sell_order_product', "suspand_id = '$invoice_no'");
            $command->delete('suspend_sell_order', "id = '$invoice_no'");

            Yii::app()->user->setFlash('saveMessage', 'Suspended Sell Deleted Successfully....');
            $this->redirect(array('b2b_sell/order'));
        endif;
    }

    public function deleteSellProducts($invoice_no) {
//        $cond22 = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'",));
//        $sellProductValues = Sell_Product::model()->findAll($cond22);
//
//        if (count($sellProductValues)):
//            foreach ($sellProductValues as $sellProductValue):
//
//                $product_code = $sellProductValue->product_code;
//                $quantity1 = $sellProductValue->quantity;
//
//                $cond = new CDbCriteria(array('condition' => "product_code = '$product_code'",));
//                $stockValues = Stock::model()->findAll($cond);
//
//                if (count($stockValues)): foreach ($stockValues as $data2):
//                        $stock_id = $data2->id;
//                        $product_balance = $data2->product_balance;
//                    endforeach;
//                endif;
//
//                $cond2 = "id = '$stock_id'";
//
//                $command = Yii::app()->db->createCommand();
//                $command->update('stock', array('product_balance' => $product_balance + $quantity1), $cond2);
//            endforeach;
//        endif;
        $command = Yii::app()->db->createCommand();
        $cond3 = "invoice_no = '$invoice_no'";
        $command->delete('sell_order_product', $cond3);
    }

    public function deleteSell($invoice_ids) {
        if (count($invoice_ids) <= 0) {
            echo 'No Invoice Selected';
            exit();
        }

        foreach ($invoice_ids as $invoice_no) {
            $model = Sell::model()->findByPk($invoice_no);
            $this->deleteSellProducts($invoice_no);
            $command = Yii::app()->db->createCommand();
            $cond3 = "invoice_no = '$invoice_no'";
            $command->delete('account_receive', $cond3);
            $command->delete('sell_order', $cond3);
        }
    }

    public function actionSend_Report() {

        $invoice_ids = implode(",", json_decode($_POST['invoice_ids']));
        $customer_ids = json_decode($_POST['customer_ids']);
       // print_r($invoice_ids);
     
//        $customers = array();
//        foreach ($customer_ids as $customer_id) {
//            $customers[$customer_id] = $customer_id;
//        }
      //  print_r($customer_ids);
      //   print_r($invoice_ids);
       
        
        
        
        require_once(getcwd() . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'NativeMail' . DIRECTORY_SEPARATOR . 'nativemail.php');


      //  foreach ($customers as $customer) {
          
            $Customer = Customer::model()->findAllByPk($customer_ids[0]);
            
       // print_r($Customer[0]['email_address']);
          //  if(!$Customer[0]['email_address']) continue;
           
            $customer_invoices = Yii::app()->db->createCommand("SELECT invoice_no FROM sell_order WHERE customer_id = $customer_ids[0] AND invoice_no IN ($invoice_ids)")->queryAll();            
         //
            $mail = new NativeMail("info@sylhetshop.co.uk", "Sylhet Shop", $Customer[0]['email_address'], "Account Invoice", "<h3>Dear Customer,<br> Please find attached invoice(s).</h3>");            

            foreach($customer_invoices as $customer_invoice) {
                $attach_file = $this->create_pdf($customer_invoice['invoice_no']);
                $mail->setAttachment($attach_file, $customer_invoice['invoice_no'] . '.pdf');
            }
                                                                                                    
            $mail->send();

            foreach($customer_invoices as $customer_invoice) {
              @unlink('invoices/' . $customer_invoice['invoice_no'] . '.pdf');
            }
            
            $message = "";
        //}
    }

    
    public function actionPrint_Report() {

        $invoice_ids = implode(",", json_decode($_POST['invoice_ids']));
        $customer_ids = json_decode($_POST['customer_ids']); 
        
        require_once(getcwd() . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'NativeMail' . DIRECTORY_SEPARATOR . 'nativemail.php');
 
            $Customer = Customer::model()->findAllByPk($customer_ids[0]);
            
            $customer_invoices = Yii::app()->db->createCommand("SELECT * FROM sell_order WHERE customer_id = $customer_ids[0] AND invoice_no IN ($invoice_ids)")->queryAll();            
            
            $this->renderPartial('bluk_print', array('model' => $customer_invoices,$invoice_ids ));
    }

    
    public function actionDeleteAll() {


        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->sale_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            if (isset($_REQUEST['invoice_no'])) {
                $invoice_ids = array($_REQUEST['invoice_no']);
            } else {
                $invoice_ids = $_REQUEST['invoice_ids'];
            }


            $this->deleteSell($invoice_ids);

            echo 'Selected Invoices are deleted!';

        endif;
    }

    // suspended Receipt
    public function actionView_receipt($id) {


        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->sale_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $invoice_no = $id;
            $cond1 = new CDbCriteria(array('condition' => "id = '$invoice_no'",));
            $cond2 = new CDbCriteria(array('condition' => "suspand_id = '$invoice_no'",));

            $models = Suspend_Sell::model()->findAll($cond1);
            $model_products = Suspend_Sell_Product::model()->findAll($cond2);

            $this->render('suspend_receiptview', array('models' => $models, 'model_products' => $model_products,));
        endif;
    }

    public function actionSell_Return() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else: 
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->sale_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;
            $username = Yii::app()->user->name;

            $model = new Sell_Return();

            if (isset($_REQUEST['invoice_no2'])) {

                $invoice_no = $_REQUEST['invoice_no2'];
                $cond = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no' && customer_id != '0' ",));
                $Sells = Sell::model()->findAll($cond);
                if (count($Sells)):
                    $command = Yii::app()->db->createCommand();
                    $command->insert('invoice_track', array(
                        'invoice_no' => $invoice_no,
                    ));
                else:
                    Yii::app()->user->setFlash('saveMessage', 'Invalid B2B Sell Invoice....');
                endif;
                $_POST['invoice_no'] = $invoice_no;
                $this->render('sell_return', array('model' => $model));
            }elseif ($_POST && isset($_POST['invoice_no3']))
                {

                $user_id = Yii::app()->user->name;
                $invoice_no = $_POST['invoice_no3'];
                $payment_return = $_POST['payment_return'];
                $return_date = $_POST['return_date'];
                $reason = $_POST['reason'];

                $product_code = $_POST['product_code22'];
                $quantity = $_POST['quantity'];
                $price = $_POST['price'];

                if (!empty($product_code)):
                    for ($p = 0; $p < sizeof($product_code); $p++):

                        $product_code2 = $product_code[$p];
                        $quantity2 = $quantity[$p];
                        $product_price2 = $price[$p];
                        $price_total2 = $product_price2 * $quantity2;

                        $cos = "product_code = '$product_code2'";
                        $cond = new CDbCriteria(array('condition' => "product_code = '$product_code2'",));
                        $stockExValues = Stock::model()->findAll($cond);

                        foreach ($stockExValues as $stockExValue): $quantity_stock = $stockExValue->product_balance;
                        endforeach;

                        $command = Yii::app()->db->createCommand();
                        $command->insert('sell_return', array(
                            'invoice_no' => $invoice_no,
                            'return_date' => $return_date,
                            'product_code' => $product_code2,
                            'quantity' => $quantity2,
                            'amount' => $product_price2,
                            'payment_return' => $payment_return,
                            'reason' => $reason,
                            'user_id' => $user_id,
                        ));

                        $command->update('stock', array('product_balance' => $quantity_stock + $quantity2,), $cos);

                        if ($payment_return == 1):

                            $criteria2 = new CDbCriteria();
                            $criteria2->order = 'id DESC';
                            $criteria2->limit = 1;
                            $cashmain = Cash_In_Hand::model()->findAll($criteria2);
                            if (count($cashmain)): foreach ($cashmain as $cashmain): $cash_id = $cashmain->id;
                                    $cash_amount = $cashmain->amount;
                                endforeach;
                            endif;
                            $command = Yii::app()->db->createCommand();
                            $command->update('cash_in_hand', array('amount' => $cash_amount - $price_total2,), "id = '$cash_id'");

                        elseif ($payment_return == 2):

                        else:
                            $criteria2 = new CDbCriteria();
                            $criteria2->condition = "invoice_no = '$invoice_no'";
                            $criteria2->order = 'id DESC';
                            $criteria2->limit = 1;
                            $sellmain = Sell::model()->findAll($criteria2);
                            if (count($sellmain)): foreach ($sellmain as $sellmain): $sell_id = $sellmain->id;
                                    $paid_amount = $sellmain->paid_amount;
                                endforeach;
                            endif;
                            $command = Yii::app()->db->createCommand();
                            $command->update('sell_order', array('paid_amount' => $paid_amount + $price_total2,), "id = '$sell_id'");
                        endif;
                    endfor;
                endif;
                $model_sRtemporary = new Sell_Return_Tempory();
                $model_sRtemporary->deleteAll("user_id = '$user_id'");

                $model_Rdtemporary = new Invoice_Track();
                $model_Rdtemporary->deleteAll();

                Yii::app()->user->setFlash('saveMessage', 'Sell Return Completed Successfully....');
                $this->refresh();
            }
            else {
                $this->render('sell_return', array('model' => $model));
           }
        endif;
    }

    public function actionSell_Return_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->report_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Sell_Return();

            if ($_POST) {

                $invoice_no = trim($_POST['invoice_no']);
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($start_date));
                else: $start_date = "";
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($end_date));
                else: $end_date = "";
                endif;
                $cond = '';

                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && return_date >= '$start_date' && return_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " return_date >= '$start_date' && return_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && return_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " return_date = '$start_date'";
                endif;
                if (!empty($cond) && !empty($invoice_no)): $cond .= " && invoice_no = '$invoice_no'";
                elseif (empty($cond) && !empty($invoice_no)): $cond .= " invoice_no = '$invoice_no'";
                endif;
//$cond .="te";
                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Sell_Return::model()->findAll($cond2);
                $this->render('sell_return_report', array('model' => $model,));
            }
            else {
                $this->render('sell_return_report_form', array('model' => $model,));
            }
        endif;
    }

    // re order the sell
    public function actionReorder($id) {
        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $user_id = Yii::app()->user->name;
            $invoice_no = $id;

            $command = Yii::app()->db->createCommand();
            $command->delete('sell_tempory', "user_id = '$user_id'");

            $cond = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'",));
            $models = Sell_Product::model()->findAll($cond);

            $cond = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'",));
            $sale = Sell::model()->find($cond);

            if (count($models)):
                foreach ($models as $data):
                    $product_code = $data->product_code;
                    $product_name = $data->product_name;
                    $discount = $data->discount;
                    $vat = $data->vat;
                    $quantity = $data->quantity;
                    $amount = $data->amount;

                    $command = Yii::app()->db->createCommand();
                    $command->insert('sell_tempory', array(
                        'user_id' => $user_id,
                        'product_code' => $product_code,
                        'product_name' => $product_name,
                        'p_price' => $amount,
                        'quantity' => $quantity,
                        'vat' => $vat,
                        'discount' => $discount
                    ));

                endforeach;
            endif;

            $this->redirect(array('b2b_sell/order', 'customer_id' => $sale->customer_id, 'old_order' => $id));
        endif;
    }

}
