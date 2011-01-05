<?php
$this->breadcrumbs=array(
	'Shops'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Shops', 'url'=>array('index')),
	array('label'=>'Create Shop', 'url'=>array('create')),
	array('label'=>'Update Shop', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Shop', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Shop', 'url'=>array('admin')),
        array('label'=>'Add Product ', 'url'=>array('product/create','sid'=>$model->id)),
);
?>

<h1> Shop | <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'descripton',
		'create_time',
		'image',
		array(
			'label'=>'shop_category_id',
			'value'=>CHtml::encode($model->shopCategory->name),
			),	
	
	),
)); ?>
<br/>
<h3>Products</h3>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$productDataProvider,
	'itemView'=>'/product/_view',
)); ?>


