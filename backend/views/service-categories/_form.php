<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceCategories */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>
	<div class="box box-info">
        <div class="box-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="box-body">
		    <div class="row">
			<div class="col-sm-6">
				<?= $form->field($model, 'service_category_name')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-sm-6">
				<?= $form->field($model, 'service_category_description')->textarea(['rows' =>2]) ?>
			</div>
		</div>
		</div>
		<div class="box-footer">
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
		</div>
		</div>
	</div>
<?php ActiveForm::end(); ?>