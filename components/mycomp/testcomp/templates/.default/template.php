<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>Заголовок</th>
        <th>Дата добавления</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($arResult as $item){?>
    <tr>
        <td><?=$item['ID']?></td>
        <td><?=$item['TITLE']?></td>
        <td><?=$item['DATE_CREATE']?></td>
    </tr>
    <?}?>
    </tbody>
</table>
