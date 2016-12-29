<?php
/* @var $this HotelitemController */
/* @var $model Hotelitem */

$this->breadcrumbs=array(
	'Objets'=>array('index'),
	'Gestion',
);

$this->menu=array(
	array('label'=>'Liste des objets de l\'hôtel', 'url'=>array('index')),
	array('label'=>'Créer un nouvel objet', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#hotelitem-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><img src="./css/logosettings.png" class="imgTitles"/>Gérer les objets</h1>

<p>
Veuillez remplir les différents champs de recherche puis appuyer sur "Enter" pour valider la recherche
</p>
<?php
/*
?>
<?php echo CHtml::link('Recherche avancée','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php*/?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'hotelitem-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'idhotelitem',
		'name',
		'idcreator',
		array(            
            'name'=>'idcategorie',
            'value'=>array($model,'getNameCategorieSearch'),
            //call the method 'gridDataColumn' from the controller
            'filter'=> CHtml::dropDownList( 'Hotelitem[idcategorie]','prompt',
				CHtml::listData( Categorie::model()->findAll( array( 'order' => 'id' ) ), 'id', 'name' ),
				array('prompt'=>'-- Catégorie --')),
        ),
        array(
			'class'=>'CButtonColumn',
		),
	))); ?>
