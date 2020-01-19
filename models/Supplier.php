<?php

class Supplier extends CActiveRecord
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
		return '{{supplier}}';
	}

	public function rules()
	{
		return array(
		array('name, contact_person', 'required'),
		array('email', 'email'),
		array('address', 'safe'),
		array('phone, fax, mobile', 'numerical', 'integerOnly'=>true),
		array('name', 'unique'),
		);
	}
}