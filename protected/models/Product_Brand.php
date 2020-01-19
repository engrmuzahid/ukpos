<?php

class Product_Brand extends CActiveRecord
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
		return '{{product_brand}}';
	}

	public function rules()
	{
	return array(
	array('brand_name', 'required'),
	array('brand_name', 'unique'),
	);
	}
}