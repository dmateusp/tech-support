<?php
/* @var $this HotelitemController */
/* @var $model Hotelitem */

$this->breadcrumbs=array(
	'Objets'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Liste des objets de l\'hôtel', 'url'=>array('index')),
	array('label'=>'Créer un nouvel objet', 'url'=>array('create')),
	array('label'=>'Modifier un objet', 'url'=>array('update', 'id'=>$model->idhotelitem)),
	array('label'=>'Supprimer cet objet', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idhotelitem),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Gérer les objets', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logosettings.png" class="imgTitles"/>Objet numéro <?php echo $model->idhotelitem; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idhotelitem',
		'name',
		'imagesource',
		'idcreator',
	),
)); ?>
