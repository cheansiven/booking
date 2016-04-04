@extends('template')

@section('content')

<a class="col-sm-offset-1 btn btn-primary" href="{{ url('/addon')}}">List Addon</a>
<div style="margin: 20px 0;"></div>
{!! Form::open(['url' => 'addon','class' => 'form-horizontal']) !!}
    @include('errors.form_error')
    <div class="form-group">

        {!! Form::label('Name', 'Name:',['class'=>'col-sm-offset-1  col-sm-1']) !!}
        <div class="col-sm-6">
            {!! Form::text('name', null, ['required' => 'required','class'=> 'form-control']) !!}
        </div>
		{!! Form::submit("Save", array('class' => 'col-sm-offset-1 btn btn-primary submit_button')) !!}
    </div>

 {!! Form::close() !!}

@stop
