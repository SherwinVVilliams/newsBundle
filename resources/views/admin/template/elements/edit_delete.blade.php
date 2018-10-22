<?php $type = \Illuminate\Support\Facades\Input::get('type'); ?>

    <a href="/superuser/{{$folder}}/edit/{{ $list->id }}"
       class="btn btn-sm btn-primary">Редактировать</a>

<a href="/superuser/{{$folder}}/delete/{{$list->id}}"
   class="btn btn-sm btn-danger deleteButton">Удалить</a>