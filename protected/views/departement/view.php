<?php
/* @var $this DepartementController */
/* @var $model Departement */

$this->breadcrumbs=array(
	'Departements'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Liste des départements', 'url'=>array('index')),
	array('label'=>'Créer un déparement', 'url'=>array('create')),
	array('label'=>'Modifier ce département', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Supprimer département', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Confirmer la suppression de ce déparement ?')),
	array('label'=>'Gérer les départements', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logofolder.png" class="imgTitles"/>Détails du déparement numéro <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
