@extends('layouts.master')
@section('content')
    <div class="row mbm-10">
        <div class="col-md-11 col-sm-12">
            <div class="card pt-10 offset-1">
				<div class="card-header">
						<h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : trans('messages.list') }} </h3>
				</div>
				<div class="card-body">
					{!! Form::open(['method' => 'POST', 'route' => ['term-condition-save'],'files'=>true] ) !!}
					<input type="hidden" name='id' value="{{ optional($term_condition_data)->id }}">
						<div class="col-sm-12">
							{!! Form::textarea('value',optional($term_condition_data)->value, array('placeholder' => trans('messages.enter_field',['field' => trans('messages.description')]),'class' => 'form-control')) !!}
							@if($errors->has('value'))
								<span class="message-danger">{{ $errors->first('value') }}</span>
							@endif
						</div>
						<div class="col-sm-12 mt-30">
							<button type="submit" class="btn btn-primary btn-md" value="Submit">Save</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection
