<?php
$this->breadcrumbs=array(
	'Shops',
);

$this->menu=array(
	array('label'=>'Create Shop', 'url'=>array('signup'),'visible'=>Yii::app()->user->isGuest),
	array('label'=>'Manage Shop', 'url'=>array('admin'),'visible'=>!Yii::app()->user->isGuest),
);
?>

<h1>Shops</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
