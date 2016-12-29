<?php
/* @var $this SalleController */
/* @var $model Salle */

$this->breadcrumbs=array(
	'Salles'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Liste des salles', 'url'=>array('index')),
	array('label'=>'Créer une salle', 'url'=>array('create')),
	array('label'=>'Modifier cette salle', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Supprimer cette salle', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Êtes-vous sûr de vouloir supprimer cette salle?')),
	array('label'=>'Gérer les salles', 'url'=>array('admin')),
);
?>

<h1>Détails de la salle numéro <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
