@extends('admin.template.master')
@section('pageName', $page_name)
@section('pageSubName')
   <a href="/superuser/{{$folder}}/edit/0" class="btn btn-success">Добавить</a>
@endsection
@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Текст</th>
                <th>Картинка</th>
                <th>Категория</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $list)
                <tr>
                    <td>{{$list->id}}</td>
                    <td>{{$list->title}}</td>
                    <td>{{str_limit($list->desc, 250)}}</td>
                    <td>{{ str_limit($list->text, 250) }}</td>
                    <td><img src = "{{U::pathID(json_decode($list->image_id)[0], '539x352')}}" width="250" height="200"></td>
                    <td>{{ $list->category->name }}</td>
                    <td>
                        @component('admin.template.elements.edit_delete', ['folder' => $folder, 'list' => $list])
                            Whoops, template error
                        @endcomponent
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection