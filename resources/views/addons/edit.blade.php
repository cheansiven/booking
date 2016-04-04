@extends('template')
@section('content')

<a class="col-sm-offset-1 btn btn-primary" href="{{ url('/addon')}}">List Addon</a>
<div style="margin: 20px 0;"></div>

{!! Form::model($Addons, ['method' => 'PATCH', 'action' => ['AddonController@update', $Addons->id] ]) !!}

    @include('errors.form_error')
    <div class="form-group col-sm-12">

        {!! Form::label('Name', 'Name:',['class'=>'col-sm-offset-1  col-sm-1']) !!}
        <div class="col-sm-6">
            {!! Form::text('name', null, ['required' => 'required','class'=> 'form-control']) !!}
        </div>
		{!! Form::submit("Save", array('class' => 'col-sm-offset-1 btn btn-primary submit_button')) !!}
    </div>



{!! Form::close() !!}

@stop
