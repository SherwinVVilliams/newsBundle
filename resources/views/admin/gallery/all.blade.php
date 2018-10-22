<div class="col-xs-12">
    <form class="upload-form {{ count($images) > 0 ? 'has-file' : '' }}" id="galleryForm" method="POST"
          data-folder="{{$folder}}" data-size="{{$size}}">
        <input type="file" id="inputUpload" name="files[]" multiple=""/>
        <div class="uploader-inline">
            <h3 class="upload-instructions">Click Or Drop Files To Upload. We Use Jquery File Upload, You Can Learn
                More Form</h3>
        </div>
        <div class="file-wrap container-fluid">
            <div class="file-list row">
                @foreach($images as $img)
                    <div class="file template-download fade col-lg-2 col-md-4 col-sm-6 image in">
                        <div class="file-item">
                            <div class="preview vertical-align">
                                <div class="check" data-id="{{$img->id}}">
                                    <div class="checkbox"><i class="fa fa-check-square" aria-hidden="true"></i></div>
                                </div>
                                <div class="file-action-wrap">
                                    <div class="file-action"><i class="icon delete fa fa-times" data-type="DELETE"
                                        data-url="/superuser/upload/delete?key={{$img->id}}"></i>
                                    </div>
                                </div>
                                <img src="{{\U::pathI($img)}}"></div>
                            <div class="info-wrap">
                                <div class="title">{{$img->name}}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="galleryAdd btn btn-primary">Добавить</button>
        </div>
    </form>
</div>