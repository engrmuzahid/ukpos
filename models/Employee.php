<?php

class Employee extends CActiveRecord {

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
        return '{{employee}}';
    }

    public function rules() {
        return array(
            array('name,contact_no1', 'required'),
            array('email_address', 'email')
           
        );
    }

}
