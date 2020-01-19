<?php

class Expense_Name extends CActiveRecord
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
		return '{{expense_name}}';
	}

	public function rules()
	{
	return array(
	array('expense_type_id, expense_name', 'required'),
	array('expense_name', 'unique'),
	);
	}
	
}