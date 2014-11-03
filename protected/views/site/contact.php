
<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'Encuéntranos',
);
?>
<h3 align="center">Encuéntranos</h3>

<div align="center">Nos encontramos ubicados en El Roble #589, Chillán. En el edificio de la Sociedad de Empleados del Comercio, 2do piso.</div>


<script>
$.fn.googlemap = function(){
    // author: Christian Salazar <christiansalazarh@gmail.com>
    var src='';
    $(this).each(function(){
    var z = $(this);
    var address = jQuery.trim(z.attr('streetnumber'))
        +'+'+jQuery.trim(z.attr('streetname'))
        +'+'+jQuery.trim(z.attr('cityname'))
        +'+'+jQuery.trim(z.attr('statecode'))
        +'+'+jQuery.trim(z.attr('zipcode'))
    ;
    src="https://maps.google.com/maps?"
        +"client=safari"
        +"&q="+address
        +"&oe=UTF-8&ie=UTF8&hq="
        +"&hnear="+address
        +"&gl=us"
        +"&z="+z.attr('zoom')
        +"&output=embed";
        z.html("<iframe src='"+src+"' width="+z.attr('width')+" height="
        +z.attr('height')+"></iframe>");
    });
    return src;
}
</script>
<div id='map' streetnumber='589' streetname='EL ROBLE'
        cityname='CHILLAN'  zipcode='3780000'
        zoom=18 width=500 height=300 align="center">
</div>
<script>$('#map').googlemap();</script>
<?php 

?>