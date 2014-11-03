<?php

/**
 * This is the model class for table "detallecompra".
 *
 * The followings are the available columns in table 'detallecompra':
 * @property integer $id_detalle
 * @property integer $id_de_compra
 * @property integer $id_de_producto
 * @property integer $precio_final
 *
 * The followings are the available model relations:
 * @property Compra $idDeCompra
 * @property Producto $idDeProducto
 */
class Detallecompra extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detallecompra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_de_compra, id_de_producto, precio_final', 'required'),
			array('id_de_compra, id_de_producto, precio_final', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_detalle, id_de_compra, id_de_producto, precio_final', 'safe', 'on'=>'search'),
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
			'idDeCompra' => array(self::BELONGS_TO, 'Compra', 'id_de_compra'),
			'idDeProducto' => array(self::BELONGS_TO, 'Producto', 'id_de_producto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_detalle' => 'Id Detalle',
			'id_de_compra' => 'Id De Compra',
			'id_de_producto' => 'Id De Producto',
			'precio_final' => 'Precio Final',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_detalle',$this->id_detalle);
		$criteria->compare('id_de_compra',$this->id_de_compra);
		$criteria->compare('id_de_producto',$this->id_de_producto);
		$criteria->compare('precio_final',$this->precio_final);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Detallecompra the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
