<div class="gridTickets">
<?php 

	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ticketsupport-grid',
	 'ajaxUpdate'=>true,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate'=>'
		function(id, data){	
			console.log(tab);
			function checkSelected(element, index, array) {
    			$(\'tr:contains(\'+tab[index]+\')\').children(\':last-child\').children().prop("checked", true);			}
			tab.forEach(checkSelected);
		}',
	'rowCssClassExpression'=>'"statutNum".$data->statut',
	'columns'=>array(
		'idticketSupport',
		array(            
            'name'=>'namedepartement',
            'value'=>array($model,'getNameDepartementSearch'),
            //call the method 'gridDataColumn' from the controller
            'filter'=> CHtml::dropDownList( 'Ticketsupport[namedepartement]','prompt',
				CHtml::listData( Departement::model()->findAll( array( 'order' => 'id' ) ), 'id', 'name' ),
				array('prompt'=>'-- Département --')),
        ),
		array(            
            'name'=>'statut',
            'value'=>array($model,'getValueStatutSearch'),
            //call the method 'gridDataColumn' from the controller
            'filter'=> CHtml::dropDownList( 'Ticketsupport[statut]','prompt',
				array(
					0 => 'créé',
					1 => 'pris en charge',
					2 => 'en attente',
					3 => 'clôturé',
					),
				array('prompt'=>'-- Statut --')),
        ),
		'lieu',
		array(            
            'name'=>'nameitem',
            //call the method 'gridDataColumn' from the controller
            'value'=>array($model,'getNameItemSearch'), 
        ),
		'description',
		'dateDemande',
		'commentaire',
		/*array(            
            'name'=>'initialeTechnicien',
            'htmlOptions' => array( 'class' => 'group_title' ),
            //call the method 'gridDataColumn' from the controller
            'value'=>array($model,'getInitialeTechnicienSearch'),*/

			/*'filter'=> CHtml::dropDownList( 'Ticketsupport[initialeTechnicien]', 'initialeTechnicien',
					CHtml::listData( Utilisateur::model()->findAll( array( 'order' => 'initiale' ) ), 'initiale', 'initiale' ),
					array( 'Tout' => 'tout' )

			),*/
		array(
	            'name'=>'initialeTechnicien',
	            'value'=>array($model,'getInitialeTechnicienSearch'),
	            'filter'=> CHtml::dropDownList( 'Ticketsupport[initialeTechnicien]', 'prompt',
					CHtml::listData( Utilisateur::model()->findAllByAttributes(array(),"type='A' OR type='T'"), 'initiale', 'initiale' ),
					array('prompt'=>'-- Initiales --',
						'multiple'=>false)),
	            /*'filter'=> $this->widget('ext.EchMultiSelect.EchMultiSelect', array(
	                'model' => $model,
	                'dropDownAttribute' => 'initialeTechnicien',
	                'data' => CHtml::listData( Utilisateur::model()->findAll( array( 'order' => 'initiale' ) ), 'initiale', 'initiale' ),
	                'options' => array('buttonWidth' => 80, 'ajaxRefresh' => true),
	            	),
	            true // capture output; needed so the widget displays inside the grid
        		),*/
			),
		/*
		'datePriseEnCharge',
		'dateClotureTicket',
		'idutilisateurDemande',
		*/
		array(
			'class'=>'CButtonColumn',

		),
		array(

			'name' => 'selection',
			'value' => '0',
			'class' => 'CCheckBoxColumn',
			'selectableRows' => '100',
		),
	),
));
?>
</div>

