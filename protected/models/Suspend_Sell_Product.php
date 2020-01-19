<?php

class Suspend_Sell_Product extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{suspend_sell_order_product}}';
	}

	public function rules()
	{
		return array(
		array('invoice_no, product_type, product_category, product_id, quantity', 'required'),
		);
	}
	
}