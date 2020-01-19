<?php

class Office_Expense extends CActiveRecord
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
		return '{{office_expense}}';
	}

	public function rules()
	{
		return array(
		array('expense_type_id, expense_name_id, expense_date, voucher_no, expense_by, 	payment_mode, amount', 'required'),
		);
	}
}