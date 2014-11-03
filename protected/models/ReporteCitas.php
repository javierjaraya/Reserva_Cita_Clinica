<?php

class ReporteCitas extends CActiveRecord
{
        public $inicio;
        public $fin;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cita';
	}

	/**
	 * @return array validation rules formodel attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inicio, fin', 'required'),			
		);
	}

	public function attributeLabels()
	{
		return array(
			'inicio' => 'Inicio',
                        'fin' => 'Fin',
		);
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
?>
