<?php

/**
 * This is the model class for table "shop".
 *
 * The followings are the available columns in table 'shop':
 * @property integer $id
 * @property string $name
 * @property string $descripton
 * @property string $create_time
 * @property string $image
 * @property integer $shop_category_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property ProductCategory[] $productCategories
 * @property Products[] $products
 * @property ShopCategory $shopCategory
 */
class Shop extends CActiveRecord
{
	public $verifyCode;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Shop the static model class
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
		return 'shop';
	}
        public function getCategory()
        {
            $options = CHtml::listData(ShopCategory::model()->findAll(), 'id', 'name');
            return $options;
        }

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shop_category_id,name,', 'required'),
		
			array('shop_category_id, user_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('image', 'length', 'max'=>100),
			array('descripton, create_time', 'safe'),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, descripton, create_time, image, shop_category_id, user_id', 'safe', 'on'=>'search'),
		);
	}

        public function beforeSave()
        {
            $this->create_time = new CDbExpression('now()');
           
            return parent::beforeSave();
        }




	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'productCategories' => array(self::HAS_MANY, 'ProductCategory', 'shop_id'),
			'products' => array(self::HAS_MANY, 'Products', 'shop_id'),
			'shopCategory' => array(self::BELONGS_TO, 'ShopCategory', 'shop_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Shop Name',
			'descripton' => 'Descripton',
			'create_time' => 'Create Time',
			'image' => 'Image',
			'shop_category_id' => 'Shop Category',
			'user_id' => 'User',
			'verifyCode'=>'Verification Code',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('descripton',$this->descripton,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('shop_category_id',$this->shop_category_id);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}