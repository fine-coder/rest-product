<?php
/* @var $this yii\web\View */

$css = <<<CSS

.btn {
    margin-right: 5px;
}

CSS;

$this->registerCss($css, ["type" => "text/css"]);

$this->registerAssetBundle(\yii\web\JqueryAsset::class);

$this->registerJs("
$('#mybtb1').on('click',function(){
var logString = $('#auth').val();
 $.ajax({
	xhrFields: {
		withCredentials: true
	},
	headers: {
		'Authorization': 'Basic ' + btoa(logString)
	},
	url: '/rest/product',
	success: function (data) {
		console.log(data);
	},
	error: function (xhr, ajaxOptions, thrownError) {
		console.log(xhr.status);
		console.log(xhr.responseText);
    },
 });
});

$('#mybtb2').on('click',function(){
    var logString = $('#auth').val();
    var xhr = new XMLHttpRequest();
	xhr.open('GET', '/rest/product', true);
	xhr.withCredentials = true;
	xhr.setRequestHeader('Authorization', 'Basic ' + btoa(logString));
	xhr.onload = function () {
	    console.log(xhr.responseText);
	};
	xhr.send();
});

$('#mybtb3').on('click',function(){
    var logString = $('#auth').val();
	var myHeaders = new Headers();
	myHeaders.append('Authorization', 'Basic ' + btoa(logString));
	fetch('/rest/product', {
	    credentials: 'include',
	    headers: myHeaders
	}).then(function (response) {
	    return response.json();
	}).then(function (json) {
	    console.log(json);
	});
});
");

//echo '<input type="text" id="auth" value="admin:superpassword"><br><br>';

echo \yii\bootstrap\Html::textInput('', 'admin:superpassword', ['id'=>'auth']);
echo '<br><br>';
echo \yii\bootstrap\Html::button('Jquery и headers',['id'=>'mybtb1','class'=>'btn btn-info']);
echo \yii\bootstrap\Html::button('чистый js и XMLHttpRequest',['id'=>'mybtb2','class'=>'btn btn-info']);
echo \yii\bootstrap\Html::button('чистый js и Fetch API',['id'=>'mybtb3','class'=>'btn btn-info']);

echo '<br><br>Результат смотреть в консоле';
