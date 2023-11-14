@extends('packages/core::layouts.admin')
@section('title')
    @lang('plugin/cms::cms.category.screen')
@stop
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('plugin/cms::cms.title'),
                'url' => '#',
            ],
            [
                'label' => trans('plugin/cms::cms.category.screen'),
                'url' => '#',
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div class="table-wrapper" id="menus-table">
        @include('plugin/cms::categories.include._list')
    </div>
@endsection
@section('js')
    <script type="text/javascript">
    </script>
@endsection
