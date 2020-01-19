<?php

class Invoice_Track2 extends CActiveRecord
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
		return '{{invoice_track2}}';
	}

	public function rules()
	{
		return array(
		array('chalan_id', 'required'),
		array('chalan_id', 'unique'),
		);
	}
	
}