@extends('packages/core::layouts.admin')
@section('title')
    @lang('plugin/cms::cms.page.screen')
@stop
@section('content')
    @php
        $label = !empty($page->id) ? trans('plugin/cms::common.update') : trans('plugin/cms::common.create');
    @endphp

    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('plugin/cms::cms.title'),
                'url' => '#',
            ],
            [
                'label' => trans('plugin/cms::cms.page.screen'),
                'url' => route('pages.index'),
            ],
            [
                'label' => $label,
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div>
        @include('packages/core::partial.note', ['text' => trans('plugin/cms::common.note', ['field' => $label, 'field2' => trans('plugin/cms::cms.page.screen')])])
        <div class="form-create-user">
            <form method="POST" action="{{ route('pages.update', $page->id ?? 0) }}" id="formSubmit">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $page->id ?? 0 }}">
                <div class="border-white bg-white p-5">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="{{ trans('plugin/cms::common.title') }}" class="control-label text-black" aria-required="true">
                                        {{ trans('plugin/cms::common.title') }}
                                        <strong class="text-required text-danger">*</strong>
                                    </label>
                                    <input class="form-control input-in" autocomplete="off" label="{{ trans('plugin/cms::common.title') }}" validate="true"
                                           validate-pattern="required" name="title" type="text" value="{{ old('title', $page->title ?? null) }}">
                                    <div id="error_title"></div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="{{ trans('plugin/cms::common.slug') }}" class="control-label required text-black" aria-required="true">
                                        {{ trans('plugin/cms::common.slug') }}
                                        <strong class="text-required text-danger">*</strong>
                                    </label>
                                    <input class="form-control input-out" autocomplete="off" label="{{ trans('plugin/cms::common.slug') }}" validate="true"
                                           validate-pattern="required" name="slug" type="text" value="{{ old('slug', $page->slug ?? null) }}">
                                    <div id="error_slug"></div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="{{ trans('plugin/cms::common.short_content') }}" class="control-label required text-black" aria-required="true">
                                        {{ trans('plugin/cms::common.short_content') }}
                                    </label>
                                    <textarea class="form-control" name="short_content" rows="4" label="{{ trans('plugin/cms::common.short_content') }}" validate="true" validate-pattern="required">{!! old('short_content', $page->short_content ?? null) !!}</textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="{{ trans('plugin/cms::common.content') }}" class="control-label required text-black" aria-required="true">
                                        {{ trans('plugin/cms::common.content') }}
                                    </label>
                                    <textarea id="editor" class="form-control" name="content" rows="4" label="{{ trans('plugin/cms::common.content') }}" validate="true" validate-pattern="required">{!! old('content', $page->content ?? null) !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="{{ trans('plugin/cms::common.status') }}" class="control-label required text-black" aria-required="true">
                                        {{ trans('plugin/cms::common.status') }}
                                    </label>
                                    <select class="form-control" name="status">
                                        @foreach(postStatus() as $statusId => $name)
                                            <option value="{{ $statusId }}" @if(!empty($page) && $page->status == $statusId) selected @endif>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="{{ trans('plugin/cms::common.thumbnail') }}" class="control-label required text-black" aria-required="true">
                                        {{ trans('plugin/cms::common.thumbnail') }}
                                        <sup class="text-danger">{{ trans('plugin/cms::common.thumbnail_note') }}</sup>
                                    </label>
                                    <div class="row" id="wrap-preview">
                                        @if(!empty($page) && $page->medias->isNotEmpty())
                                            @foreach($page->medias as $media)
                                                <div class="col-md-4 item-thumbnail">
                                                    <div class="preview-image">
                                                        <img width="100%" src="{{ asset('storage' . $media->image_sm) }}" alt="{{ $media->name }}">
                                                        <i class="mdi mdi-close-circle-outline remove-preview"></i>
                                                        <input type="hidden" name="media_id[]" value="{{ $media->id }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-md-4">
                                                <div class="preview-image">
                                                    <img width="100%" src="{{ asset('cms/images/image-default.png') }}" alt="image-default">
                                                    <i class="mdi mdi-close-circle-outline remove-preview"></i>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <a href="javascript:void(0)" id="openMedia">{{ trans('plugin/cms::common.choose_img') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="text-center">
                        <a href="{{ route('pages.index') }}" class="btn btn-secondary">
                            <span class="mdi mdi-arrow-left"></span>
                            {{ trans('packages/core::common.back') }}
                        </a>
                        <button type="submit" name="submit" value="submit" class="btn btn-success">
                            @if(!empty($page->id))
                                <span class="mdi mdi-sync"></span>
                            @else
                                <span class="mdi mdi-plus"></span>
                            @endif
                                {{ $label }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('packages/core::settings.media.include._modal-open-media')
@endsection
@section('js')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script type="text/javascript" src="{{ mix('cms/js/slug.js') }}"></script>
    <script type="text/javascript" src="{{ mix('cms/js/create-common.js') }}"></script>
    <script type="text/javascript">
        const ROUTE_IDX = "{!! route('pages.index') !!}";
        CKEDITOR.replace( 'editor' );
    </script>
@endsection
