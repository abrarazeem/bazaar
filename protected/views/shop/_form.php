<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shop-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data',),
	
        
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($user,$shop)); ?>
	
		<div class="row">
		<?php echo $form->labelEx($user,'name'); ?>
		<?php echo $form->textField($user,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($user,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($user,'username'); ?>
		<?php echo $form->textField($user,'username',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($user,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($user,'password'); ?>
		<?php echo $form->passwordField($user,'password',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($user,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($user,'email'); ?>
		<?php echo $form->textField($user,'email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($user,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($user,'phoneno'); ?>
		<?php echo $form->textField($user,'phoneno',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($user,'phoneno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($user,'mobileno'); ?>
		<?php echo $form->textField($user,'mobileno',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($user,'mobileno'); ?>
	</div>
	
	
	<div class="row">
		<?php echo $form->labelEx($shop,'name'); ?>
		<?php echo $form->textField($shop,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($shop,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($shop,'descripton'); ?>
		<?php echo $form->textArea($shop,'descripton',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($shop,'descripton'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->labelEx($shop,'image'); ?>
		<?php echo $form->fileField($shop,'image'); ?>
		<?php echo $form->error($shop,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($shop,'shop_category_id'); ?>
		<?php echo $form->dropDownList($shop,'shop_category_id',Shop::model()->getCategory()); ?>
		<?php echo $form->error($shop,'shop_category_id'); ?>
	</div>

		<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php echo $form->labelEx($shop,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($shop,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
	</div>
	<?php endif; ?>
	

	<div class="row buttons">
		<?php echo CHtml::submitButton('SignUp'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->