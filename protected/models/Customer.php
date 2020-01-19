<?php

class Customer extends CActiveRecord {

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
        return '{{customer}}';
    }

    public function rules() {
        return array(
            array('customer_name, contact_no1, business_street1, business_city, business_post_code,customer_type', 'required'),
            array('email_address', 'email'),
            array('contact_no1, contact_no2', 'numerical', 'integerOnly' => true),
            array('business_name,is_alive,joining_date,business_state,business_country, customer_photo, username, password,  email_address, contact_no2, birthday, home_street1, home_city, home_state, home_post_code, home_country, comment, status, order_day,credit_limit,pay_date', 'safe'),
            array('customer_photo', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true),
            array('customer_name, contact_no1, username', 'unique')
        );
    }

}
