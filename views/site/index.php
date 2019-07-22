<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;


function translit($str)
{
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
}

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
        <div class="row">
            <div class="col-lg-4">
                <?php
                echo GridView::widget([
                    'dataProvider' => new ArrayDataProvider([
                        'allModels' => $array,
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
            <div class="col-lg-3">
                <h6>Вам нужно обрезать строку, по определенному количеству слов. Что бы из 30 слов, выводилось 12. Приложите ссылку на код.</h6>
                <p><?php
                    $str="cursus turpis massa tincidunt dui ut ornare lectus sit amet est placerat in egestas erat imperdiet sed euismod nisi porta lorem mollis aliquam ut porttitor leo a diam sollicitudin tempor id eu nisl nunc mi ipsum faucibus vitae aliquet nec ullamcorper sit amet risus nullam eget felis eget nunc lobortis";
                    $exp=explode(' ',$str);
                    //var_dump($exp);
                    for ($i=1;$i<=30;$i++){
                        if($i<=12)
                            echo $exp[$i].'<br>';
                    }
                    ?>
                </p>
            </div>
            <div class="col-lg-3">
                <h6>Вам нужно преобразовать строку из created_at в CreatedAt. Приложите ссылку на код.</h6>
                <p><?php
                    $str="created_at";
                    $exp=explode('_',$str);
                    echo mb_convert_case($exp[0], MB_CASE_TITLE, "UTF-8").mb_convert_case($exp[1], MB_CASE_TITLE, "UTF-8");
                ?>
                </p>
            </div>
            <div class="col-lg-3">
                <h6>Вам нужно строку "Купи слона" преобразовать в "Kupi slona". Приложите ссылку на код.</h6>
                <p><?php
                    echo translit("Купи слона");
                ?>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <?php
//                CKEditor::widget([
//                    'editorOptions' => [
//                        'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
//                        'inline' => false, //по умолчанию false
//                    ]
//                ]);
                ?>
            </div>
        </div>
    </div>
</div>
