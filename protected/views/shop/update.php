<?php
$this->breadcrumbs=array(
	'Shops'=>array('index'),
	$shop->name=>array('view','id'=>$shop->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Shop', 'url'=>array('index')),
	array('label'=>'Create Shop', 'url'=>array('create')),
	array('label'=>'View Shop', 'url'=>array('view', 'id'=>$shop->id)),
	array('label'=>'Manage Shop', 'url'=>array('admin')),
);
?>

<h1>Update Shop <?php echo $shop->name; ?></h1>

<?php echo $this->renderPartial('_form', array('shop'=>$shop,'user'=>$user)); ?>