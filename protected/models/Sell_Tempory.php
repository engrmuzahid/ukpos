<?php

class Sell_Tempory extends CActiveRecord implements IECartPosition
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
		return '{{sell_tempory}}';
	}

	public function rules()
	{
	return array(
	array('product_type_id, product_category_id, product_code, product_name, unit_type_id, description, purchase_cost, other_cost, sell_price', 'required'),
	array('purchase_cost, other_cost, sell_price', 'numerical', 'integerOnly'=>true),
	array('product_code, product_name', 'unique'),
	);
	}
	
	
	function getId(){
        return 'sell_tempory'.$this->product_id;
    }
 
    function getPrice(){
        return $this->p_price;
    }

}