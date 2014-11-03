<?php
/* @var $this PacienteController */
/* @var $model Paciente */

$this->breadcrumbs = array(
    'Pacientes' => array('index'),
    $model->rut_paciente,
);
$this->menu = array(
    array('label' => 'Modificar Datos', 'url' => array('update', 'id' => $model->rut_paciente)),
    
);
?>

<h1>Paciente <?php echo $model->nombre_paciente. " " . $model->apellidos_paciente; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'rut_paciente',
        'nombre_paciente',
        'apellidos_paciente',
        'direccion_paciente',
        'ciudad_paciente',
        'telefono_paciente',
        'correo_paciente',
        'sexo_paciente',
        'fecha_nac_paciente',
        'profesion_paciente',
        'lugar_trabajo',
    ),
));
?>
