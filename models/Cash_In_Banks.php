<?php

class Cash_In_Banks extends CActiveRecord
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
		return '{{cash_in_bank_transaction}}';
	}

	public function rules()
	{
		return array(
		array('bank_id, account_no, balance', 'required'),
		);
	}
}