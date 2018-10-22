<div class="form-group chosen @if($errors->any() && isset($errors->toArray()[$name])) has-error @endif @if($require) require @endif"
    data-max="{{$max}}">
    <label>{{ $desc }} @if($require) <span style="color: red; font-size: large;">*</span> @endif
        <small>{{ (isset($errors->toArray()[$name][0]) ? "(".$errors->toArray()[$name][0].")" : '') }}</small>
    </label>
    <select class="form-control" name="{{ $name }}" multiple data-placeholder="{{$desc}}">
        @foreach($data as $d)
            <option
                    {{ isset($input) && isset($input[$name]) && in_array($d->{'id'}, $input[$name]) ? "selected" : "" }}
                    value="{{$d->id }}">
                @if(gettype($var) == 'array')
                    @foreach($var as $n)
                        {{ $d->{$n} }}
                    @endforeach
                @else
                    {{ $d->{$var} }}
                @endif
            </option>
        @endforeach
    </select>
</div>

@if(!$repeater)
    <script>
        $("select[name='{{$name}}']").chosen(@if($max){max_selected_options: {{$max}}}@endif );
    </script>
@endif