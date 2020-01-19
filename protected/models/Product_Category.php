<?php

class Product_Category extends CActiveRecord {

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
        return '{{product_category}}';
    }

    public function rules() {
        return array(
            array('category_name, sort_order, parent_id', 'required'),
            array('category_name', 'unique'),
            array('photo_caption,isOnline,color_code', 'safe')
        );
    }

}
