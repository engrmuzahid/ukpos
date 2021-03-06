<?php

/**
 * This is the model class for table "car_details".
 *
 * The followings are the available columns in table 'car_details':
 * @property integer $id
 * @property string $tatle
 * @property string $reg_no
 * @property string $model
 * @property string $details
 */
class CarDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarDetails the static model class
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
		return 'car_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tatle, reg_no, model, details', 'required'),
			array('tatle, reg_no, model', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tatle, reg_no, model, details', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tatle' => 'Tatle',
			'reg_no' => 'Reg No',
			'model' => 'Model',
			'details' => 'Details',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tatle',$this->tatle,true);
		$criteria->compare('reg_no',$this->reg_no,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('details',$this->details,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}