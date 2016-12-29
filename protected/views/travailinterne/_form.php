<?php
/* @var $this TravailinterneController */
/* @var $model Travailinterne */
/* @var $form CActiveForm */
?>
<?php
$currentLigne='0';
if(isset($model->idligne))
	$currentLigne=$model->idligne;
Yii::app()->clientScript->registerScript('ligne', "
$(document).ready(function() {
	$('#idligne').prop('disabled', 'disabled');
	//Gérer l'affichage de lignes disponibles quand les dates sont remplies
	$('input.dateForm').focusout(function(){
		if($('input#Travailinterne_dateDebut').val()!='' && $('input#Travailinterne_dateFin').val()!='' ){
			$('#idligne').prop('disabled', false); //Si les deux dates sont rentrées alors on laisse le choix des lignes
		    $.ajax({
		         dataType: 'JSON',             
		         type: 'POST',
		         url: '/support_technique/database/databaseManager.php?func=getAvailableLignes',
		         data:{dateDebut: $('input#Travailinterne_dateDebut').val(),
		         		dateFin: $('input#Travailinterne_dateFin').val(),
		         		id: ".$currentLigne."},
		                                                            
		         success: function(result)//retour de requête
		         {
					$('#idligne option:gt(0)').remove(); // remove all options, but not the first 
					$.each(result, function(value,key) {
						var option =$('<option></option>');
						option.attr('value', key['id']).text(key['name']);
						if(key['avoid']==1)
							option.css('background', 'rgb(255,220,200)');
						$('#idligne').append($(option));
					});
					$('#idligne').val('".$currentLigne."');
					$('#idligne').trigger('change');
					
		         }
		     });
			
		}
		else{
			$('#idligne').prop('disabled', 'disabled'); //Sinon on désactive la selection
		}
	});

	$('#Travailinterne_description').keyup(function() { //cocher les checkbox quand un mot clé est trouvé
	   if( $(this).val().indexOf('téléphonique') > -1 || $(this).val().indexOf('telephonique') > -1 ) {
	    	$('#checkBoxObj_2').prop('checked', true);
	   }

	   if( $(this).val().indexOf('rallonge') > -1 ) {
	    	$('#checkBoxObj_1').prop('checked', true);
	   }

	   if( $(this).val().indexOf('internet') > -1 ) {
	    	$('#checkBoxObj_0').prop('checked', true);
	   }

	});

	$('#idligne').change(function(){
		$('#checkBoxObj_2').prop('checked', true);

		if(!$('#idligne').val())
			$('#checkBoxObj_2').prop('checked', false);	
	});
	$('input.dateForm').trigger('focusout');
	$('#Travailinterne_description').trigger('keyup');
	
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
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>

	<p class="note">Les champs avec une <span class="required">*</span> sont requis.</p>
	<div class="row">
		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		    }
		?>
	</div>
	<?php echo $form->errorSummary($model); ?>

	<div class="view">
	<h3> Informations générales</h3>
	<div class="row">
	<p><i>Utilisez le calendrier pour sélectionner vos dates (cliquez dans les différents champs), cela permet qu'elles soient correctes car elles doivent être rentrées dans le format Américain</i></p>
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
	        'placeholder' => 'Année-Mois-Jour',
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
	        'placeholder' => 'Année-Mois-Jour',
	        'class' => 'dateForm',
	    ),
    )
	);
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
		<?php echo $form->labelEx($model,'nomClient'); ?>
		<?php echo $form->textField($model,'nomClient',array('maxlength'=>55)); ?>
		<?php echo $form->error($model,'nomClient'); ?>
	</div>

	</div>
	<div class="view">
		<div class="row">
		<h3>Demande d'installation de matériel</h3>
		<table align="center" class="typeObj">
		<b> Liste du matériel demandé </b>
		<tr>
		<?php
			echo CHtml::checkBoxList('checkBoxObj',
            $selected_Array=array(),
            array('Connexion internet'=>'Connexion internet','Rallonge électrique'=>'Rallonge électrique', 'Ligne téléphonique'=>'Ligne téléphonique'),
			array(
	        'id' => 'checkBoxObj',
	        'template'=>'<td>{label}{input}</td>',
	        'selected'=>'true',
	        ));
		?>
 		</tr>
 	 	</table>
		</div>

		<div class="row">

		<b> Demande de ligne téléphonique (liste des lignes disponibles) </b><br />
		<i> Les lignes téléphoniques en rouge sont utilisées la veille ou le lendemain de votre réservation, ne les réservez qu'en cas de nécessité </i><br/>
		<?php
			$opts = CHtml::listData(Ligne::model()->findAll(),'id','name');
			echo CHtml::dropDownList('idligne','prompt', $opts,array('empty'=>'(Choisissez une ligne à réserver)'));
		?>
		</div>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('maxlength'=>405)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
			<b> Joindre un fichier (PDF, PNG, JPG, XLS, XLSX, DOC, DOCX) </b><br/>
	        <?php echo CHtml::activeFileField($model, 'docsource'); ?>  
	        <?php echo $form->error($model,'docsource'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Créer' : 'Sauvegarder'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->