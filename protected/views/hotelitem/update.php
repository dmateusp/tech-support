<?php
/* @var $this HotelitemController */
/* @var $model Hotelitem */

$this->breadcrumbs=array(
	'Gestion des objets'=>array('index'),
	$model->name=>array('view','id'=>$model->idhotelitem),
	'Modifier',
);

$this->menu=array(
	array('label'=>'Liste des objets de l\'hôtel', 'url'=>array('index')),
	array('label'=>'Créer un objet', 'url'=>array('create')),
	array('label'=>'Détails de l\'objet', 'url'=>array('view', 'id'=>$model->idhotelitem)),
	array('label'=>'Gérer les objets', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logosettings.png" class="imgTitles"/>Modifier l'objet numéro <?php echo $model->idhotelitem; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>