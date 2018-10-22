<div class="form-group  ">
    {{--has-error--}}
    <label>{{ $desc }} @if($require) <span style="color: red; font-size: large;">*</span> @endif</label>
    <br>
    <?php $i18n = H::i18n_($lang) ?>

    @foreach($i18n as $lang)
        <small>{{ strtoupper(str_replace('_', '', $lang)) }}</small>
        <input type="{{ $type }}" class="form-control" name="{{ $name.$lang }}" placeholder="{{ $placeholder }}"
               @if($type!="checkbox")
               value="{{ (isset($input) && isset($input[$name.$lang]) ? $input[$name.$lang] : (Request::old($name.$lang) ? Request::old($name.$lang) : "")) }}"
               @else
               {{isset($input) && isset($input[$name.$lang]) && $input[$name.$lang] ? "checked" : ""}}
               @endif
               {{$disable ? "disabled" : ""}}
               @if($require) required="required" @endif
        >
    @endforeach
</div>