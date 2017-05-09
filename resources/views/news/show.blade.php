<div id="message" class="alert alert-success hide"></div>

<div class="row">
  <div class="panel panel-default panel-alt widget-messaging">
    <div class="panel-heading">
        <div class="panel-btns">
        </div><!-- panel-btns -->
        <h3 class="panel-title new-title">{{ isset($new) ? $new->title : '' }}</h3>
      </div>
      <div class="panel-body">
        <ul>
          <li>
            <h5 class="pull-right new-created">{{ isset($new) ? $new->created_at : '' }}</h5>
            <h4 class="sender"><i class="fa fa-calendar" aria-hidden="true"></i> {{trans('app.created_at')}}</h4>
          </li>
          <li>
            <h5 class="pull-right new-username">{{ isset($user) ? $user->name : '' }}</h5>
            <h4 class="sender"><i class="fa fa-calendar" aria-hidden="true"></i> <label class="new-create-by">{{trans('app.created_by')}}</label> <b> </h4>
          </li>
          <li>
            <h5 class="pull-right new-place">{{ isset($place) ? $place->name : '' }} {{ $address ?? '' }}</h5>
            <h4 class="sender"> <i class="fa fa-building-o" aria-hidden="true"></i> By {{trans('app.place')}} <b> </h4>
          </li>
          <li><i class="fa fa-hand-o-right" aria-hidden="true"></i>  
            <label class="">{{trans('app.status')}} </label>
            <h5 class="pull-right _status">
            @if(isset($new))
              <span class="new-status label label-{{$new->status_id == 1 ? 'success' : (
                $new->status_id == 2 ? 'warning' : 'danger'
              )}}">
              {{ isset($new) && $new->status() ? $new->status()->first()->description ?? '' : '' }}
            </span>
            @else
              <span class="new-status label label-">
              </span>
            @endif
            </h5>
          </li>
          <li>
            <h5 class="pull-right new-publish-at" style="color:#f0ad4e; font-weight: bold;">{{ isset($new) ? $new->publish_time : '' }}</h5>
            <h4 class="sender"><i class="fa fa-calendar"></i>&nbsp;{{trans('app.publish_time')}}</h4>
          </li>
          <li>
              <div class="embed-responsive embed-responsive-16by9">
                <video class="embed-responsive-item" controls>
                    <source src="{{isset($new) ? $new->audio_path.'?autoplay=false' : ''}}" type="video/mp4">
                </video>
              </div>  
          </li>
          <li>
            <h3>{{trans('app.attach_file')}}</h3>
            <h4>
              <embed src="{{isset($new) ? $new->attach_path_file : ''}}" width="100%" height="100%" />
            </h4>
          </li>
          <li>
            <h3>{{trans('app.text')}}</h3>
            <h4 class="new-text">{{ isset($new) ? $new->audio_text : '' }}</h4>
          </li>
        </ul>
      </div><!-- panel-body -->
    </div>
</div>

<script>
function goBack() {
    window.history.back();
}
</script>
<style>
  .panel-btns > a {
    font-size:25px;
    margin:5px !important;
  }
</style>
