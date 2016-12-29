<?php

class HotelitemController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public function actions()
    {
        return array(
            'dynamicitems' => 'actionDynamicitems',
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
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('dynamicitems'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update','index','view','admin','delete'),
				'users'=>$allowAdmins,
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionDynamicitems()
	{
	    $data=Hotelitem::model()->findAllByAttributes(
	    				array(
	    					'idcategorie'=>$_POST['categorieId'],
	    					)
	    				);

	    $data=CHtml::listData($data,'idhotelitem','name');
	    foreach($data as $value=>$name)
	    {
	        echo CHtml::tag('option',
	            array('value'=>$value),CHtml::encode($name),true);
	    }
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
		$model=new Hotelitem;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Hotelitem']))
		{
			try{
				$model->attributes=$_POST['Hotelitem'];
				$model->idcreator=Yii::app()->user->getId(); 
				$uploadedFile=CUploadedFile::getInstance($model,'imagesource');
	            $fileName = uniqid()."-img.jpg";  // random number + file name
				$model->imagesource = $fileName;
				if($model->save())
				{
					if($uploadedFile!=null){

						$uploadedFile->saveAs(Yii::app()->basePath.'/../images/'.$fileName);  // image will uplode to rootDirectory/banner/
					}

				}
				$this->redirect(array('view','id'=>$model->idhotelitem));		
			}
			catch(CDbException $e){
				throw new Exception("Un objet du même nom (".$model->name.") existe déjà dans la base de données, choisissez un nom différent", $e->getCode());
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
		$prevImageSource=$model->imagesource;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Hotelitem']))
		{
			$model->attributes=$_POST['Hotelitem'];
		   	$uploadedFile=CUploadedFile::getInstance($model,'imagesource');
		   	if($prevImageSource!=''){
		   		$model->imagesource=$prevImageSource;
		   	}
		   	else{
	        	$fileName=uniqid()."-img.jpg";  // random number + file name
	        	$model->imagesource=$fileName;
		   	}

			if($model->save())
			{

				if($uploadedFile!=null)  // check if uploaded file is set or not
                {	
                    $uploadedFile->saveAs(Yii::app()->basePath.'/../images/'.$model->imagesource);
                }

				$this->redirect(array('view','id'=>$model->idhotelitem));
			}
		}

		$this->render('update',array(
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
		if(file_exists(Yii::app()->basePath.'/../images/'.$this->loadModel($id)->imagesource))
			unlink(Yii::app()->basePath.'/../images/'.$this->loadModel($id)->imagesource);	
		try{
			$this->loadModel($id)->delete();	
		}
		catch(CDbException $e){
			throw new Exception("Impossible de supprimer cet objet car des demandes sont liées à ce dernier. Si vous souhaitez vraiment supprimer cet objet il faut d'abord supprimer les demandes qui lui sont rattachés.", $e->getCode());
		}


		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Hotelitem');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Hotelitem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Hotelitem']))
			$model->attributes=$_GET['Hotelitem'];

		
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Hotelitem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Hotelitem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Hotelitem $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='hotelitem-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
