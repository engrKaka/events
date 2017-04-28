@extends('dashboard.layouts.app')
@section('header')
    <section class="content-header hidden-xs">
        <div class="header-icon">
            <i class="ti-home"></i>
        </div>
        <div class="header-title">
            <h1>{{trans('messages.dashboardtitle')}}</h1>
            <small>Manage Admins.</small>
            @include('dashboard.partials.quick-links')
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="pe-7s-home"></i> Home</a></li>
                <li><a href="{{ url('/dashboard') }}"> Dashboard</a></li>
                <li class="active">Settings</li>
            </ol>
        </div>
    </section>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12 " >
            <div class="panel panel-bd ">
                <div class="panel-heading ">
                    <div  class="panel-title col-sm-10">
                        <h4>General Settings</h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">

                    {!! Form::open(['action'=>['Dashboard\SettingController@update','slug'=>'general'],'method'=>'patch','class'=>'form-horizontal','enctype'=>'multipart/form-data']) !!}
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <h3 class="text-center">General Settings</h3>
                            <hr>
                            <?php $settings = $_setting('general');

                            ?>
                            @if(count($settings)>0)
                            @foreach($settings as $key=>$setting)
                                <div class="form-group {{ $errors->has($key) ? ' has-error' : '' }}">
                                    {!! Form::label($key, $setting->title, ['class' => 'col-sm-2 control-label'])  !!}
                                    <div class="col-sm-9">
                                        @if($key=='slider_background')
                                            <input type="file" class="input-slider-background" name="slider_background">
                                        @elseif($key=='language' )
                                            {!! Form::select('language', ['es' => 'English', 'he' => 'Hebrew'], $setting->value)  !!}
                                        @else
                                            {!! Form::text($key,$value= $setting->value, $attributes = ['class'=>'form-control','placeholder'=>$setting->title])  !!}
                                        @endif
                                        @if ($errors->has($key))
                                            <span class="help-block">
                                            <strong>{{ $errors->first($key) }}</strong>
                                        </span>
                                        @endif
                                        @if($key=='slider_background')
                                            <div class="slider-background-preview">
                                                @if(!empty(($setting->value)) && file_exists(public_path('images/'.$setting->value)))
                                                    <img style="max-width: 200px;" class="img-thumbnail" src="{{ asset('images/'.$setting->value) }}" alt="{{ $setting->title }}">
                                                @else
                                                    <img style="max-width: 200px;" class="img-thumbnail" src="{{ asset('images/not-found.jpg') }}"  alt="{{ $setting->title }}">
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                                @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                                <span class="pull-right">
                                     <button type="reset" class="btn btn-default">Cancel</button>
                                     &nbsp;
                                     <button type="submit" class="btn btn-info ">Update</button>
                                </span>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script type="text/javascript">
        $(function() {

            function readURL(input,callback) {
                if (input.files && input.files.length>0) {
                    for (var i=0;i<input.files.length;i++){
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            callback(e);
                        };
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            }

            $(".input-slider-background").change(function () {
                $('.slider-background-preview').html('');
                readURL(this,function (e) {
                    $('.slider-background-preview').append('<img style="width: 120px; height: 120px;" src="'+ e.target.result +'" id="image_upload_preview" class="img-responsive img-thumbnail">')
                });
            });


        });
    </script>

@stop