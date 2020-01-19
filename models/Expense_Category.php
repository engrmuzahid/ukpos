<?php

class Expense_Category extends CActiveRecord
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
		return '{{expense_category}}';
	}

	public function rules()
	{
	return array(
	array('category_name', 'required'),
	array('category_name', 'unique'),
	);
	}
	
}