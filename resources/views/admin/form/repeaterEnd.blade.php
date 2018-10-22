</div>
<div class="form-group ">
    <button type="button" class="delete btn btn-danger">Удалить</button>
</div>

</div>
<div class="body" data-i="{{ (isset($input) && isset($input[$name]) ? $input[$name] :  "") }}">

</div>
<button type="button" class="add btn btn-success">Добавить</button>
</div>
<script>
    $(function () {
        (new RepeaterConstructor('.{{$name}}', {{$min}}, {{$max}})).create();
    })
</script>