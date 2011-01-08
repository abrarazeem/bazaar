<?php

class ShopController extends Controller
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

		);
	}
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
	
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','signup','captcha'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('shopAdmin','delete'),
				'roles'=>array('owner'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('update','admin'),
				'roles'=>array('owner'),
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
            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria'=>array(
                    'condition'=>'shop_id=:shopId',
                    'params'=>array(':shopId'=>$id),
                ),
                'pagination'=>array(
                    'pageSize'=>1
                ),
            ));
		$this->render('view',array(
			'model'=>$this->loadModel($id),
                        'productDataProvider'=>$productDataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSignup()
	{
		$auth = Yii::app()->authManager;
		$shop=new Shop;
		$user = new User;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Shop'],$_POST['User']))
		{
			$this->performAjaxValidation($shop);
	

			$user->attributes=$_POST['User'];
			$shop->attributes=$_POST['Shop'];
			$valid= $shop->validate();
			$valid = $user->validate() && $valid;
			$shop->image=CUploadedFile::getInstance($shop, 'image');
             if($valid)
             {          
			if($user->save())
       		{ $shop->user_id = $user->id;
   		 		$auth->assign('owner',$user->id);
   		 	}
             if($shop->save())
                { $shop->image->saveAs(Yii::app()->basePath . '/../images/'.$shop->image);
            	 }
						$this->redirect(array('view','id'=>$shop->id));
            }
		}

		$this->render('signup',array(
			'shop'=>$shop,
			'user'=>$user,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$shop=$this->loadModel($id);
		$user = User::model()->findByPk($shop->user_id);
		if(Yii::app()->user->checkAccess('updateOwnShop',array('shop'=>$shop)))
	{	
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Shop']))
		{		$model->attributes=$_POST['Shop'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));	
		}
		
		$this->render('update',array(
			'shop'=>$shop,
			'user'=>$user,
		));
	}
	else
		throw new CHttpException(403,'You can only Update Your own  shop.');
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
           
            		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	

        }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Shop');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Shop('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Shop']))
			$model->attributes=$_GET['Shop'];
		$
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Shop::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shop-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
		public function actionShopAdmin()
	{
                $user_id = Yii::app()->user->id;
                $model= new CActiveDataProvider('Product', array(
                'criteria'=>array(
                    'condition'=>'user_id=:userId',
                    'params'=>array(':userId'=>$user_id),
                )));
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Shop']))
			$model->attributes=$_GET['Shop'];
		$
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	     
        
}
