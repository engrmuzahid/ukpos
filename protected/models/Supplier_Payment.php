<?php

class Supplier_Payment extends CActiveRecord
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
		return '{{supplier_payment}}';
	}

	public function rules()
	{
		return array(
		array('chalan_id, delivery_date, supplier_id', 'required'),
	    array('chalan_id', 'unique'),
		);
	}
	
}