<?php
/* @var $this CompraController */
/* @var $data Compra */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_compra')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_compra), array('view', 'id'=>$data->id_compra)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cliente_rut')); ?>:</b>
	<?php echo CHtml::encode($data->cliente_rut); ?>
	<br />


</div>