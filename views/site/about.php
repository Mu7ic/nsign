<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Выбор ингредиента';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    /* The customcheck */
    .customcheck {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .customcheck input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 5px;
    }

    /* On mouse-over, add a grey background color */
    .customcheck:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .customcheck input:checked ~ .checkmark {
        background-color: #02cf32;
        border-radius: 5px;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .customcheck input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .customcheck .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>


<div class="col-md-4">
    <h4>Выберите ингредиенты</h4>

    <form class="funkyradio" method="post">
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
        <?php
        foreach ($ing as $item) {
        ?>

            <label class="customcheck"><?= $item->ingredient ?>
                <input name="checkbox[]" type="checkbox" value="<?= $item->id ?>"  >
                <span class="checkmark"></span>
            </label>
        <?php } ?>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" name="contact-button">Искать</button></div>
    </form>
</div>

<div class="col-md-4">
    <?php
    if(isset($msg)){ echo $msg;}
    elseif(isset($dishes)){
        echo '<table class="table table-striped table-bordered">';
        echo '<thead>';
        echo '<tr><td>Наименования</td></tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($dishes as $dish){
        echo '<tr><td>'.$dish->name.'</td></tr>';
        }
    }
    echo '</tbody>';
    echo '</table>';
    ?>
</div>
