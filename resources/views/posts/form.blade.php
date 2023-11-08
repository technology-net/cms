@extends('packages/core::layouts.admin')
@section('title')
    @lang('plugin/cms::cms.post.screen')
@stop
@section('content')
    @php
        $label = !empty($post->id) ? trans('plugin/cms::common.update') : trans('plugin/cms::common.create');
    @endphp

    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('plugin/cms::cms.title'),
                'url' => '#',
            ],
            [
                'label' => trans('plugin/cms::cms.post.screen'),
                'url' => route('posts.index'),
            ],
            [
                'label' => $label,
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div>
        @include('packages/core::partial.note', ['text' => trans('plugin/cms::common.note', ['field' => $label, 'field2' => trans('plugin/cms::cms.post.screen')])])
        <div class="form-create-user">
            <form method="POST" action="{{ route('posts.update', $post->id ?? 0) }}" id="formSubmit">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $post->id ?? 0 }}">
                <div class="border-white bg-white p-5">
                    <div class="container">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="{{ trans('plugin/cms::common.title') }}" class="control-label text-black" aria-required="true">
                                    {{ trans('plugin/cms::common.title') }}
                                    <strong class="text-required text-danger">*</strong>
                                </label>
                                <input class="form-control input-in" autocomplete="off" label="{{ trans('plugin/cms::common.title') }}" validate="true"
                                       validate-pattern="required" name="title" type="text" value="{{ old('title', $post->title ?? null) }}">
                                <div id="error_title"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="{{ trans('plugin/cms::common.slug') }}" class="control-label required text-black" aria-required="true">
                                    {{ trans('plugin/cms::common.slug') }}
                                    <strong class="text-required text-danger">*</strong>
                                </label>
                                <input class="form-control input-out" autocomplete="off" label="{{ trans('plugin/cms::common.slug') }}" validate="true"
                                       validate-pattern="required" name="slug" type="text" value="{{ old('slug', $post->slug ?? null) }}">
                                <div id="error_slug"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="{{ trans('plugin/cms::cms.post.short_content') }}" class="control-label required text-black" aria-required="true">
                                    {{ trans('plugin/cms::cms.post.short_content') }}
                                    <strong class="text-required text-danger">*</strong>
                                </label>
                                <textarea class="form-control" name="short_content" rows="4" label="{{ trans('plugin/cms::cms.post.short_content') }}" validate="true" validate-pattern="required">{{ old('key', $systemSetting->value ?? null) }}</textarea>
                                <div id="error_short_content"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="{{ trans('plugin/cms::cms.post.content') }}" class="control-label required text-black" aria-required="true">
                                    {{ trans('plugin/cms::cms.post.content') }}
                                    <strong class="text-required text-danger">*</strong>
                                </label>
                                <textarea id="editor" class="form-control" name="content" rows="4" label="{{ trans('plugin/cms::cms.post.content') }}" validate="true" validate-pattern="required">{{ old('key', $systemSetting->value ?? null) }}</textarea>
                                <div id="error_content"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="{{ trans('plugin/cms::cms.post.category') }}" class="control-label required text-black" aria-required="true">
                                    {{ trans('plugin/cms::cms.post.category') }}
                                </label>
                                <select class="form-control" name="category_id">
                                    <option value="">{{ trans('plugin/cms::common.choose') }}</option>
                                    @foreach ($categories as $categoryId => $name)
                                        <option value="{{ $categoryId }}">
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="{{ trans('plugin/cms::common.status') }}" class="control-label required text-black" aria-required="true">
                                    {{ trans('plugin/cms::common.status') }}
                                </label>
                                <select class="form-control" name="status">
                                    @foreach(postStatus() as $status_id => $name)
                                        <option value="{{ $status_id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="{{ trans('plugin/cms::common.image') }}" class="control-label required text-black" aria-required="true">
                                    {{ trans('plugin/cms::common.image') }}
                                </label>
                                <div class="preview-image-wrapper">
                                    <img width="100%" src="{{ asset('cms/images/image-default.png') }}" alt="image-default">
                                    <i class="mdi mdi-close-circle-outline remove-preview"></i>
                                </div>
                                <a href="javascript:void(0)" id="openMedia">{{ trans('plugin/cms::common.choose_img') }}</a>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="{{ trans('plugin/cms::common.tags') }}" class="control-label required text-black" aria-required="true">
                                    {{ trans('plugin/cms::common.tags') }}
                                </label>
                                <select class="form-control" name="tag_id">
                                    <option value="">{{ trans('plugin/cms::common.choose') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                            <span class="mdi mdi-arrow-left"></span>
                            {{ trans('packages/core::common.back') }}
                        </a>
                        <button type="submit" name="submit" value="submit" class="btn btn-success">
                            @if(!empty($post->id))
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
    <script type="text/javascript">
        const ROUTE_IDX = "{!! route('posts.index') !!}"
    </script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script type="text/javascript" src="{{ mix('cms/js/slug.js') }}"></script>
    <script type="text/javascript" src="{{ mix('cms/js/create-common.js') }}"></script>
    <script type="text/javascript" src="{{ mix('cms/js/posts/form.js') }}"></script>
@endsection
