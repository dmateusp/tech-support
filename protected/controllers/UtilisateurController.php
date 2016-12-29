<?php

class UtilisateurController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update','admin','delete','index'),
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

		$model=new Utilisateur;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Utilisateur']))
		{
			try{
				$model->attributes=$_POST['Utilisateur'];
				$model->type=$_POST['Utilisateur']['type'];
				$model->iddepartement=$_POST['Utilisateur']['iddepartement'];
				if($model->save())
				{
					$this->redirect(array('view','id'=>$model->idutilisateur));
					$model->password=sha1($model->password);
				}
			}
			catch(CDbException $e){
				throw new Exception("Un utilisateur du même nom existe déjà dans la base de données", $e->getCode());
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
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Utilisateur']))
		{
			$model->attributes=$_POST['Utilisateur'];
			$model->type=$_POST['Utilisateur']['type'];
			
			if($model->save()){
				$this->redirect(array('view','id'=>$model->idutilisateur));	
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
		try{
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		catch(CDbException $e){
			throw new Exception("Des demandes support sont liées à ce compte, il ne peut donc pas être supprimé tant que ces demandes ne sont pas supprimées", $e->getCode());
		}

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Utilisateur');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Utilisateur('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Utilisateur']))
			$model->attributes=$_GET['Utilisateur'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Utilisateur the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Utilisateur::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Utilisateur $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='utilisateur-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
