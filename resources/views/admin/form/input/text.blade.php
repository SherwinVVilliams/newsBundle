<div class="form-group">
    <label>{{ $desc }} @if($require) <span style="color: red; font-size: large;">*</span> @endif</label><br>
    <?php $i18n = H::i18n_($lang) ?>

    @foreach($i18n as $lang)
        <small>{{ strtoupper(str_replace('_', '', $lang)) }}</small>
        <textarea class="form-control"
                  name="{{  $name.$lang }}"
                  @if($require) required="required" @endif
                  rows="3"
                  placeholder="{{ $placeholder }}">{{ (isset($input) && isset($input[ $name.$lang]) ? $input[ $name.$lang] :
                    (Request::old( $name.$lang) ? Request::old( $name.$lang) : "")) }}</textarea>
    @endforeach
</div>