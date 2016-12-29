<?php
/* @var $this UtilisateurController */
/* @var $model Utilisateur */

$this->breadcrumbs=array(
	'Utilisateurs'=>array('index'),
	'Gérer',
);

$this->menu=array(
	array('label'=>'Liste utilisateurs', 'url'=>array('index')),
	array('label'=>'Créer utilisateurs', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#utilisateur-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><img src="./css/logouser.png" class="imgTitles"/>Gestion des utilisateurs</h1>
<h4>Remplissez un ou plusieurs champ(s) puis appuyez sur "Enter"</h4>

<?php echo CHtml::link('Recherche avancée','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'utilisateur-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'login',
		'initiale',
		'type',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
