<?php

class Sell extends CActiveRecord
{
        public $total;
        public $total_amount;
        public $total_paid_amount;
        
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
		return '{{sell_order}}';
	}

	public function rules()
	{
		return array(
		array('payment_mode, customer_type, amount_sub_total, tax, discount_ratio, discount', 'required'),
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