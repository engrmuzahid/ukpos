<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $product_category_id
 * @property string $product_type_id
 * @property string $product_brand_id
 * @property string $product_code
 * @property string $product_name
 * @property string $location
 * @property string $unit_type_id
 * @property string $description
 * @property double $purchase_cost
 * @property double $vat
 * @property double $other_cost
 * @property double $sell_price
 * @property integer $min_stock
 * @property string $expire_date
 * @property string $image
 * @property double $vat_on_purchase
 * @property double $vat_on_profit
 */
class Product extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{product}}';
    }

    public function rules() {
        return array(
            array('product_code, product_name,purchase_cost, sell_price, vat, min_stock', 'required'),
            array('purchase_cost, sell_price, other_cost, vat_on_purchase,offer_price, vat_on_profit', 'numerical', 'integerOnly' => false),
            array('description, other_cost,offer_quantity,offerPrice,wholesale_price,photo_caption,is_boucher', 'safe'),
            array('product_code, product_name', 'unique'),
            array('expire_date', 'length', 'max' => 255),
                //array('image', 'file', 'types'=>'jpg, gif, png', 'safe'=>true)
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_category_id' => 'Product Category',
            'product_type_id' => 'Product Type',
            'product_brand_id' => 'Product Brand',
            'online_category_id' => 'Online Category',
            'offer_price' => 'Offer price',
            'product_code' => 'Product Code',
            'product_name' => 'Product Name',
            'location' => 'Location',
            'unit_type_id' => 'Unit Type',
            'description' => 'Description',
            'purchase_cost' => 'Purchase Cost',
            'vat' => 'Vat',
            'other_cost' => 'Profit Margin',
            'sell_price' => 'Sell Price',
            'offerPrice' => 'Offer Price',
            'offer_quantity' => 'Offer Quantity',
            'min_stock' => 'Min Stock',
            'expire_date' => 'Expire Date',
            'image' => 'Image',
            'photo_caption' => 'Photo Caption',
             'is_boucher' => 'Boucher'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('product_category_id', $this->product_category_id, true);
        $criteria->compare('product_type_id', $this->product_type_id, true);
        $criteria->compare('product_brand_id', $this->product_brand_id, true);
        $criteria->compare('product_code', $this->product_code, true);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('location', $this->location, true);
        $criteria->compare('unit_type_id', $this->unit_type_id, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('purchase_cost', $this->purchase_cost);
        $criteria->compare('vat', $this->vat);
        $criteria->compare('other_cost', $this->other_cost);
        $criteria->compare('sell_price', $this->sell_price);
        $criteria->compare('offerPrice', $this->offerPrice);
        $criteria->compare('offer_quantity', $this->offer_quantity);
        $criteria->compare('min_stock', $this->min_stock);
        $criteria->compare('expire_date', $this->expire_date);
        $criteria->compare('image', $this->image);
        $criteria->compare('is_boucher', $this->is_boucher);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    function getId() {
        return 'product' . $this->id;
    }

    function getPrice() {
        return $this->sell_price;
    }

}
