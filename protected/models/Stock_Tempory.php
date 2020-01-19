<?php

class Stock_Tempory extends CActiveRecord implements IECartPosition
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
		return '{{stock_tempory}}';
	}

	public function rules()
	{
	return array(
	array('product_code, product_id', 'unique'),
	);
	}
	
	
	function getId(){
        return 'stock_tempory'.$this->product_id;
    }
 
    function getPrice(){
        return $this->p_price;
    }

}