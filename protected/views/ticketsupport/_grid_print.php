<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ticketsupport-grid',
	 'ajaxUpdate'=>true,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'idticketSupport',
		'statut',
		'description',
		'lieu',
		'commentaire',
		'dateDemande',
		array(            
            'name'=>'initialeTechnicien',
            //call the method 'gridDataColumn' from the controller
            'value'=>array($model,'getInitialeTechnicienSearch'), 
        ),
		/*
		'datePriseEnCharge',
		'dateClotureTicket',
		'idutilisateurDemande',
		*/
	),
));
?>
