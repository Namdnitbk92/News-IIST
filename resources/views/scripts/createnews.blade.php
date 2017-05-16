@section('page-script')
<script type="text/javascript">
$(document).ready(function(){
	// With Form Validation Wizard
  	var $validatorNewsForm = jQuery("#newsForm").validate({
	    highlight: function(element) {
	      jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
	    },
	    success: function(element) {
	      jQuery(element).closest('.form-group').removeClass('has-error');
	    }
	 });

  var $validatorNewsFormQuick = jQuery("#newsFormQuick").validate({
    highlight: function(element) {
      jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
      jQuery(element).closest('.form-group').removeClass('has-error');
    }
 });

    $('input[name=audio-file]').change(function(){
      var value = $(this).val();

      if(!value)
        $('.show-audio-error').fadeIn();
      else
        $('.show-audio-error').fadeOut();
    })

	  jQuery(".select2").select2({
	    width: '100%',
	    minimumResultsForSearch: -1
	  });

    $('button[type=reset]').click(function (){
      $('select[name="new_type"]').select2('val', 'none');
      $('select[name="new_type"]').trigger('change');
      $('input[name=title]').val('');
      $('textarea[name=sub_title]').val('');
      $('#file_type').select2('val', "");
      var action = $('button[name=btnCreate]');
      action.attr('action', 'create');

      $('.modal-title-new').text('Tạo mới nội dung');
      // $('.btn-action-new').text('Tạo mới nội dung');
    })

     $('input[name=audio-file]').rules('add', {
          required: true,
      })

    $('#file_type').change(function (e){
      $('input[name=name-audio-files]').val('');
      $('input[name=audio-file]').val('').clone(true);
      type = $(this).val();
      if(type === 'text')
      {
        $('.files-upload').fadeOut();
        $('._files').fadeIn();
        $('.describe_news').fadeIn();

      } 
      else if(type === 'audio')
      {
        $('.files-upload').fadeIn();
        $('i.xxx').html(' Audio file <label style="color:red;">*</label>');
        $('._files').fadeIn();
        $('.describe_news').fadeOut();
      }
      else if(type === 'video')
      {
        $('.files-upload').fadeIn();
        $('i.xxx').html(' Video file <label style="color:red;">*</label>');
        $('._files').fadeIn();
        $('.describe_news').fadeOut();
      } else 
      {
        $('._files').fadeOut();
      }
      
    });

    $('#new_type').change(function (e){
      type = $(this).val();
      
        if(type === 'basic')
        {
          $('.create_content_quickly').fadeOut();
          $('#preloaderCreateNew').fadeIn();
          setTimeout(function(){
            $('.create_content_additional').fadeIn();
            $('#preloaderCreateNew').fadeOut();
          },500);
        }
        else if(type === 'quickly')
        {
          $('.create_content_additional').fadeOut();
          $('#preloaderCreateNew').fadeIn();
          setTimeout(function(){
            $('.create_content_quickly').fadeIn();
            $('#preloaderCreateNew').fadeOut();
          },500);
        }
        else
        {
          $('.create_content_additional').fadeOut();
          $('.create_content_quickly').fadeOut();
          $('#preloaderCreateNew').fadeIn();
          setTimeout(function(){
            $('#preloaderCreateNew').fadeOut();
          },500);
        }
    });

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

     $('#progressWizard .finish').click(function (){
        $('#myModal').modal('show');
     });
     @if(isset($new))
     	$('#publishTime').val(new Date('{{$new->publish_time}}').toISOString());
     @endif

     @if(!empty(\Auth::user()->belong_to_place))
        $('select[id=place]').select2('val', '{{\Auth::user()->belong_to_place}}');
        $('select[id=place]').select2('disable');
        displayPlace('{{\Auth::user()->belong_to_place}}', '{{\Auth::user()->original_place_id}}');
     @else 
       $('select[id=place]').change(function (){
            displayPlace();
         })
     @endif

    $('#newModal').on('hidden.bs.modal', function () {
      $('#newsForm')[0].reset();
      $('#newsFormQuick')[0].reset();
      $('input[name=title]').val('');
      $('#file_type').select2('val', '');
      $('#file_type').trigger('change');
      $('select[name="new_type"]').select2('val', 'none');
      $('select[name="new_type"]').trigger('change');
      $validatorNewsFormQuick.resetForm();
      $validatorNewsForm.resetForm();
      $('select[name="new_type"]').select2('enable');
      $('input[name=name-audio-files]').val('');
      $('.modal-title-new').text('Tạo mới nội dung');
      // $('.btn-action-new').text('Tạo mới nội dung');
      
      setCurrentTime();
    })
});

function displayPlace(place, original_place_id)
{
  if (place === 'city')
  {
    $('div.city_list').show();
    $('div.county_list').hide();
    $('div.guild_list').hide();
    $('select[name=city]').select2('disable');
    original_place_id ? $('select[name=city]').select2('val', original_place_id) : void 0;
  }
  else if(place === 'county')
  {
    $('div.city_list').hide();
    $('div.county_list').show();
    $('div.guild_list').hide();
    $('select[name=county]').select2('disable');
    original_place_id ? $('select[name=county]').select2('val', original_place_id) : void 0;
  }
  else
  {
    $('div.city_list').hide();
    $('div.county_list').hide();
    $('div.guild_list').show();
    $('select[name=guild]').select2('disable');
    original_place_id ? $('select[name=guild]').select2('val', original_place_id) : void 0;
  }
}

function doSomething()
{
  	form = document.getElementById("newsForm").submit();
}

function setCurrentTime()
{
  var tzoffset = (new Date()).getTimezoneOffset() * 60000; 
  var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0,-1);
  document.getElementById("publishTime").defaultValue = localISOTime;
  document.getElementById("publishTimeQuick").defaultValue = localISOTime;
}

setCurrentTime();
// $('#newModal').modal({backdrop: 'static', keyboard: false})  
</script>
@endsection