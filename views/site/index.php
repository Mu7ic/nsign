<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Phone formatter</h2>

                <p><?= \Yii::$app->phone->asPhone('992928344074'); ?></p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-8">
<?php
   $products=simplexml_load_file('xml/products.xml');
    $array = json_decode(json_encode($products), true);

    foreach ($array as $ar){
      $arr=$ar;
    }

$searchAttributes = ['id', 'categoryId', 'price','hidden'];
$searchModel = [];
$searchColumns = [];

foreach ($searchAttributes as $searchAttribute) {
    $filterName = 'filter' . $searchAttribute;
    $filterValue = Yii::$app->request->getQueryParam($filterName, '');
    $searchModel[$searchAttribute] = $filterValue;
    $searchColumns[] = [
        'attribute' => $searchAttribute,
        'filter' => '<input class="form-control" name="' . $filterName . '" value="' . $filterValue . '" type="text">',
        'value' => $searchAttribute,
    ];
    $arr = array_filter($arr, function($item) use (&$filterValue, &$searchAttribute) {
        return strlen($filterValue) > 0 ? stripos('/^' . strtolower($item[$searchAttribute]) . '/', strtolower($filterValue)) : true;
    });
}

echo GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $arr,
        'sort' => [
            'attributes' => $searchAttributes,
        ],
    ]),
    'filterModel' => $searchModel,
    'columns' => array_merge(
        $searchColumns, [
           // ['class' => 'yii\grid\ActionColumn']
        ]
    )
]);
?>
            </div>
        </div>

    </div>
</div>
