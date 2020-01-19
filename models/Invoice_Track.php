<?php

class Invoice_Track extends CActiveRecord
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
		return '{{invoice_track}}';
	}

	public function rules()
	{
		return array(
		array('invoice_no', 'required'),
		array('invoice_no', 'unique'),
		);
	}
	
}