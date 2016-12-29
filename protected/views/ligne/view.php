<?php
/* @var $this LigneController */
/* @var $model Ligne */

$this->breadcrumbs=array(
	'Travail interne'=>array('travailinterne/index'),
	'Lignes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Liste des lignes', 'url'=>array('index')),
	array('label'=>'Créer une ligne', 'url'=>array('create')),
	array('label'=>'Modifier cette ligne', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Supprimer cette ligne', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Êtes-vous sûr de supprimer cette ligne?')),
	array('label'=>'Gérer les lignes', 'url'=>array('admin')),
);
?>

<h1>Voir ligne numéro <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
