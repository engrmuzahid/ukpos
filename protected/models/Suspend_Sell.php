<?php

class Suspend_Sell extends CActiveRecord
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
		return '{{suspend_sell_order}}';
	}

	public function rules()
	{
		return array(
		array('payment_mode, customer_type, amount_sub_total, tax, discount_ratio, discount', 'required'),
		);
	}
	
}