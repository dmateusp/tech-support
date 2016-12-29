<?php
/* @var $this LigneController */
/* @var $data Ligne */
?>
		<div class="view">

		<?php echo CHtml::hiddenField('numLigne' , $data->id, array('id' => 'numLigne')); ?>

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
		<?php echo CHtml::encode($data->id); ?>
		<br />


		<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
		<?php echo CHtml::encode($data->name); ?>
		<br />

		<?php 
	// query criteria
	    $criteria = new CDbCriteria();
	    // with Author model
	    $criteria->with = array('idligne0');
		 // compare title
		$criteria->compare('t.idligne', $data->id, true);

	    // compare title
	    // find all posts
	    $posts = Travailinterne::model()->findAll($criteria);
	    // show all posts
	    $maxDate=0;
	    foreach($posts as $post){
	    	if($post->dateDemande>$maxDate)
	    		$maxDate=$post->dateDemande;
	    }
	    if($maxDate==0)
	    	$maxDate='Aucune';
		
		//FORMATING DATES TO FRENCH FORMAT --------------------------------------
		if($maxDate!='Aucune'){
		    $maxDate = strtotime ($maxDate);
		    $maxDate = date ('d/m/Y H\h i\m', $maxDate);
		}
		?>


		<b><?php echo CHtml::encode('Dernière demande pour cette ligne '); ?>:</b>
		<?php echo CHtml::encode($maxDate); ?>
		<br />

		</div>
