<?php

class Station extends CActiveRecord
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
		return '{{station}}';
	}

	public function rules()
	{
	return array(
	array('station_name', 'required'),
	array('station_name', 'unique'),
	);
	}
	
}