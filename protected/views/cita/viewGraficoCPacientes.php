<?php

$i = 0;
$valores = array();
foreach ($datos as $dato) {
    $valores[$i] = array('type' => 'column', 'name' => $dato['rut_paciente'], 'data' => array($dato['total']));
    $i++;
}

$this->Widget('ext.highcharts.highcharts.HighchartsWidget', array(
    'options' => array(
        'title' => array('text' => 'Pagos pacientes entre : ' . $model->inicio . ' y ' . $model->fin),
        'xAxis' => array(
            'categories' => array('Pagos')
        ),
        'yAxis' => array(
            'title' => array('text' => 'Pesos')
        ),
        'series' => $valores,
    )
));
?>
