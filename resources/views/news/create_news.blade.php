@extends('layouts.app')

@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<form name="create_new" enctype="multipart/form-data" action="{{ route('news.store') }}" method="POST">
    {{ csrf_field() }}
   <div class="form-group">
      <label for="usr">Title</label>
      <input type="text" name="title" class="form-control" id="usr">
    </div>
    <div class="form-group">
      <label for="pwd">Sub-Title</label>
      <input type="text" name="sub_title" class="form-control" id="pwd">
    </div>
    <div class="form-group">
      <label for="pwd">Place</label>
      <select class="form-control" id="place" name="place">
          <option value="county">County</option>
          <option value="city">City</option>
          <option value="guild">Guild</option>
        </select>
    </div>
    <input type="file" name="audio-file"/>
    <div class="form-group">
      <label for="comment">Audio Content</label>
      <textarea class="form-control" rows="5" name="audio-text" id="comment"></textarea>
      </br>
      <button type="button" id="open_btn" class="btn btn-primary"><i class="fa fa-upload"></i>&nbsp;Upload audio</button>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Create a new</button>
    </div>
</form>
<script>
    $(document).ready(function (){
        var options = {
            // MIME type of accepted files, e. g. image/jpeg
            accept: "*",
            // cancel button
            cancelButton: "Close",
            // drop zone message
            dragMessage: "Drop files here",
            // the height of drop zone in pixels
            dropheight: 400,
            // error message
            errorMessage: "An error occured while loading file",
            // whether it is possible to choose multiple files or not.
            multiple: true,
            // OK button
            okButton: "OK",
            // file reading mode.
            // BinaryString, Text, DataURL, ArrayBuffer
            readAs: "DataURL",
            // remove message
            removeMessage: "Remove&nbsp;file",
            // file dialog title
            title: "Load file(s)"
        };

        
        $("#open_btn").click(function() {

            $.FileDialog(options).on('files.bs.filedialog', function(ev) {
              var files = ev.files[0];
              console.log(files);
            //   $.ajax({
            //         url : '{{ route("news.store") }}',
            //         method : 'POST',
            //         data : {
            //             'audio-file' : JSON.stringify(files),
            //             '_token' : '{{ csrf_token() }}'
            //         },
            //     });
            });
        });
    })
</script>
@endsection

