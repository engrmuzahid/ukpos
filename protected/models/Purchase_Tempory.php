<?php

class Purchase_Tempory extends CActiveRecord 
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
		return '{{purchase_tempory}}';
	}

	public function rules()
	{
	return array(
	array('product_type_id, product_category_id', 'required'),
	);
	}
	
	
	function getId(){
        return 'purchase_tempory'.$this->product_id;
    }
 
    function getPrice(){
        return $this->p_price;
    }

}