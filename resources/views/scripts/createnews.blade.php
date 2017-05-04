@section('page-script')
<script type="text/javascript">
$(document).ready(function(){
	// With Form Validation Wizard
  	var $validator = jQuery("#newsForm").validate({
	    highlight: function(element) {
	      jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
	    },
	    success: function(element) {
	      jQuery(element).closest('.form-group').removeClass('has-error');
	    }
	 });
	  // Progress Wizard
	  $('#progressWizard').bootstrapWizard({
	  	'tabClass': 'nav nav-pills nav-justified nav-disabled-click',
	    'nextSelector': '.next',
	    'previousSelector': '.previous',
	    'finishSelector': '.finish',
	    onTabClick: function(tab, navigation, index) {
	      return false;
	    },
	    onNext: function(tab, navigation, index) {
		  var $valid = jQuery('#newsForm').valid();
	      if(!$valid) {
	        
	        $validator.focusInvalid();
	        return false;
	      }
	      var $total = navigation.find('li').length;
	      var $current = index+1;
	      var $percent = ($current/$total) * 100;
	      jQuery('#progressWizard').find('.progress-bar').css('width', $percent+'%');
	      console.log(index);
	      if (index >= 2)
	      {
	      	$('#progressWizard .next').addClass('hide').removeClass('show');
	      	$('#progressWizard .finish').addClass('show').removeClass('hide');
	      } 
	    },
	    onPrevious: function(tab, navigation, index) {
	      var $total = navigation.find('li').length;
	      var $current = index+1;
	      var $percent = ($current/$total) * 100;
	      jQuery('#progressWizard').find('.progress-bar').css('width', $percent+'%');

	      if (index < 2)
	      {
	      	$('#progressWizard .next').addClass('show').removeClass('hide');
	      	$('#progressWizard .finish').addClass('hide').removeClass('show');
	      }
	     
	    }
	  });

	  jQuery(".select2").select2({
	    width: '100%',
	    minimumResultsForSearch: -1
	  });

    $('#file_type').change(function (e){
      type = $(this).val();
      if(type === 'text')
      {
        $('i.file-name').text('  Upload text file');
        $('._files').fadeIn();
      }
      else if(type === 'audio')
      {
        $('i.file-name').text('  Upload audio file');
        $('._files').fadeIn();
      }
      else if(type === 'video')
      {
        $('i.file-name').text('  Upload video file');
        $('._files').fadeIn();
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
</script>
@endsection