<?php
/* @var $this TravailinterneController */
/* @var $model Travailinterne */
/* @var $form CActiveForm */
?>
<?php
Yii::app()->clientScript->registerScript('ligne', "
$(document).ready(function() {
	$('#idligne').prop('disabled', 'disabled');
	$('input.dateForm').focusout(function(){
		if($('input#Travailinterne_dateDebut').val()!='' && $('input#Travailinterne_dateFin').val()!='' ){
			$('#idligne').prop('disabled', false); //Si les deux dates sont rentrées alors on laisse le choix des lignes
		    $.ajax({
		         dataType: 'JSON',             
		         type: 'POST',
		         url: '/support_technique/database/databaseManager.php?func=getAvailableLignes',
		         data:{dateDebut: $('input#Travailinterne_dateDebut').val(),
		         		dateFin: $('input#Travailinterne_dateFin').val()},
		                                                            
		         success: function(result)//retour de requête
		         {
					$('#idligne option:gt(0)').remove(); // remove all options, but not the first 
					$.each(result, function(value,key) {
						$('#idligne').append($('<option></option>')
						     .attr('value', key['id']).text(key['name']));
					});
		         }
		     });
		}
		else{
			$('#idligne').prop('disabled', 'disabled'); //Sinon on désactive la selection
		}
	});
});
"
);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'travailinterne-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Les champs avec une <span class="required">*</span> sont requis.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
	<?php echo $form->labelEx($model,'dateDebut'); ?>
	<?php
	$this->widget(
    'ext.jui.EJuiDateTimePicker',
    array(
        'model'     => $model,
        'attribute' => 'dateDebut',
        'language'=>'fr',
        //'language'=> 'ru',//default Yii::app()->language
        //'mode'    => 'datetime',//'datetime' or 'time' ('datetime' default)
        'options'   => array(
        	'showAnim'=>'fold',
            'dateFormat' => 'yy-mm-dd',
            'timeFormat' => 'hh:mm:00',//'hh:mm tt' default
        ),
	    'htmlOptions'=>array(
	        'style'=>'height:20px;',
	        'placeholder' => 'AAAA-MM-JJ hh:mm:ss',
	        'class' => 'dateForm',

	    ),
    )
	);
	?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($model,'dateFin'); ?>
	<?php
	$this->widget(
    'ext.jui.EJuiDateTimePicker',
    array(
        'model'     => $model,
        'attribute' => 'dateFin',
        'language'=>'fr',
        //'language'=> 'ru',//default Yii::app()->language
        //'mode'    => 'datetime',//'datetime' or 'time' ('datetime' default)
        'options'   => array(
        	'showAnim'=>'fold',
            'dateFormat' => 'yy-mm-dd',
            'timeFormat' => 'hh:mm:00',//'hh:mm tt' default
        ),
	    'htmlOptions'=>array(
	        'style'=>'height:20px;',
	        'placeholder' => 'AAAA-MM-JJ hh:mm:ss',
	        'class' => 'dateForm',
	    ),
    )
	);
	?>
	</div>
	<div class="row">
		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		    }
		?>
	</div>

	<div class="row">
	<b> Lieu </b><br />
	<?php
		$opts = CHtml::listData(Salle::model()->findAll(array('order'=>'name')),'id','name');
		echo CHtml::dropDownList('idsalle','prompt', $opts)

	?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('maxlength'=>250)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
	<div class="row">
	<b> Demande de ligne téléphonique (liste des lignes disponibles) </b><br />
	<?php
		$opts = CHtml::listData(Ligne::model()->findAll(),'id','name');
		echo CHtml::dropDownList('idligne','prompt', $opts,array('empty'=>'(Choisissez une ligne à réserver)'));
	?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Créer' : 'Sauvegarder'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->