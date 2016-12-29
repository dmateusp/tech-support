<?php
/* @var $this HotelitemController */
/* @var $model Hotelitem */

$this->breadcrumbs=array(
	'Objets'=>array('index'),
	'Créer un objet',
);

$this->menu=array(
	array('label'=>'Liste des objets de l\'hôtel', 'url'=>array('index')),
	array('label'=>'Gérer les objets', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logosettings.png" class="imgTitles"/>Créer un objet</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>