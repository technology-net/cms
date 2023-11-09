@extends('packages/core::layouts.admin')
@section('title')
    @lang('plugin/cms::cms.category.screen')
@stop
@section('content')
    @php
        $label = !empty($category->id) ? trans('plugin/cms::common.update') : trans('plugin/cms::common.create');
    @endphp

    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('plugin/cms::cms.title'),
                'url' => '#',
            ],
            [
                'label' => trans('plugin/cms::cms.category.screen'),
                'url' => route('categories.index'),
            ],
            [
                'label' => $label,
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div>
        @include('packages/core::partial.note', ['text' => trans('plugin/cms::common.note', ['field' => $label, 'field2' => trans('plugin/cms::cms.category.screen')])])
        <div class="form-create-user">
            <form method="POST" action="{{ route('categories.update', $category->id ?? 0) }}" id="formSubmit">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $category->id ?? 0 }}">
                <div class="border-white bg-white p-5">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="{{ trans('plugin/cms::common.name') }}" class="control-label text-black" aria-required="true">
                                {{ trans('plugin/cms::common.name') }}
                                <strong class="text-required text-danger">*</strong>
                            </label>
                            <input class="form-control input-in" autocomplete="off" label="{{ trans('plugin/cms::common.name') }}" validate="true"
                                   validate-pattern="required" name="name" type="text" value="{{ old('name', $category->name ?? null) }}">
                            <div id="error_name"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="{{ trans('plugin/cms::common.slug') }}" class="control-label required text-black" aria-required="true">
                                {{ trans('plugin/cms::common.slug') }}
                                <strong class="text-required text-danger">*</strong>
                            </label>
                            <input class="form-control input-out" autocomplete="off" label="{{ trans('plugin/cms::common.slug') }}" validate="true"
                                   validate-pattern="required" name="slug" type="text" value="{{ old('slug', $category->slug ?? null) }}">
                            <div id="error_slug"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="{{ trans('plugin/cms::cms.category.parent') }}" class="control-label required text-black" aria-required="true">
                                {{ trans('plugin/cms::cms.category.parent') }}
                            </label>
                            <select class="form-control" name="parent_id">
                                <option value="">{{ trans('plugin/cms::common.choose') }}</option>
                                @foreach ($categories as $categoryId => $name)
                                    <option value="{{ $categoryId }}"
                                        @if(!empty($category) && $category->parent_id == $categoryId) selected @endif
                                        {{-- if itself, it cannot be selected --}}
                                        @if(!empty($category) && $category->id == $categoryId) disabled @endif
                                        {{-- if parent has childe, do not select --}}
                                        @if(!empty($category) && count($category->children) != 0) disabled @endif>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="text-center">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <span class="mdi mdi-arrow-left"></span>
                            {{ trans('packages/core::common.back') }}
                        </a>
                        <button type="submit" name="submit" value="submit" class="btn btn-success">
                            @if(!empty($category->id))
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
@endsection
@section('js')
    <script type="text/javascript">
        const ROUTE_IDX = "{!! route('categories.index') !!}"
    </script>
    <script type="text/javascript" src="{{ mix('cms/js/slug.js') }}"></script>
    <script type="text/javascript" src="{{ mix('cms/js/create-common.js') }}"></script>
@endsection
