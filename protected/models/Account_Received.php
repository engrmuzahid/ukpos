<?php

class Account_Received extends CActiveRecord
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
		return '{{account_receive}}';
	}

	public function rules()
	{
		return array(
		array('chalan_id, delivery_date, supplier_id', 'required'),
	        array('chalan_id', 'unique'),
		);
	}
        
           /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }
	
}