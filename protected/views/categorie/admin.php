<?php
/* @var $this CategorieController */
/* @var $model Categorie */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Gérer',
);

$this->menu=array(
	array('label'=>'Liste des catégories', 'url'=>array('index')),
	array('label'=>'Créer une catégorie', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#categorie-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><img src="./css/logofolder.png" class="imgTitles"/>Gestion des catégories</h1>


<?php echo CHtml::link('Recherche avancée','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'categorie-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
