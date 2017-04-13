@section('page-script')
<script type="text/javascript">
	$(document).ready(function(){
	  // Progress Wizard
	  $('#progressWizard').bootstrapWizard({
	    'nextSelector': '.next',
	    'previousSelector': '.previous',
	    onNext: function(tab, navigation, index) {
	      var $total = navigation.find('li').length;
	      var $current = index+1;
	      var $percent = ($current/$total) * 100;
	      jQuery('#progressWizard').find('.progress-bar').css('width', $percent+'%');
	    },
	    onPrevious: function(tab, navigation, index) {
	      var $total = navigation.find('li').length;
	      var $current = index+1;
	      var $percent = ($current/$total) * 100;
	      jQuery('#progressWizard').find('.progress-bar').css('width', $percent+'%');
	    },
	    onTabShow: function(tab, navigation, index) {
	      var $total = navigation.find('li').length;
	      var $current = index+1;
	      var $percent = ($current/$total) * 100;
	      jQuery('#progressWizard').find('.progress-bar').css('width', $percent+'%');
	    }
	  });
	});
</script>
@endsection