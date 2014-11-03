<?php

/**
 * This is the model class for table "cita".
 *
 * The followings are the available columns in table 'cita':
 * @property integer $id_cita
 * @property string $rut_paciente
 * @property string $estado_cita
 * @property string $fecha
 * @property integer $id_bloque
 *
 * The followings are the available model relations:
 * @property Bloque $idBloque
 * @property Paciente $rutPaciente
 */
class Cita extends CActiveRecord
{
        public $hora;
        public $fin;
        public $paciente;
        public $apellidos;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cita';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rut_paciente, estado_cita, fecha, id_bloque, hora, id_tratamiento', 'required'),
			array('id_bloque', 'numerical', 'integerOnly'=>true),
			array('rut_paciente', 'length', 'max'=>20),
			array('estado_cita', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cita, rut_paciente, estado_cita, fecha, id_bloque, hora, fin, paciente, apellidos, id_tratamiento', 'safe', 'on'=>'search'),
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
			'idBloque' => array(self::BELONGS_TO, 'Bloque', 'id_bloque'),
			'rutPaciente' => array(self::BELONGS_TO, 'Paciente', 'rut_paciente'),
                        'idTratamiento' => array(self::BELONGS_TO, 'Tratamiento', 'id_tratamiento'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_cita' => 'Id Cita',
			'rut_paciente' => 'Rut',
			'estado_cita' => 'Estado',
			'fecha' => 'Fecha',
			'id_bloque' => 'Id Bloque',
                        'hora' => 'Inicio',
                        'paciente' => 'Nombre',
                        'apellidos' => 'Apellidos',
                        'fin' => 'Fin',
                        'id_tratamiento' => 'Id Tratamiento',
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
                $criteria->with = array('idBloque','rutPaciente');
                $criteria->compare('idBloque.inicio', $this->hora, true);
                $criteria->compare('idBloque.fin', $this->fin, true);
                $criteria->compare('rutPaciente.nombre_paciente',$this->paciente,true);
                $criteria->compare('rutPaciente.apellidos_paciente',$this->apellidos,true);
		$criteria->compare('t.id_cita',$this->id_cita);
		$criteria->compare('t.rut_paciente',$this->rut_paciente,true);
		$criteria->compare('t.estado_cita',$this->estado_cita,true);
		$criteria->compare('t.fecha',$this->fecha,true);
		$criteria->compare('t.id_bloque',$this->id_bloque);
                $criteria->compare('t.id_tratamiento',$this->id_tratamiento);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getMenuHoras() {
            
            return CHtml::listData(Bloque::model()->findAllByAttributes(array('id_dia'=>1)), "inicio", "inicio");
            
        }
        
        public function getMenuTratamientos() {
            
            return CHtml::listData(Tratamiento::model()->findAll(), "id_tratamiento", "nombre");
            
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cita the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
