<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EnterpriseUsers */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Profile';
?>

<div class="enterprise-users-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<?php // echo $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'email')->textInput(['maxlength' => true, 'readonly'=>'readonly']) ?>
				<div class="row">
					<div class="col-sm-6">
						<?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
					</div>
					<div class="col-sm-6">
						<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
				<?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true]) ?>
				<?php // echo $form->field($model, 'profile_image')->textInput(['maxlength' => true]) ?>
				
				<div class="row">					
					<div class="col-sm-6">
						<?php $profile_image = dirname( dirname( Yii::getAlias('@web') ) ) . "/uploads/" . $model->profile_image;; ?>
						<?php echo Html::img($profile_image, ['class' => '', 'alt'=>"profile image", 'width'=>'100', 'height'=>'100' ]); ?>
					</div>
					<div class="col-sm-6">
						<?= $form->field($modelUpload, 'profile_image')->fileInput() ?>
					</div>
					<?php
						if(!$model->isNewRecord):
							echo Html::activeHiddenInput($model, 'profile_image');
						endif;
					?>
				</div>
			</div>
			<div class="col-sm-6">
				<?= $form->field($model, 'address_street_address_1')->textInput(['maxlength' => true]) ?>				
				<?= $form->field($model, 'address_street_address_2')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'address_street_address_3')->textInput(['maxlength' => true]) ?>
				<div class="row">
					<div class="col-sm-6">
						<?= $form->field($model, 'address_suburb')->textInput(['maxlength' => true]) ?>
					</div>
					<div class="col-sm-6">
						<?= $form->field($model, 'address_state')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?= $form->field($model, 'address_postcode')->textInput(['maxlength' => true]) ?>
					</div>
					<div class="col-sm-6">
						<?= $form->field($model, 'address_country')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>	
    <?php ActiveForm::end(); ?>
</div>
