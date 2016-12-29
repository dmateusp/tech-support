<?php

class TravailinterneController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function actions()
    {
        return array(
            'calendarevents'=>'actionCalendarEvents',
            'calendar' => 'actionCalendar',
            'download' => 'actionDownload',
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
		$allowCoordinateurs = array();
		$admins = Utilisateur::model()->findAllByAttributes(
			array('type'=>'A')
			);
		foreach($admins as $m => $v)
		{
			array_push($allowAdmins,$v->login);
		}

		$coordinateurs = Utilisateur::model()->findAllByAttributes(
			array('type'=>'C')
			);
		foreach($coordinateurs as $m => $v)
		{
			array_push($allowCoordinateurs,$v->login);
		}
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('calendarevents','calendar','view','download'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				 'actions'=>array('admin','delete','create','index','update'),
				'users'=>$allowAdmins,
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				 'actions'=>array('update','delete','create','index'),
				'users'=>$allowCoordinateurs,
			),

			array('deny',  // deny all users
				'actions'=>array(),
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
	public function actionCalendarEvents()
	{

		function random_color_part() {
	    	return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
		}

		function random_color() {
		    return '#'.random_color_part() . random_color_part() . random_color_part();
		}

        $items = array();
        if($_GET['week']=='-1')
        	$model=Travailinterne::model()->findAll();
        else{
        	$start = explode("-", $_GET['start']);
        	$end = explode("-", $_GET['end']);
        	$dates = explode("-", $_GET['week']);
        	$attribs = array();
        	$monthEnd=$start[1];
        	if($dates[0]>$dates[1])
        		$monthEnd=$end[1];
			$criteria = new CDbCriteria();
			$criteria->addBetweenCondition('dateDebut', $start[0].'-'.$start[1].'-'.$dates[0], $start[0].'-'.$monthEnd.'-'.$dates[1] ,'OR');
			$criteria->addBetweenCondition('dateFin', $start[0].'-'.$start[1].'-'.$dates[0], $start[0].'-'.$monthEnd.'-'.$dates[1] ,'OR');
			$model = Travailinterne::model()->findAllByAttributes($attribs, $criteria);
        }    
        foreach ($model as $value) {
            //$color = random_color();
            $color='#'.substr(hash('md2',$value->idsalle0->name,false),0,6);
            $informations= 'Salle : '.$value->idsalle0->name; 
            if(isset($value->idligne0->name)){
            	$informations .="\xA".'Ligne : '.$value->idligne0->name;
            }
            $informations.="\xA".'Description : '.$value->description;
            $items[]=array(
                'title'=>$informations,
                'start'=>$value->dateDebut,
                'end'=>$value->dateFin,
                'id'=> $value->id,
                'color'=>$color,
                //'allDay'=>true,
                //'url'=>'http://anyurl.com'
            );
        }
        echo CJSON::encode($items);
        Yii::app()->end();
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Travailinterne;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Travailinterne']))
		{
			$model->attributes=$_POST['Travailinterne'];
			$uploadedFile=CUploadedFile::getInstance($model,'docsource');
			if(!is_null($uploadedFile)){
            	$fileName = uniqid().".".$uploadedFile->getExtensionName();  // random number + file name
				$model->docsource = $fileName;				
			}
			if($model->save())
			{
				if($uploadedFile!=null){

					$uploadedFile->saveAs(Yii::app()->basePath.'/../docs/'.$fileName);  // image will uplode to rootDirectory/banner/
				}
				$this->redirect(array('view','id'=>$model->id));

			}

		}

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
		$prevImageSource=$model->docsource;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model->idutilisateurModif=Yii::app()->user->id;
		// Change the line below to your timezone!
		date_default_timezone_set('Europe/Paris');
		$date = date('Y-m-d H:i:s', time());
		$model->dateModif = $date; 
		if(isset($_POST['Travailinterne']))
		{
			$model->attributes=$_POST['Travailinterne'];
		   	$uploadedFile=CUploadedFile::getInstance($model,'docsource');
		   	if(!is_null($uploadedFile)){
			   	if($prevImageSource!=''){
			   		$model->docsource=$prevImageSource;
			   	}
			   	else{
		        	$fileName= uniqid().".".$uploadedFile->getExtensionName();  // random number + file name
		        	$model->docsource=$fileName;
			   	}
			}

			if($model->save())
			{

				if($uploadedFile!=null)  // check if uploaded file is set or not
                {	
                    $uploadedFile->saveAs(Yii::app()->basePath.'/../docs/'.$model->docsource);
                }

				$this->redirect(array('view','id'=>$model->id));
			}
		}
		
		$this->render('update',array(
			'model'=>$model,
		));
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

		$dataProvider=new CActiveDataProvider('Travailinterne', array(
                'criteria' => $criteria, 
                'pagination'=>false));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'criteria'=>$criteria,
		));
        
	}
	public function actionCalendar()
	{

		$dataProvider=new CActiveDataProvider('Travailinterne');
		$this->render('calendar',array(
			'dataProvider'=>$dataProvider,
		));
        
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$docsource = $this->loadModel($id)->docsource;
		if(file_exists(Yii::app()->basePath.'/../docs/'.$docsource) && $docsource!=''){
			try{
				unlink(Yii::app()->basePath.'/../docs/'.$docsource);	
			}
			catch(Exception $e){

			}
		}
		try{
			$this->loadModel($id)->sendMail();
			$this->loadModel($id)->delete();	
		}
		catch(CDbException $e){
			throw new Exception("Impossible de supprimer cette demande.", $e->getCode());
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

		TravailInterneController::actionIndex();
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Travailinterne('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Travailinterne']))
			$model->attributes=$_GET['Travailinterne'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function actionDownload(){
		$model=$this->loadModel($_GET['id']);
		if( file_exists( './docs/'.$model->docsource) ){
			return Yii::app()->getRequest()->sendFile($model->docsource, @file_get_contents('./docs/'.$model->docsource));
			/*$this->render('view',array(
			'model'=>$model,
			));*/
		}
		else{
			$this->render('view',array(
			'model'=>$model,
			));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Travailinterne the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Travailinterne::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Travailinterne $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='travailinterne-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
