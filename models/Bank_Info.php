<?php

class Bank_Info extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{bank_info}}';
    }

    public function rules() {
        return array(
            array('bank_name', 'required')
        );
    }

//    public function relations() {
//        return array(
//            'bank_info' => array(self::BELONGS_TO, 'Bank_Info', 'id'),
//            'bank_transaction' => array(self::MANY_MANY, 'Bank_Transaction'),
//        );
//    }

}
