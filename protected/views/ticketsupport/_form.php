<?php
/* @var $this TicketsupportController */
/* @var $model Ticketsupport */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ticketsupport-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Les champs avec une <span class="required">*</span> sont requis.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
	<b> Catégorie d'objet </b><br />
	<?php
		$opts = CHtml::listData(Categorie::model()->findAll(),'id','name');
		echo CHtml::dropDownList('categorieId','prompt', $opts,
		array(
			'prompt'=>'-- Catégorie --',
		    'ajax' => array(
		    'type'=>'POST', //request type
		    'url'=>CController::createUrl('hotelitem/dynamicitems'), //url to call.
			
		    //Style: CController::createUrl('currentController/methodToCall')
		    'update'=>'#idhotelitem', //selector to update

		    //'data'=>'js:javascript statement' 
		    //leave out the data key to pass all form values through

			),
			
		)); 

	?>
	</div>
	<div class="row">
	<b> Objet </b><br />
<?php
	//empty since it will be filled by the other dropdown
	$options = array(
	'prompt'=>'-- Objet --',
	'ajax' => array(
	'type'=>'POST', //request type
	'url'=>CController::createUrl('ticketsupport/dynamicimages'), //url to call.
	//Style: CController::createUrl('currentController/methodToCall')
	'update'=>'#img', //selector to update
	//'data'=>'js:javascript statement' 
	//leave out the data key to pass all form values through
	)); 
	echo CHtml::dropDownList('idhotelitem','prompt', array(),$options);
?>
	</div>
	<div class="row" id="img">
     <?php
     	echo CHtml::tag('img'),'Selectionnez un objet';
 	 ?>  
	</div>
	<br/>
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lieu'); ?>
		<?php echo $form->textField($model,'lieu',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'lieu'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'commentaire'); ?>
		<?php echo $form->textField($model,'commentaire',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'commentaire'); ?>
	</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Créer' : 'Sauvegarder'); ?>
	</div>
	<?php
	//DISPLAY MESSSAGES SUCH AS ERROR OR SUCCESS MESSAGES
	    foreach(Yii::app()->user->getFlashes() as $key => $message) {
	    	$type = substr($key, strrpos($key, '-') + 1);
	        echo '<div class="flash-'.$type.'">' . $message . "</div>\n";
	    }
	?>
<?php $this->endWidget(); ?>

</div><!-- form -->