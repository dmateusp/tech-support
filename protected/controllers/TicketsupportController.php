<?php

class TicketsupportController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function actions()
    {
        return array(
            'traiter'=>'actionTraiter',
            'cloturer' => 'actionCloturer',
            'dynamicimages' => 'actionDynamicimages',
            'affecter' => 'actionAffecter', 
            'enattente' => 'actionEnAttente',
            'sortirattente' => 'actionSortirAttente',
            'grpenattente'  => 'actionGrpEnAttente',
            'grpcloturer' => 'actionGrpCloturer',
            'grpsortirattente' => 'actionGrpSortirAttente',
        );
    }

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		$allowAdmins = array();
		$admins = Utilisateur::model()->findAllByAttributes(
			array('type'=>'A')
			);
		foreach($admins as $m => $v)
		{
			array_push($allowAdmins,$v->login);
		}
		return array(
			array('deny',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('*'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','dynamicimages','create','admin','traiter','cloturer','attente','enattente','sortirattente'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','update','traiter','cloturer','affecter','grpenattente','grpcloturer','grpsortirattente','view'),
				'users'=>$allowAdmins,
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Ticketsupport;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ticketsupport']))
		{
			$model->attributes=$_POST['Ticketsupport'];
			$model->statut=0;
			$model->idutilisateurDemande=Yii::app()->user->id;
			unset($model->dateDemande);
			if($model->save()){
				//UNCOMMENT TO SEND MAIL
				//$model->sendMail();
				$this->redirect(array('index'));
			}
		}

		$model->img='Pas de selection';
		$this->render('create',array(
			'model'=>$model,
		));
	}



	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ticketsupport']))
		{
			$model->attributes=$_POST['Ticketsupport'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->idticketSupport));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionTraiter($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model->statut=1;
		$model->idtechnicien = Yii::app()->user->id;

		// Change the line below to your timezone!
		date_default_timezone_set('Europe/Paris');
		$date = date('Y-m-d H:i:s', time());
		$model->datePriseEnCharge = $date; 
		$model->save();

		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function actionGrpCloturer()
	{
		$response = '';
		foreach($_POST['idsToAppend'] as $value){
			$model=$this->loadModel(intval($value));
			if($model->statut !=3  && isset($model->datePriseEnCharge)){

				$model->statut=3;		

				// Change the line below to your timezone!
				date_default_timezone_set('Europe/Paris');
				$date = date('Y-m-d H:i:s', time());
				$model->dateClotureTicket = $date; 
				if($model->statut ==2)
					$model->finDateAttente=$date;
				//Yii::app()->user->setFlash($value."-success", "Le ticket ".$value." a été clôturé");
				$response.="\nLe ticket ".$value." a été clôturé";
				$model->save();
			}
			else{
				//Yii::app()->user->setFlash($value."-error", "Impossible de clôturer le ticket ".$value.", vérifiez qu'il ait bien été attribué à quelqu'un");
				$response.="\nImpossible de clôturer le ticket ".$value.", vérifiez qu'il ait bien été attribué à quelqu'un";
			}

		}
		echo $response;
	}

	public function actionCloturer($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model->statut=3;

		// Change the line below to your timezone!
		date_default_timezone_set('Europe/Paris');
		$date = date('Y-m-d H:i:s', time());
		$model->dateClotureTicket = $date; 
		$model->save();

		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function actionEnAttente($id)
	{
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Ticketsupport']))
		{
			$model->attributes=$_POST['Ticketsupport'];
			$model->statut=2;
			date_default_timezone_set('Europe/Paris');
			$date = date('Y-m-d H:i:s', time());
			$model->debDateAttente = $date;
			if($model->save())
				$this->redirect(array('view','id'=>$model->idticketSupport));
		}
		
		$model->save();
		$this->render('enattente',array(
			'model'=>$model,
		));
	}

	public function actionGrpEnAttente()
	{
		$response = '';
		foreach($_POST['idsToAppend'] as $value){
			$model=$this->loadModel(intval($value));
			if(($model->statut == 0 || $model->statut == 1) && !isset($model->debDateAttente)){
				$model->statut=2;		

				// Change the line below to your timezone!
				date_default_timezone_set('Europe/Paris');
				$date = date('Y-m-d H:i:s', time());
				$model->debDateAttente = $date; 
				//Yii::app()->user->setFlash($value."-success", "Le ticket ".$value." a été mis en attente");
				$model->save();
				$response.="\nLe ticket ".$value." a été mis en attente";

			}
			else{
				//Yii::app()->user->setFlash($value."-error", "Impossible de mettre le ticket ".$value." en attente (conflit de statut ou a déjà été mis en attente)");
				$response.="\nImpossible de mettre le ticket ".$value." en attente (conflit de statut ou a déjà été mis en attente)";
			}


		}
		echo $response;
		//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	public function actionGrpSortirAttente()
	{
		$response = '';
		foreach($_POST['idsToAppend'] as $value){
			$model=$this->loadModel(intval($value));
			if(($model->statut == 2) && isset($model->debDateAttente) && !isset($model->finDateAttente)){
				if($model->idtechnicien==null){
					$model->statut=0;
				}
				else{
					$model->statut=1;
				}
				// Change the line below to your timezone!
				date_default_timezone_set('Europe/Paris');
				$date = date('Y-m-d H:i:s', time());
				$model->finDateAttente = $date;
				//Yii::app()->user->setFlash($value."-success", "Le ticket ".$value." a été sorti du statut en attente");
				$model->save();
				$response.="\nLe ticket ".$value." a été sorti du statut en attente";
			}
			else{
				//Yii::app()->user->setFlash($value."-error", "Impossible de sortir le ticket ".$value." du statut en attente (le ticket n'était pas en attente)");
				$response.="\nImpossible de sortir le ticket ".$value." du statut en attente (le ticket n'était pas en attente)";
			}

		}
		echo $response;
	}
	public function actionSortirAttente($id)
	{
		
		$model=$this->loadModel($id);
		date_default_timezone_set('Europe/Paris');
		$date = date('Y-m-d H:i:s', time());
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if($model->idtechnicien==null){
			$model->statut=0;
		}
		else{
			$model->statut=1;
		}

		// Change the line below to your timezone!

		$model->finDateAttente = $date; 
		$model->save();

		$this->render('view',array(
			'model'=>$model,
		));

	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$utilisateur=Utilisateur::model()->findByPk(Yii::app()->user->getId());
		if(!isset($_POST['listFiltre']) || $_POST['listFiltre']=='mesdemandes'){
			$criteria=new CDbCriteria();
			$criteria->condition='idutilisateurDemande=:idutilisateurDemande';
			$criteria->params =array(':idutilisateurDemande'=>Yii::app()->user->getId());
        }
        else{
			$criteria=new CDbCriteria();
			$criteria->with = array('idutilisateurDemande0');
			$criteria->condition='idutilisateurDemande0.iddepartement=:iddepartement';
			$criteria->params =array(':iddepartement'=>$utilisateur->iddepartement);	
        }
		if(!isset($_POST['listTemps']) || $_POST['listTemps']=='semaine'){
			$criteria->condition.=' AND dateDemande > DATE_SUB(NOW(), INTERVAL 1 WEEK)';
        }
		if(isset($_POST['listTemps']) && $_POST['listTemps']=='mois'){
			$criteria->condition.=' AND dateDemande > DATE_SUB(NOW(), INTERVAL 1 MONTH)';
        }
		if(isset($_POST['listTemps']) && $_POST['listTemps']=='annee'){
			$criteria->condition.=' AND dateDemande > DATE_SUB(NOW(), INTERVAL 1 YEAR)';
        }
		$dataProvider=new CActiveDataProvider('Ticketsupport', array(
                'criteria' => $criteria, 
                'pagination'=>false));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'criteria'=>$criteria,
		));
        
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{

		$model=new Ticketsupport('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ticketsupport']))
			$model->attributes=$_GET['Ticketsupport'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	//function called to change image related  to Hotelitem on Forms
	public function actionDynamicimages()
	{
	    $imagesource=Ticketsupport::model()->getPathImg();
        echo CHtml::image(Yii::app()->request->baseUrl.'/images/'.$imagesource,"imagesource",array("height"=>200));
	}

	public function actionAffecter()
	{
		$response = '';
		foreach($_POST['idsToAppend'] as $value){
			$model=$this->loadModel(intval($value));
			if($model->statut == 0 || $model->statut == 1){
				$model->statut=1;		
				$model->idtechnicien = $_POST['idTechnicien'];

				// Change the line below to your timezone!
				if(is_null($model->datePriseEnCharge)){
					date_default_timezone_set('Europe/Paris');
					$date = date('Y-m-d H:i:s', time());
					$model->datePriseEnCharge = $date; 
					//Yii::app()->user->setFlash($value."-success", "Le ticket ".$value." est maintenant pris en charge");
					$response.="\nLe ticket ".$value." est maintenant pris en charge";
				}
				else{
					$response.="\nLe ticket ".$value." a été réaffecté";
					//Yii::app()->user->setFlash($value."-success", "Le ticket ".$value." a été réaffecté");
				}
				$model->save();

			}
			else{
				//Yii::app()->user->setFlash($value."-error", "Impossible d'affecter le ticket ".$value." (Pensez à vérifier que le ticket ne soit pas en attente ou déjà affecté à un technicien)");
				$response.="\nImpossible d'affecter le ticket ".$value." (Pensez à vérifier que le ticket ne soit pas en attente ou déjà affecté à un technicien)";
			}

		}
		echo $response;
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ticketsupport the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ticketsupport::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ticketsupport $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ticketsupport-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
