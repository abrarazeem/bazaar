<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $price
 * @property string $image
 * @property string $create_time
 * @property string $update_time
 * @property integer $shop_id
 * @property integer $product_category_id
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Shop $shop
 * @property ProductCategory $productCategory
 */
class Product extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Product the static model class
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
		return 'products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shop_id, product_category_id', 'required'),
			array('shop_id, product_category_id', 'numerical', 'integerOnly'=>true),
			array('name, image', 'length', 'max'=>100),
			array('price', 'length', 'max'=>10),
			array('description, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, price, image, create_time, update_time, shop_id, product_category_id', 'safe', 'on'=>'search'),
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
			'orders' => array(self::MANY_MANY, 'Order', 'order_details(products_id, order_id)'),
			'shop' => array(self::BELONGS_TO, 'Shop', 'shop_id'),
			'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
		);
	}
        public function getCategory()
        {
            $options = CHtml::listData(ProductCategory::model()->findAll('shop_id=1'),'id', 'name');
            return $options;

        }

        /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'price' => 'Price',
			'image' => 'Image',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'shop_id' => 'Shop',
			'product_category_id' => 'Product Category',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('shop_id',$this->shop_id);
		$criteria->compare('product_category_id',$this->product_category_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}