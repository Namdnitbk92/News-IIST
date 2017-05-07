@section('page-script')
<script type="text/javascript">
$(document).ready(function(){
	// With Form Validation Wizard
  	var $validator = jQuery("#newsForm, #newsFormQuick").validate({
	    highlight: function(element) {
	      jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
	    },
	    success: function(element) {
	      jQuery(element).closest('.form-group').removeClass('has-error');
	    }
	 });

	  jQuery(".select2").select2({
	    width: '100%',
	    minimumResultsForSearch: -1
	  });

    $('button[type=reset]').click(function (){
      $('select[name="new_type"]').select2('val', 'none');$('select[name="new_type"]').trigger('change');
      $('input[name=title]').val('');
      $('input[name=sub_title]').val('');
      $('#file_type').select2('val', "");
      var action = $('button[name=btnCreate]');
      action.attr('action', 'create');

      $('.modal-title').text('Tạo mới nội dung');
      $('.btn-action-new').text('Tạo mới nội dung');
    })


    $('#file_type').change(function (e){
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
        $('i.xxx').text(' Audio file');
        $('._files').fadeIn();
        $('.describe_news').fadeOut();
      }
      else if(type === 'video')
      {
        $('.files-upload').fadeIn();
        $('i.xxx').text(' Video file');
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
        $('.create_content_additional').fadeIn();
        $('.create_content_quickly').fadeOut();
      }
      else if(type === 'quickly')
      {
        $('.create_content_additional').fadeOut();
        $('.create_content_quickly').fadeIn();
      }
      else
      {
        $('.create_content_additional').fadeOut();
        $('.create_content_quickly').fadeOut();
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

      //   $('#county').change(function (){
      //     $.ajax({
      //         url : '{{ route("getGuildList") }}',
      //         method : 'GET',
      //         data : {
      //             'county_id' : $('#county').val(),
      //             '_token' : '{{ csrf_token() }}'
      //         },
      //     }).done(function (response){
      //       guilds = response.guilds;

      //       if (guilds && guilds.length)
      //       {
      //         for (index in guilds)
      //         {
      //           $('#guild').show(500);
      //           $('#guild').empty();
      //           $('#guild').append('<option value="' + guilds[index].id + '">' + guilds[index].name + '</option>');
      //         }
      //       }
      //       else 
      //       {
      //         $('#guild').empty();
      //       }
      //     });
      // });

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

var tzoffset = (new Date()).getTimezoneOffset() * 60000; 
var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0,-1);
document.getElementById("publishTime").defaultValue = localISOTime;

</script>
@endsection