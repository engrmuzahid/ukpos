<?php

class Company extends CActiveRecord
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
		return '{{company}}';
	}

	public function rules()
	{
	return array(
	array('company_name, address', 'required'),
	array('contact_no, email_address, customer_mandatory, eu, payment_check, is_suspend, printer_name, website','safe'),
	array('company_name', 'unique'),
	);
	}
	
}