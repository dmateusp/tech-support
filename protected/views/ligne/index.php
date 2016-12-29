<?php
/* @var $this LigneController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Travail interne'=>array('travailinterne/index'),
	'Lignes',
);

$this->menu=array(
	array('label'=>'Calendrier d\'utilisation des lignes', 'url'=>array('calendar')),
	array('label'=>'Créer une ligne', 'url'=>array('create')),
	array('label'=>'Gérer les lignes', 'url'=>array('admin')),
);
?>
<?php
/*
Yii::app()->clientScript->registerScript('ligneclick', "
$('a.availableButton').click(function(){
	var isAvailable = $(this).find('#available').val();
	var numLigne = $(this).find('#numLigne').val();
	if(isAvailable==1){
		var newStatus = 0;
		var color = '#ff8686'; //rouge
	}
	else{
		newStatus = 1;
		var color = '#8aff5b'; //vert
	}
	$(this).find('#available').val(newStatus);
    $.ajax({
         dataType: 'html',             
         type: 'POST',
         url: '/support_technique/database/databaseManager.php?func=changeAvailable',
         data:{available: newStatus,
         		idligne: numLigne},
                                                            
         success: function(result)//retour de requête
         {
             alert('Changement de statut effectué');
         }
     });
	$(this).children().children().css('background-color', color);
});
"
);
*/?>
<h1><img src="./css/logofile.png" class="imgTitles"/>Liste des lignes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
