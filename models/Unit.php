<?php

class Unit extends CActiveRecord
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
		return '{{unit_type}}';
	}

	public function rules()
	{
	return array(
	array('unit_type', 'required'),
	array('unit_type', 'unique'),
	);
	}
	
	
}