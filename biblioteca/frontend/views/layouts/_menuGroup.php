<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var string $icon */
/* @var string $title */
/* @var array  $items [['label'=>, 'url'=>], …] */
?>

<details class="group" <?= in_array(
                            Yii::$app->controller->id,
                            array_map(fn($i) => trim($i['url'][0], '/'), $items)
                        ) ? 'open' : '' ?>>
    <summary class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
        <span class="mr-2 text-primary"><?= $icon ?></span>
        <span class="font-medium"><?= Html::encode($title) ?></span>
    </summary>
    <ul class="ml-8 my-2 space-y-1">
        <?php foreach ($items as $item): ?>
            <?php
            $active = Url::to($item['url']) === Url::to(Yii::$app->request->url);
            ?>
            <li>
                <?= Html::a(
                    Html::encode($item['label']),
                    $item['url'],
                    ['class' => $active
                        ? 'block px-2 py-1 rounded text-primary font-medium'
                        : 'block px-2 py-1 rounded hover:bg-gray-100']
                ) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</details>
