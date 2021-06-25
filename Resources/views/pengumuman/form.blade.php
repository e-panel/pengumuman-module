<div class="box-typical-body padding-panel">
    <div class="row">
        <div class="col-md-8">

            <fieldset class="form-group {{ $errors->has('judul')?'form-group-error':'' }}">
                <label for="judul" class="form-label">
                    {{ __('pengumuman::general.form.title.label') }} <span class="text-danger">*</span>
                </label>
                <div class="form-control-wrapper">
                    {!! Form::text('judul', null, ['class' => 'form-control', 'placeholder' => __('pengumuman::general.form.title.placeholder')]) !!}
                    {!! $errors->first('judul', '<span class="text-muted"><small>:message</small></span>') !!}
                </div>
            </fieldset>
            <fieldset class="form-group {{ $errors->has('perihal')?'form-group-error':'' }}">
                <label for="perihal" class="form-label">
                    {{ __('pengumuman::general.form.content.label') }} <span class="text-danger">*</span>
                </label>
                <div class="form-control-wrapper">
                    {!! Form::textarea('perihal', null, ['class' => 'form-control tinymce', 'placeholder' => __('pengumuman::general.form.content.placeholder')]) !!}
                    {!! $errors->first('perihal', '<span class="text-muted"><small>:message</small></span>') !!}
                </div>
            </fieldset>
           
        </div>
        <div class="col-md-4">
            <fieldset class="form-group {{ $errors->has('lampiran')?'form-group-error':'' }}">
                <label class="form-label" for="lampiran">
                	{{ __('pengumuman::general.form.attachment.label') }}
                	@if(isset($edit))
		                @if(!is_null($edit->lampiran))
		                    <a class="small pull-right" href="{{ asset($edit->lampiran) }}" data-lity>
		                        <i class="fa fa-search"></i> <b>{{ __('pengumuman::general.form.attachment.view') }}</b>
		                    </a>
		                @endif
		            @endif
                </label>
                <div class="form-control-wrapper">
                    {!! Form::file('lampiran', ['class' => 'form-control']) !!}
                </div>
            </fieldset>
		            
            <div class="alert alert-success" style="margin-top:5px">
                <small>{!! __('pengumuman::general.form.attachment.notes') !!}</small>
            </div>
        </div>
    </div>
</div>