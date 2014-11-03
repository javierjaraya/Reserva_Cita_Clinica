<?php
        $this->Widget('ext.highcharts.highcharts.HighchartsWidget', array(
           'options'=>array(
                'chart' => array (
                    'plotBackgroundColor' => null,
                    'plotBorderWidth'=> 1,//null,
                    'plotShadow'=> false
                ),
                'title'=> array(
                    'text'=> 'N° de Tratamientos Realizados entre '.$model->inicio. ' y '.$model->fin
                ),
                'tooltip' => array(
                    'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>'
                ),
                'plotOptions' => array(
                    'pie' => array(
                        'allowPointSelect' => true,
                        'cursor' => 'pointer',
                        'dataLabels'=> array(
                            'enabled' => true,
                            'format' => '<b>{point.name}</b>: {point.percentage:.1f} %',
                            'style' => array(
                                //'color' => (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            )
                        )
                    )
                ),
                'series' => array(
                        array(
                            'type' => 'pie',
                            'name' => 'Browser share',
                            'data' => $ppc,
                        )
                )
            )
        ));

        ?>