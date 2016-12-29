<?php
/* @var $this DepartementController */
/* @var $model Departement */

$this->breadcrumbs=array(
	'Departements'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Modification',
);

$this->menu=array(
	array('label'=>'Liste des départements', 'url'=>array('index')),
	array('label'=>'Créer un département', 'url'=>array('create')),
	array('label'=>'Voir les infos du département', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gérer les départements', 'url'=>array('admin')),
);
?>

<h1>Modifier le département numéro <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>