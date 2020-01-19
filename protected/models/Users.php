<?php

class Users extends CActiveRecord {
    /**
     * The followings are the available columns in table 'tbl_user':
     * @var integer $id
     * @var string $username
     * @var string $password
     * @var string $salt
     * @var string $email
     * @var string $profile
     */

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
        return '{{users}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password, email, full_name, station_id', 'required'),
            array('username, password,is_online,printer_name', 'length', 'max' => 128),
            array('username, email', 'unique'),
            array('user_sign', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true),
            array('customer_prev, item_prev, stock_prev, supplier_prev, report_prev, receiving_prev, sale_prev, employee_prev,  store_config_prev,  b2b_prev,driver_prev,customer_mandatory,eu,payment_check,is_suspend', 'boolean'),
        );
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->password = $this->hashPassword($this->password);
            } else {
                $username = $this->username;
                $cond = new CDbCriteria(array('condition' => "username = '$username'",));
                $users = Users::model()->findAll($cond);
                foreach ($users as $user): $password = $user->password;
                endforeach;
                if ($password != $this->password):
                    $this->password = $this->hashPassword($this->password);
                endif;
            }
            return true;
        } else
            return false;
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password) {
        return $this->hashPassword($password) === $this->password;
    }

    /**
     * Generates the password hash.
     * @param string password
     * @param string salt
     * @return string hash
     */
    public function hashPassword($password) {
        return md5($password);
    }

}
