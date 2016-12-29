<?php
/* @var $this LigneController */
/* @var $model Ligne */

$this->breadcrumbs=array(
	'Travail interne'=>array('travailinterne/index'),
	'Lignes'=>array('index'),
	'Gérer lignes',
);

$this->menu=array(
	array('label'=>'Liste des lignes', 'url'=>array('index')),
	array('label'=>'Créer une ligne', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ligne-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><img src="./css/logorepair.png" class="imgTitles"/>Gérer lignes</h1>


<?php echo CHtml::link('Recherche avancée','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ligne-grid',
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
