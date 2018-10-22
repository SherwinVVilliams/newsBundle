<div class="form-group summerInstall">
    <label>{{ $desc }}</label>
    <?php $i18n = H::i18n_($lang) ?>

    @foreach($i18n as $lang)
        <small>{{ strtoupper(str_replace('_', '', $lang)) }}</small>
        <div class="summer_{{ $name.$lang }}">

        </div>
        <textarea name="{{ $name.$lang }}"
                  style="display:none;">{!! (isset($input) && isset($input[$name.$lang]) ? $input[$name.$lang] : (Request::old($name.$lang) ? Request::old($name.$lang) : "")) !!}</textarea>

        <script>
            @if(!$repeat)
                    summerInstall('{{$name.$lang}}', '{{$name.$lang}}');
            @endif
        </script>
    @endforeach
</div>
