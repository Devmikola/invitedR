<h1>Страница пользователя <?= $model->login; ?></h1>

<table class="table" style="width: 400px; margin-top: 40px;">
    <tr>
        <td>Логин</td><td><?= $model->login; ?></td>
    </tr>
    <tr>
        <td>Телефон</td><td><?= $model->phone; ?></td>
    </tr>
    <tr>
        <td>Дата регистрации</td><td><?= $model->invite->date_activation; ?></td>
    </tr>
    <tr>
        <td>Страна</td><td><?= ($model->city ?  $model->city->country->name : 'Не указано'); ?></td>
    </tr>
    <tr>
        <td>Город</td><td><?= ($model->city ?  $model->city->name : 'Не указано'); ?></td>
    </tr>

</table>