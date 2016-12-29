
<div class="noprint">
<?php
/* @var $this TicketsupportController */
/* @var $model Ticketsupport */
Yii::app()->clientScript->registerCoreScript('jquery.ui');
$this->breadcrumbs=array(
	'Demandes au support'=>array('index'),
	'Gestion',
);
	$user = Yii::app()->db->createCommand()
    ->select('type')
    ->from('utilisateur')
    ->where('idutilisateur=:id', array(':id'=>Yii::app()->user->id))
    ->queryRow();
    //$user['type']

$this->menu=array(
	array('label'=>'Liste des demandes au support', 'url'=>array('index')),
	array('label'=>'Créer des demandes support', 'url'=>array('create'), 'visible' => !Yii::app()->user->isGuest),
);
?>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/ticketsupport.js',CClientScript::POS_END);

/*Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ticketsupport-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});



$('#ticketsupport-affecter').submit( function(eventObj) {
      $('<input />').attr('type', 'hidden')
          .attr('name', 'ids-appended')
          .attr('value', tab)
          .appendTo(this);
      return true;
  });
$('#ticketsupport-grpEnAttente').submit( function(eventObj) {
      $('<input />').attr('type', 'hidden')
          .attr('name', 'ids-appended')
          .attr('value', tab)
          .appendTo(this);
      return true;
  });
$('#ticketsupport-grpSortirAttente').submit( function(eventObj) {
      $('<input />').attr('type', 'hidden')
          .attr('name', 'ids-appended')
          .attr('value', tab)
          .appendTo(this);
      return true;
  });
$('#ticketsupport-grpCloturer').submit( function(eventObj) {
      $('<input />').attr('type', 'hidden')
          .attr('name', 'ids-appended')
          .attr('value', tab)
          .appendTo(this);
      return true;
  });


$('input:checkbox').removeAttr('checked');     
$(this).val('check all');


var tab = [];
$('body').delegate('.checkbox-column','change',function(){
	var idcheckbox = $(this).children('input').attr('id');
	var id = $(this).parent().children(':first-child').html();
	var isCheck = $(this).children(':first-child').is(':checked');
	if(idcheckbox=='ticketsupport-grid_c10_all'){
		if(isCheck){
			tab = [];
			$(this).parent().parent().parent().children().eq(1).children().each(function(){
				isCheck = $(this).children(':last-child').children().is(':checked');
				tab.push($(this).children(':first-child').html());
			})		
		}
		else{
			tab=[];
		}

	}
	else{
		$(this).parent().children(':first-child').each(function() { 
			if(isCheck){
				tab.push($(this).html());		
			}
			else{
				var removeItem=$(this).html();
				tab = $.grep(tab, function(value) {
				  return value != removeItem;
				});
			}	
		});	
	}
	
	function sendGrpEnAttente(tab){
		var data = tab;
		$.ajax({
		   type: 'POST',
		    url: '<?php echo Yii::app()->createAbsoluteUrl(\'/ticketsupport/grpenattente\'); ?>',
		   data:data,
		success:function(data){
		                alert(data); 
		              },
		   error: function(data) { // if error occured
		         alert(\"Error occured\");
		         alert(data);
		    },
		 
		  dataType:'html'
		  });
	}

});
	

"
);*/

?>
<div class="noprint">
	<?php
	//DISPLAY MESSSAGES SUCH AS ERROR OR SUCCESS MESSAGES
	    foreach(Yii::app()->user->getFlashes() as $key => $message) {
	    	$type = substr($key, strrpos($key, '-') + 1);
	        echo '<div class="flash-'.$type.'">' . $message . "</div>\n";
	    }
	?>
<h1><img src="./css/logorepair.png" class="imgTitles"/>Gérer les demandes support</h1>

<p>
Remplissez un ou plusieurs champs puis appuyez sur "Enter"
</p>
<p>
<?php echo CHtml::link('Recherche avancée','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
</p>
</div>

<!-- gridView -->
<?php
 $this->renderPartial('_grid',array(
	'model'=>$model,
)); ?>
<div class="noprint">
<table>
<tr>
<td>
<!-- AFFECTER -->
<div class="form">
<?php
	 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ticketsupport-affecter',
	'action' => Yii::app()->createUrl('/ticketsupport/affecter'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
                       'onsubmit'=>"return false;",/* Disable normal form submit */
                     ),
)); 
?>



	<div class="row">
	<b><?php
	if($user['type']=='A') 
		echo CHtml::encode("Affecter la sélection à "); ?></b>
	<br />
	</div>

	<div class="row">
	<?php 
	if($user['type']=='A'){
		$models =Utilisateur::model()->findAllByAttributes(array(),"type='A' OR type='T'");
		$opts = CHtml::listData($models,'idutilisateur','initiale');
		echo $form->dropDownList($model,'idtechnicien',$opts,'',array('empty'=>'(Choisissez un utilisateur)')); 
	}
		?>	

	</div>


	<div class="row buttons">

		<?php 
		if($user['type']=='A')
			echo CHtml::submitButton($model->isNewRecord ? 'Affecter' : 'Sauvegarder'); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>
</td>
<td>
<!-- METTRE EN ATTENTE -->
<div class="form">
<?php
	 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ticketsupport-grpEnAttente',
	//'action' => Yii::app()->createUrl('/ticketsupport/grpenattente'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
                           'onsubmit'=>"return false;",/* Disable normal form submit */
                         ),
)); 
?>



	<div class="row">
	<b><?php
	if($user['type']=='A') 
		echo CHtml::encode("Mettre la selection en attente"); ?></b>
	<br />
	</div>

	<div class="row buttons">

		<?php 
		if($user['type']=='A')
			echo CHtml::submitButton($model->isNewRecord ? 'En attente' : 'Sauvegarder'); ?>
	</div>
<?php $this->endWidget(); ?>
<?php
	 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ticketsupport-grpSortirAttente',
	'action' => Yii::app()->createUrl('/ticketsupport/grpsortirattente'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
                       'onsubmit'=>"return false;",/* Disable normal form submit */
                     ),
)); 
?>
	<div class="row">
	<b><?php
	if($user['type']=='A') 
		echo CHtml::encode("Sortir la selection du statut en attente"); ?></b>
	<br />
	</div>

	<div class="row buttons">

		<?php 
		if($user['type']=='A')
			echo CHtml::submitButton($model->isNewRecord ? 'Sortir du statut en attente' : 'Sauvegarder'); ?>
	</div>
<?php $this->endWidget(); ?>
</td>
<td>
<!-- CLOTURER -->
<div class="form">
<?php
	 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ticketsupport-grpCloturer',
	'action' => Yii::app()->createUrl('/ticketsupport/grpcloturer'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); 
?>



	<div class="row">
	<b><?php
	if($user['type']=='A') 
		echo CHtml::encode("Clôturer la selection"); ?></b>
	<br />
	</div>

	<div class="row buttons">

		<?php 
		if($user['type']=='A')
			echo CHtml::submitButton($model->isNewRecord ? 'Valider' : 'Sauvegarder'); ?>
	</div>
	<?php $this->endWidget(); ?>
</td>
</tr>
</table>
</div>
