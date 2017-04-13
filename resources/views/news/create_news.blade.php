@extends('layouts.app')

@section('content')

<div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="panel-btns">
          <a href="" class="panel-close">&times;</a>
          <a href="" class="minimize">&minus;</a>
        </div>
        <h4 class="panel-title">Create a new article</h4>
      </div>
      <div class="panel-body panel-body-nopadding">
        
        <!-- BASIC WIZARD -->
        <div id="progressWizard" class="basic-wizard">
          
          <ul class="nav nav-pills nav-justified">
            <li><a href="#ptab1" data-toggle="tab"><span>Step 1:</span> Basic Info</a></li>
            <li><a href="#ptab2" data-toggle="tab"><span>Step 2:</span> Area Info</a></li>
            <li><a href="#ptab3" data-toggle="tab"><span>Step 3:</span> Audio & Video & Text Info</a></li>
          </ul>
            
          <div class="tab-content">
            
            <div class="progress progress-striped active">
              <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            
            <div class="tab-pane" id="ptab1">
              <form class="form">
                <div class="form-group">
                  <label class="col-sm-4">Title</label>
                  <div class="col-sm-8">
                    <input type="text" name="title" class="form-control" value="{{ isset($new) ? $new->title : ''}}"/>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-4">Description</label>
                  <div class="col-sm-8">
                    <input type="text" name="sub_title" class="form-control" value="{{isset($new) ? $new->sub_title : ''}}"/>
                  </div>
                </div>

                 <div class="form-group">
                  <label class="col-sm-4">Place</label>
                  <div class="col-sm-4">
                    <select class="select2" id="place" name="type">
                      <option value="county">County</option>
                      <option value="city">City</option>
                      <option value="guild">Guild</option>
                    </select>
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane" id="ptab2">
              <form class="form">
                <div class="form-group">
                  <label class="col-sm-4">City</label>
                  <div class="col-sm-7">
                   <select class="select2" id="place" name="city">
                    <option value="1">Ha Noi</option>
                  </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-4">County</label>
                  <div class="col-sm-8">
                    <select class="select2" id="county" name="county">
                      @if(isset($counties))
                        @foreach($counties as $county)
                          <option value="{{$county->id}}">{{ $county->name }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-4">Guild</label>
                  <div class="col-sm-4">
                    <select class="select2" id="guild" name="guild" style="display:none;">
                    </select>
                  </div>
                </div>
                
              </form>
            </div>
            <div class="tab-pane" id="ptab3">
              <form action="files" class="dropzone dz-clickable col-md-8">
                  <div class="dz-default dz-message">
                  <span>Drop files here to upload</span>
                  </div>
              </form>
              <form class="form">
                <div class="form-group">
                  <label class="col-sm-4">Card No</label>
                  <div class="col-sm-8">
                    <input type="text" name="cardno" class="form-control" />
                  </div>
                </div>



                <div class="form-group">
                  <label class="col-sm-4">CSV</label>
                  <div class="col-sm-4">
                    <input type="text" name="csv" class="form-control" />
                  </div>
                </div>
                
              </form>
            </div>
            
            
          </div><!-- tab-content -->
          
          <ul class="pager wizard">
              <li class="previous"><a href="javascript:void(0)">Previous</a></li>
              <li class="next"><a href="javascript:void(0)">Next</a></li>
            </ul>
          
        </div><!-- #basicWizard -->
        
      </div><!-- panel-body -->
    </div><!-- panel -->
    
  </div><!-- row -->

<form name="create_new" style="margin:50px" enctype="multipart/form-data" action="{{ !isset($new) ? route('news.store') : route('news.update', ['id' => $new->id]) }}" method="POST">
    {{ csrf_field() }}
    @if(isset($new))
        <input type="hidden" name="_method" value="put" />
    @endif
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
   <div class="form-group">
      <div class="row">
        <div class="col-md-6 col-xs-6">
          <label for="usr">Title</label>
        <input type="text" name="title" class="form-control" id="usr" value="{{ isset($new) ? $new->title : ''}}">
        </div>
        <div class="col-md-6 col-xs-6">
            <label for="pwd">Sub-Title</label>
            <input type="text" name="sub_title" class="form-control" id="pwd" value="{{isset($new) ? $new->sub_title : ''}}">
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="pwd">Place</label>
      <select class="form-control" id="place" name="type">
          <option value="county">County</option>
          <option value="city">City</option>
          <option value="guild">Guild</option>
        </select>
    </div>
    <div class="form-group">
      <label for="pwd">City</label>
      <select class="form-control" id="place" name="city">
        <option value="1">Ha Noi</option>
      </select>
    </div>
    <div class="form-group">
      <label for="pwd">County</label>
      <select class="form-control" id="county" name="county">
        @if(isset($counties))
          @foreach($counties as $county)
            <option value="{{$county->id}}">{{ $county->name }}</option>
          @endforeach
        @endif
      </select>
    </div>
    <div class="form-group">
      <label for="pwd">Guild</label>
      <select class="form-control" id="guild" name="guild" style="display:none;">
      </select>
    </div>
    <div class="input-group">
        <label class="input-group-btn">
            <span class="btn btn-primary">
                <i class="fa fa-upload"></i>&nbsp;Upload audio&hellip; <input type="file" name="audio-file" style="display: none;" multiple>
            </span>
        </label>
        <input type="text" class="form-control" readonly>
    </div>
    <div class="form-group">
      <label for="comment">Audio Content</label>
      <textarea class="form-control" rows="5" name="audio-text" id="comment"></textarea>
      </br>
    </div>
    <div class="form-group">
      @if(isset($new))
        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i>&nbsp;Update a new</button>
      @else
        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Create a new</button>
      @endif
    </div>
</form>
<script>
    $(document).ready(function (){


      // We can attach the `fileselect` event to all file inputs on the page
      $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
      });

      // We can watch for our custom `fileselect` event like this
      $(document).ready( function() {
          $(':file').on('fileselect', function(event, numFiles, label) {

              var input = $(this).parents('.input-group').find(':text'),
                  log = numFiles > 1 ? numFiles + ' files selected' : label;

              if( input.length ) {
                  input.val(log);
              } else {
                  if( log ) alert(log);
              }

          });
      });

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
              // $.ajax({
              //       url : '{{ route("news.store") }}',
              //       method : 'POST',
              //       data : {
              //           'audio-file' : JSON.stringify(files),
              //           '_token' : '{{ csrf_token() }}'
              //       },
              //   });
            });
        });

        $('#county').change(function (){
          $.ajax({
              url : '{{ route("getGuildList") }}',
              method : 'GET',
              data : {
                  'county_id' : $('#county').val(),
                  '_token' : '{{ csrf_token() }}'
              },
          }).done(function (response){
            guilds = response.guilds;

            if (guilds && guilds.length)
            {
              for (index in guilds)
              {
                $('#guild').show(500);
                $('#guild').empty();
                $('#guild').append('<option value="' + guilds[index].id + '">' + guilds[index].name + '</option>');
              }
            }
            else 
            {
              $('#guild').empty();
            }
          });
      });
    })
</script>
@endsection
@include('scripts.createnews')
