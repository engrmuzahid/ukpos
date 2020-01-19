<?php

class Expense_Type extends CActiveRecord
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
		return '{{expense_type}}';
	}

	public function rules()
	{
	return array(
	array('expense_type_name', 'required'),
	array('expense_type_name', 'unique'),
	);
	}
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->created = date('Y-m-d  H:i:s', time());
			}
			return true;
		}
		else
			return false;
	}
	
}