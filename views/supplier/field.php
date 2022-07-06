<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */



$this->title = 'Please select the field you want';

$this->registerJs('
    $(".exportdata").on("click", function () {
        var filedCheckedTemp = "";
        $("input:checkbox[name=filed]:checked").each(function (i) {
            if (0 == i) {
                filedCheckedTemp = $(this).val();
            } else {
                filedCheckedTemp += ("," + $(this).val());
            }
        });
     
        var idsString = "";
        idsString = $("#ids").val();
        $(this).attr("href","export?ids="+idsString+"&fileds="+filedCheckedTemp);
    });
');

?>
<div class="supplier-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <br/>
    <span><input name='filed' type="checkbox" value="id" checked disabled><label>&nbsp;&nbsp;ID</label></span><br/>
    <span><input name='filed' type="checkbox" value="name"><label>&nbsp;&nbsp;Name</label></span><br/>
    <span><input name='filed' type="checkbox" value="code"><label>&nbsp;&nbsp;Code</label></span><br/>
    <span><input name='filed' type="checkbox" value="t_status"><label>&nbsp;&nbsp;T_Status</label></span><br/>
    <span style="display:none"><input  id ="ids" name='ids' type="text" value="<?php echo $ids;?>"><label></label></span><br/>
    <br/>
    <a class="btn btn-success exportdata" href="/supplier/export" >Export Selectd Fileds</a>



</div>
