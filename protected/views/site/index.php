<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>Congratulations! You have successfully created your Yii application.</p>
<?php

  if(isset (Yii::app()->user->shop))
  {
          echo Yii::app()->user->shop;
          echo CHtml::link('Create SHOP','?r=shop/create');
  }

?>