<div class="form-group fileImageInput @if($require) imageRqui @endif">
    <label>{{ $desc }}
        <small>Размеры: {{$size}}; Формат: *.jpg, *.png</small> @if($require) <span
                style="color: red; font-size: large;">*</span> @endif</label>
    <div class="galleryInput" data-max="{{$max}}">
        @if(isset($input[$name]))
            @foreach($input[$name] as $img)
                @component('admin.form.input.image_template', ['img' => $img]) @endcomponent
            @endforeach
        @endif
    </div>
    <a class="btn btn-primary js-open_gallery" data-type="ajax" data-src="/superuser/upload/gallery/{{$folder}}/{{$size}}"
       href="javascript:;">
        Галерея
    </a>
    <input type="hidden" name="{{$name}}" id="">
</div>
