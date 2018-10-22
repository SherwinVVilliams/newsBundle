@extends('admin.template.master')
@section('pageName', $page_name)

@if(isset($input) && $input)
    @section('pageSubName')
        <a href="/superuser/{{$folder}}/delete/{{$input["id"]}}" class="btn btn-sm btn-danger deleteButton">Удалить</a>
    @endsection
@endif

@section('content')
    <div class="col-xs-12">
        {!! F::o('/superuser/'.$folder.'/edit') !!}


                {!! F::hide('id', $id)!!}

                {!! F::input('title', 'Название', ['require' => true]) !!}

                {!! F::textarea('desc', 'Описание', ['require' => true]) !!}

                {!! F::textarea('text', 'Текст', ['require' => true]) !!}

                {!! F::chosen('category_id', 'Категория', 'news_categories', [
                    'require' => true,
                    'var' => 'name',
                ]) !!}
               
                {!! F::image('image_id', 'Картинка', [
                    'require' => true,
                    'size' => '539x352',
                    'folder'    => 'news'
                ]) !!}

        {!!F::c()!!}
    </div>

@endsection