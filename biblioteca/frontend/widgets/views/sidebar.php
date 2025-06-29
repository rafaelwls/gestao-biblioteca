<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $menuItems array */
?>
 
<nav class="p-2" >
    <?php foreach ($menuItems as $group):
        // checa se pelo menos um item desse grupo é o atual
        $groupIsActive = false;
        foreach ($group['items'] as $item) {
            if (Yii::$app->request->getUrl() === Url::to($item['url'])) {
                $groupIsActive = true;
                break;
            }
        }
    ?>
        <details class="mb-2" <?= $groupIsActive ? 'open' : '' ?>>
            <summary class="flex items-center p-2 cursor-pointer hover:bg-gray-100 rounded">
                <span class="mr-2"><?= $group['icon'] ?></span>
                <span class="font-medium"><?= $group['title'] ?></span>
            </summary>
            <ul class="mt-1 ml-6 space-y-1">
                <?php foreach ($group['items'] as $item):
                    // compara a URL atual com a URL do link
                    $itemUrl = Url::to($item['url']);
                    $active  = Yii::$app->request->getUrl() === $itemUrl;
                ?>
                    <li>
                        <?= Html::a(
                            $item['icon'] . ' ' . $item['title'],
                            $item['url'],
                            [
                                'class' => 'flex items-center p-1 rounded ' .
                                    ($active
                                        ? 'bg-blue-100 text-blue-700 font-semibold'
                                        : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900')
                            ]
                        ) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </details>
    <?php endforeach; ?>
</nav>
