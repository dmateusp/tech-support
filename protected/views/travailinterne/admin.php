<?php
/* @var $this TravailinterneController */
/* @var $model Travailinterne */

$this->breadcrumbs=array(
	'Travail interne'=>array('index'),
	'Gestion',
);

$this->menu=array(
	array('label'=>'Liste des demandes', 'url'=>array('index')),
	array('label'=>'Créer une demande', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#travailinterne-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><img src="./css/logorepair.png" class="imgTitles"/>Gestion des demandes de travail interne</h1>

<?php /*echo CHtml::link('Recherche avancée','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
));*/ ?>
<!--</div>--><!-- search-form -->


	<?php
	//DISPLAY MESSSAGES SUCH AS ERROR OR SUCCESS MESSAGES
	    foreach(Yii::app()->user->getFlashes() as $key => $message) {
	    	$type = substr($key, strrpos($key, '-') + 1);
	        echo '<div class="flash-'.$type.'">' . $message . "</div>\n";
	    }
	?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'travailinterne-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(            
            'name'=>'initialeutilisateurDemande',
            'value'=>array($model,'getUtilisateurDemandeSearch'),
            //call the method 'gridDataColumn' from the controller
        ),
		array(            
            'name'=>'idsalle',
            'value'=>array($model,'getSalleSearch'),
            //call the method 'gridDataColumn' from the controller
            'filter'=> CHtml::dropDownList( 'Travailinterne[idsalle]','prompt',
				CHtml::listData(Salle::model()->findAll( array( 'order' => 'name' ) ), 'id', 'name' ),
				array('prompt'=>'-- Salle --')),
        ),
		array(            
            'name'=>'idligne',
            'value'=>array($model,'getLigneSearch'),
            //call the method 'gridDataColumn' from the controller
            'filter'=> CHtml::dropDownList( 'Travailinterne[idligne]','prompt',
				CHtml::listData(Ligne::model()->findAll( array( 'order' => 'name' ) ), 'id', 'name' ),
				array('prompt'=>'-- Tel --')),
        ),
		'dateDemande',
		'dateDebut',
		'dateFin',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
