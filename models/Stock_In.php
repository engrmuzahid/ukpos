<?php

class Stock_In extends CActiveRecord
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
		return '{{stock_in}}';
	}

	public function rules()
	{
		return array(
		array('stock_in_date, product_type, product_category, product_id, quantity', 'required'),
		);
	}
	
}