<?php
/* @var string $icon */
/* @var string $label */
/* @var string|int $value */
?>
<div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
    <div class="mr-4 text-white p-2 rounded-md"
        style="background: var(--biblio-primary)">
        <?= $icon ?>
    </div>
    <div>
        <p class="text-sm text-gray-500"><?= $label ?></p>
        <p class="text-2xl font-semibold"><?= $value ?></p>
    </div>
</div>
