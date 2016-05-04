<?php

	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use Faker\Provider\DateTime;
	use app\module\admin\models\Images;
	use yii\helpers\Url;

	/* @var $this yii\web\View */
	/* @var $model app\module\admin\models\Post */
	/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

	</br></br>
	<div class="row">
		<div class="col-md-2 thumbnail" align="center">
			<table class="table table-bordered" style="border: 3px solid grey; border-collapse: collapse; width: 80px;"
				   width="80px" height="50px">
				<tr style="border: 3px solid grey; border-collapse: collapse;">
					<td style="border: 3px solid grey;" align="center"><span class="glyphicon glyphicon-picture"></span>
					</td>
					<td style="border: 3px solid grey;" align="center"><span class="glyphicon glyphicon-picture"></span>
					</td>
					<td style="border: 3px solid grey;" align="center"><span class="glyphicon glyphicon-picture"></span>
					</td>
				</tr>
				<tr style="border: 3px solid grey; border-collapse: collapse;">
					<td align="center" colspan="3"><span class="glyphicon glyphicon-align-justify"></span></td>
				</tr>
			</table>
			<div align="center" style="width: 100%;">
				<input type="radio" id="radio1"
					   onclick="getContent();show('table_1');hide('table_2');hide('table_3');document.getElementById('category_id').value='1';
					   document.getElementById('radio2').checked=false;document.getElementById('radio3').checked=false;">
			</div>
		</div>

		<div class="col-md-2 thumbnail" align="center">
			<table class="table table-bordered" style="border: 3px solid grey; border-collapse: collapse; width: 100px;"
				   width="100px" height="50px">
				<tr style="border: 3px solid grey; border-collapse: collapse;">
					<td style="border: 3px solid grey;" align="center"><span class="glyphicon glyphicon-picture"></span>
					</td>
				</tr>
				<tr style="border: 3px solid grey; border-collapse: collapse;">
					<td align="center"><span class="glyphicon glyphicon-align-justify"></span></td>
				</tr>
			</table>
			<div align="center" style="width: 100%;">
				<input type="radio" id="radio2"
					   onclick="getContent();show('table_2');hide('table_1');hide('table_3');document.getElementById('category_id').value='2';
					   document.getElementById('radio1').checked=false;document.getElementById('radio3').checked=false;">
			</div>
		</div>

		<div class="col-md-2 thumbnail" align="center">
			<table class="table table-bordered" style="border: 3px solid grey; border-collapse: collapse; width: 100px;"
				   width="100px" height="81px">
				<tr style="border: 3px solid grey; border-collapse: collapse;">
					<td style="border: 3px solid grey;" align="center"><span class="glyphicon glyphicon-picture"></span>
					</td>
					<td align="center"><span class="glyphicon glyphicon-align-justify"></span></td>
				</tr>
			</table>
			<div align="center" style="width: 100%;">
				<input type="radio" id="radio3"
					   onclick="getContent();show('table_3');hide('table_1');hide('table_2');document.getElementById('category_id').value='3';
					   document.getElementById('radio2').checked=false;document.getElementById('radio1').checked=false;">
			</div>
		</div>
	</div>
	</br></br></br>


	<div style="width: 100%;" align="center">
	<div id="table_1" style="display: <?php echo $model->category_id == 1 ? 'block' : 'none'; ?>;">
		<table class="table table-bordered"
			   style="border: 20px solid #ccc; padding: 3%; border-collapse: collapse; width: 95%;">
			<tr style="border: 1px #ccc;">
				<td style="border: 1px #ccc;" align="center">
					<div id="td-1-1-show" style="padding: 5%;"
						 onclick="show('img_btn');document.getElementById('temp').value='td-1-1-show';show('td-1-1-read');hide('td-1-1-show');setFocus('text-1-1');document.getElementById('text-1-1').value=this.innerHTML;"></div>
					<div id="td-1-1-read" style="display: none;">
                        <textarea style="width: 100%;" rows="5" id="text-1-1"
								  onblur="setToContent('text-1-1');hide('td-1-1-read');show('td-1-1-show');document.getElementById('td-1-1-show').innerHTML=this.value;hide('img_btn');"></textarea>
					</div>
				</td>

				<td style="border: 1px #ccc;" align="center">
					<div id="td-1-2-show" style="padding: 5%;"
						 onclick="show('img_btn');document.getElementById('temp').value='td-1-2-show';show('td-1-2-read');hide('td-1-2-show');setFocus('text-1-2');document.getElementById('text-1-2').value=this.innerHTML;"></div>
					<div id="td-1-2-read" style="display: none;">
                        <textarea style="width: 100%;" rows="5" id="text-1-2"
								  onblur="setToContent('text-1-2');hide('td-1-2-read');show('td-1-2-show');document.getElementById('td-1-2-show').innerHTML=this.value;hide('img_btn');"></textarea>
					</div>
				</td>

				<td style="border: 1px #ccc;" align="center">
					<div id="td-1-3-show" style="padding: 5%;"
						 onclick="show('img_btn');document.getElementById('temp').value='td-1-3-show';show('td-1-3-read');hide('td-1-3-show');setFocus('text-1-3');document.getElementById('text-1-3').value=this.innerHTML;"></div>
					<div id="td-1-3-read" style="display: none;">
                        <textarea style="width: 100%;" rows="5" id="text-1-3"
								  onblur="setToContent('text-1-3');hide('td-1-3-read');show('td-1-3-show');document.getElementById('td-1-3-show').innerHTML=this.value;hide('img_btn');"></textarea>
					</div>
				</td>
			</tr>
			<tr style="border: 1px #ccc;">
				<td align="center" colspan="3">
					<div id="td-1-4-show" style="padding: 5%;"
						 onclick="show('img_btn');document.getElementById('temp').value='td-1-4-show';show('td-1-4-read');hide('td-1-4-show');setFocus('text-1-4');document.getElementById('text-1-4').value=this.innerHTML;"></div>
					<div id="td-1-4-read" style="display: none;">
                        <textarea style="width: 100%;" rows="5" id="text-1-4"
								  onblur="setToContent('text-1-4');hide('td-1-4-read');show('td-1-4-show');document.getElementById('td-1-4-show').innerHTML=this.value;hide('img_btn');"></textarea>
					</div>
				</td>
			</tr>
		</table>
	</div>


	<div id="table_2" style="display: <?php echo $model->category_id == 2 ? 'block' : 'none'; ?>;">
		<table class="table table-bordered"
			   style="border: 20px solid #ccc; padding: 3%; border-collapse: collapse; width: 95%;">
			<tr style="border: 1px #ccc;">
				<td style="border: 1px #ccc;" align="center">
					<div id="td-2-1-show" style="padding: 5%;"
						 onclick="show('img_btn');document.getElementById('temp').value='td-2-1-show';show('td-2-1-read');hide('td-2-1-show');setFocus('text-2-1');document.getElementById('text-2-1').value=this.innerHTML;">Нажмите для редактирования
					</div>
					<div id="td-2-1-read" style="display: none;">
                        <textarea style="width: 100%;" rows="5" id="text-2-1"
								  onblur="setToContent('text-2-1');hide('td-2-1-read');show('td-2-1-show');document.getElementById('td-2-1-show').innerHTML=this.value;hide('img_btn');"></textarea>
					</div>
				</td>
			</tr>
			<tr style="border: 1px #ccc;">
				<td align="center">
					<div id="td-2-2-show" style="padding: 5%;"
						 onclick="show('img_btn');document.getElementById('temp').value='td-2-2-show';show('td-2-2-read');hide('td-2-2-show');setFocus('text-2-2');document.getElementById('text-2-2').value=this.innerHTML;">Нажмите для редактирования
					</div>
					<div id="td-2-2-read" style="display: none;">
                        <textarea style="width: 100%;" rows="5" id="text-2-2"
								  onblur="setToContent('text-2-2');hide('td-2-2-read');show('td-2-2-show');document.getElementById('td-2-2-show').innerHTML=this.value;hide('img_btn');"></textarea>
					</div>
				</td>
			</tr>
		</table>
	</div>


		<div id="table_3" style="display: <?php echo $model->category_id == 3 ? 'block' : 'none'; ?>;">
			<table class="table table-bordered"
				   style="border: 20px solid #ccc; padding: 3%; border-collapse: collapse; width: 95%;">
				<tr style="border: 1px #ccc;">
					<td style="border: 1px #ccc;" align="center" width="50%">
						<div id="td-3-1-show" style="padding: 5%;"
							 onclick="show('img_btn');document.getElementById('temp').value='td-3-1-show';show('td-3-1-read');hide('td-3-1-show');setFocus('text-3-1');document.getElementById('text-3-1').value=this.innerHTML;">Нажмите для редактирования
						</div>
						<div id="td-3-1-read" style="display: none;">
                        <textarea style="width: 100%;" rows="5" id="text-3-1"
								  onblur="setToContent('text-3-1');hide('td-3-1-read');show('td-3-1-show');document.getElementById('td-3-1-show').innerHTML=this.value;hide('img_btn');"></textarea>
						</div>
					</td>
					<td align="center" width="50%">
						<div id="td-3-2-show" style="padding: 5%;"
							 onclick="show('img_btn');document.getElementById('temp').value='td-3-2-show';show('td-3-2-read');hide('td-3-2-show');setFocus('text-3-2');document.getElementById('text-3-2').value=this.innerHTML;">Нажмите для редактирования
						</div>
						<div id="td-3-2-read" style="display: none;">
                        <textarea style="width: 100%;" rows="5" id="text-3-2"
								  onblur="setToContent('text-3-2');hide('td-3-2-read');show('td-3-2-show');document.getElementById('td-3-2-show').innerHTML=this.value;hide('img_btn');"></textarea>
						</div>
					</td>
				</tr>
			</table>
		</div>

		<div class="thumbnail" onclick="this.style.display='none';" style="width: 90%; background-color: #9d9d9d; padding: 4%; z-index: 800000; height: 500px; position: absolute; display: none;" id="images">

			<label>База изображений (Выберите изображение для добавления в контент)</label>
			<div class="row" style="width: 96%; height: 400px; overflow-y: scroll;">
				<?php foreach (Images::find()->orderBy(['id' => SORT_DESC])->all() as $image): ?>
					<div class="col-md-3" style="padding: 2px;">
						<img
							onclick="setTo();document.getElementById(document.getElementById('temp').value).innerHTML+='<img src=\'<?php
								echo Url::base() . '/images/' . str_replace(' ', '', $image->img_file); ?>\' width=\'99%\'>';
								document.getElementById(document.getElementById('temp').value).click();document.getElementById('images').style.display='none';"
							src="<?php echo Url::base() . '/images/' . $image->img_file; ?>" height="200px">
					</div>
				<?php endforeach; ?>
			</div>

		</div>


<div align="center" id="img_btn" style="width: 100%; display: none;">
	<button type="button" class="btn btn-primary" onclick="document.getElementById('images').style.display='block';">Add Image</button>
</div>
	</div>


	<?= $form->field($model, 'content1')->textarea(['rows' => 6, 'id' => 'content1'])->label(false) ?>
	<?= $form->field($model, 'content2')->textarea(['rows' => 6, 'id' => 'content2'])->label(false) ?>
	<?= $form->field($model, 'content3')->textarea(['rows' => 6, 'id' => 'content3'])->label(false) ?>
	<?= $form->field($model, 'content4')->textarea(['rows' => 6, 'id' => 'content4'])->label(false) ?>

	<?= $form->field($model, 'category_id')->textInput(['id' => 'category_id'])->label(false) ?>
	

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<input type="hidden" id="temp" value="temp">
	<?php ActiveForm::end(); ?>

</div>


<script>

	// Condition for radio button
	if (document.getElementById('category_id').value != ''){
		document.getElementById('radio'+document.getElementById('category_id').value).checked=true;
		document.getElementById('radio'+document.getElementById('category_id').value).click();
	}

	function setTo(){
		if(document.getElementById(document.getElementById('temp').value).innerHTML=='Нажмите для редактирования'){
			document.getElementById(document.getElementById('temp').value).innerHTML='';
		}
	}

	function getContent(){
		text='Нажмите для редактирования';
	if (document.getElementById('content1').value !== '') {
		document.getElementById('td-1-1-show').innerHTML = document.getElementById('content1').value;
		document.getElementById('td-2-1-show').innerHTML = document.getElementById('content1').value;
		document.getElementById('td-3-1-show').innerHTML = document.getElementById('content1').value;
	}else {
		document.getElementById('td-1-1-show').innerHTML = text;
		document.getElementById('td-2-1-show').innerHTML = text;
		document.getElementById('td-3-1-show').innerHTML = text;
	}
		if (document.getElementById('content2').value !== '') {
		document.getElementById('td-1-4-show').innerHTML = document.getElementById('content2').value;
		document.getElementById('td-2-2-show').innerHTML=document.getElementById('content2').value;
		document.getElementById('td-3-2-show').innerHTML=document.getElementById('content2').value;
	}else {
		document.getElementById('td-1-4-show').innerHTML = text;
		document.getElementById('td-2-2-show').innerHTML = text;
		document.getElementById('td-3-2-show').innerHTML = text;
	}
		if (document.getElementById('content3').value !== '') {
			document.getElementById('td-1-3-show').innerHTML = document.getElementById('content3').value;
		}
		else {
			document.getElementById('td-1-3-show').innerHTML = text;
		}
		if (document.getElementById('content4').value !== '') {
			document.getElementById('td-1-2-show').innerHTML = document.getElementById('content4').value;
		}
		else {
			document.getElementById('td-1-2-show').innerHTML = text;
		}
	}

	function show(id) {
		document.getElementById(id).style.display = 'block';

	}
	function hide(id) {
		if (document.getElementById(id).innerHTML == 'Нажмите для редактирования') {
			document.getElementById(id).innerHTML = '';
		}
		if (id == 'img_btn') {
			setTimeout(function(){document.getElementById(id).style.display = 'none';}, 3000);
		}else {
			document.getElementById(id).style.display = 'none';
		}
	}
	function setFocus(id) {
		document.getElementById(id).focus();
	}

	function setToContent(id) {
		if (document.getElementById(id).value == '') {
			document.getElementById(id).value = 'Нажмите для редактирования';
		}

		if (id == 'text-2-1') {
			document.getElementById('content1').value = document.getElementById(id).value;
		}
		if (id == 'text-2-2') {
			document.getElementById('content2').value = document.getElementById(id).value;
		}
		if (id == 'text-1-1') {
			document.getElementById('content1').value = document.getElementById(id).value;
		}
		if (id == 'text-1-4') {
			document.getElementById('content2').value = document.getElementById(id).value;
		}
		if (id == 'text-1-3') {
			document.getElementById('content3').value = document.getElementById(id).value;
		}
		if (id == 'text-1-2') {
			document.getElementById('content4').value = document.getElementById(id).value;
		}
		if (id == 'text-3-1') {
			document.getElementById('content1').value = document.getElementById(id).value;
		}
		if (id == 'text-3-2') {
			document.getElementById('content2').value = document.getElementById(id).value;
		}
	}

	hide('content1');
	hide('content2');
	hide('content3');
	hide('content4');
	hide('category_id');

	getContent();

</script>