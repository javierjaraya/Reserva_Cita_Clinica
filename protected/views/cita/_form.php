<?php
/* @var $this CitaController */
/* @var $model Cita */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cita-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'rut_paciente'); ?>
		<?php echo $form->textField($model,'rut_paciente',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'rut_paciente'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'attribute'=>"fecha",
                'model'=>$model,
                'language'=>'es',
                'value'=>$model->fecha,
                'language' => 'es',
               
                    'options'=>array(
                        'autoSize'=>true,
                        'buttonImage'=>Yii::app()->baseUrl.'/images/calendar.png',
                        'buttonImageOnly'=>true,
                        'dateFormat'=>'yy-mm-dd',
                        'showButtonPanel'=>true,
                        'changeMonth'=>true,
                        'changeYear'=>true,
                        'minDate'=>'0',
                        'showOtherMonths'=>true,
                        'changeMonth' => 'true',
                        'changeYear' => 'true',
                        'yearRange'=>'-80',
                ),
            ))?>
		<?php echo $form->error($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hora'); ?>
		<?php echo $form->dropDownList($model,'hora',$model->getMenuHoras()); ?>
		<?php echo $form->error($model,'hora'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'id_tratamiento'); ?>
		<?php echo $form->dropDownList($model,'id_tratamiento',$model->getMenuTratamientos()); ?>
		<?php echo $form->error($model,'id_tratamiento'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->