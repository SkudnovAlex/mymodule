<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="row">
    <h4>Связь один к одному</h4>
    <p>Получаем информацию по жителю, в каком городе живет и регионе</p>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID записи</th>
            <th>Имя жителя</th>
            <th>Фамилия</th>
            <th>Название города</th>
            <th>Название региона</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($arResult['1_1'] as $item){?>
        <tr>
            <td><?=$item['ID']?></td>
            <td><?=$item['NAME']?></td>
            <td><?=$item['LAST_NAME']?></td>
            <td><?=$item['NAME_CITY']?></td>
            <td><?=$item['NAME_REGION']?></td>
        </tr>
        <?}?>
        </tbody>
    </table>
</div>
<br><br>
<div class="row">
    <h4>Связь один ко многим</h4>
    <p>Получаем всех жителей городов</p>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Название города</th>
            <th>Имя жителя</th>
            <th>Фамилия жителя</th>
            <th>ID города в сущности города</th>
            <th>ID города в сущности жители</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($arResult['1_N'] as $item){?>
            <tr>
                <td><?=$item['NAME']?></td>
                <td><?=$item['NAME_RESIDENTS']?></td>
                <td><?=$item['LAST_NAME_RESIDENTS']?></td>
                <td><?=$item['ID_CITY']?></td>
                <td><?=$item['ID_CITY_RESIDENTS']?></td>
            </tr>
        <?}?>
        </tbody>
    </table>
</div>
