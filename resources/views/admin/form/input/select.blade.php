<div class="form-group  ">
    <label>{{ $desc }} @if($require) <span style="color: red; font-size: large;">*</span> @endif</label>
    <br>
    <?php $i18n = H::i18n_($lang) ?>

    @foreach($i18n as $lang)
        <small>{{ strtoupper(str_replace('_', '', $lang)) }}</small>
        <select name="{{$name.$lang}}" {{$disable ? "disabled" : ""}} {{$require ? "required" : ""}}>
            @foreach($data as $nameS => $option)
                <option value="{{$option}}"
                        {{isset($input) && isset($input[$name.$lang]) &&  $input[$name.$lang] == $option ? "selected" : ""}}>{{$nameS}}</option>
            @endforeach
        </select>
    @endforeach
</div>