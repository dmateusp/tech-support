<?php
/* @var $this TicketsupportController */
/* @var $model Ticketsupport */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idticketSupport'); ?>
		<?php echo $form->textField($model,'idticketSupport'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'namedepartement'); ?>
		<?php 
		$this->widget('ext.EchMultiSelect.EchMultiSelect', array(
		                'model' => $model,
		                'dropDownAttribute' => 'namedepartement',
		                'data' => CHtml::listData( Departement::model()->findAll( array( 'order' => 'id' ) ), 'id', 'name' ),
		                'options' => array('buttonWidth' => 80, 'ajaxRefresh' =>false),
		            	)
	        		);
		 ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'statut'); ?>
		<?php 
		$this->widget('ext.EchMultiSelect.EchMultiSelect', array(
		                'model' => $model,
		                'dropDownAttribute' => 'statut',
		                'data' => array(
								0 => 'créé',
								1 => 'pris en charge',
								2 => 'en attente',
								3 => 'clôturé',
								),
		                'options' => array('buttonWidth' => 80, 'ajaxRefresh' =>false),
		            	)
	        		);
		 ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lieu'); ?>
		<?php echo $form->textField($model,'lieu',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'commentaire'); ?>
		<?php echo $form->textField($model,'commentaire',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'initialeTechnicien'); ?>
	<?php
	$this->widget('ext.EchMultiSelect.EchMultiSelect', array(
	                'model' => $model,
	                'dropDownAttribute' => 'initialeTechnicien',
	                'data' => CHtml::listData( Utilisateur::model()->findAllByAttributes(array('type'=>'T')) , 'initiale', 'initiale' ),
	                'options' => array('buttonWidth' => 80, 'ajaxRefresh' =>false),
	            	)
        		);
    ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dateDemande'); ?>
		<?php echo $form->textField($model,'dateDemande'); ?>
	</div>








	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->