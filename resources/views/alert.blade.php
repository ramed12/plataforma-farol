@if (Session::has('alert'))
    <div class="row" style="margin-top:20px;">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    		<div class="alert alert-{!!session('alert.code')!!} alert-dismissible fade show py-2" role="alert">
			  {!! session('alert.text') !!}
			</div>
    	</div>
    </div>
@endif
