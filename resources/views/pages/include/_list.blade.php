<div class="card">
    <div class="card-header">
        @can('create pages')
            <a href="{{ route('pages.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i>
                {{ trans('packages/core::common.create') }}
            </a>
        @endcan
        @can('delete pages')
            <button class="btn btn-sm bg-danger delete-all d-none ml-2" title="Delete" role="button" data-url="{{ route('pages.deleteAll') }}">
                <i class="fas fa-trash"></i>
                {{ trans('packages/core::common.delete') }}
            </button>
        @endcan
    </div>

    <div class="card-body">
        <table class="mt-3 table table-bordered table-hover table-striped" id="dataTable">
        <thead>
            <tr role="row">
                @can('delete pages')
                    <th width="3%" class="text-center">
                        <label class="user-checkbox-label">
                            <input class="input-check-all" type="checkbox">
                        </label>
                    </th>
                @endcan
                <th width="8%" class="text-center">{{ trans('plugin/cms::common.thumbnail') }}</th>
                <th width="26%">{{ trans('plugin/cms::common.title') }}</th>
                <th width="26%">{{ trans('plugin/cms::common.slug') }}</th>
                <th width="7%">{{ trans('plugin/cms::common.sequence') }}</th>
                <th width="8%%">{{ trans('plugin/cms::common.status') }}</th>
                <th width="10%">{{ trans('plugin/cms::common.created_by') }}</th>
                <th width="10%" class="text-center">{{ trans('plugin/cms::common.operations') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $item)
                <tr>
                    @can('delete pages')
                        <td class="text-center">
                            <label class="user-checkbox-label">
                                <input class="checkboxes" type="checkbox" value="{{ $item->id }}">
                            </label>
                        </td>
                    @endcan
                    <td class="text-left">
                        @php
                            $thumbnail = $item->medias->isNotEmpty() ? getPathImage($item->medias->first()->image_sm) : asset('cms/images/image-default.png');
                            $thumbnail_alt = $item->medias->isNotEmpty() ? $item->medias->first()->name : 'image-default';
                        @endphp
                        <img src="{{ $thumbnail }}" alt="{{ $thumbnail_alt }}">
                    </td>
                    <td class="text-left">{{ $item->title }}</td>
                    <td class="text-left">{!! $item->slug !!}</td>
                    <td class="text-right">
                        @can('edit pages')
                            <input class="form-control text-right editable" type="number" min="1" value="{{ $item->sequence }}"
                                   name="sequence" data-url="{{ route('pages.editable', $item->id) }}"
                                   data-id="{{ $item->id }}"
                                   validate="true" validate-pattern="required"
                            >
                            <div id="error_sequence-{{ $item->id }}" ></div>
                        @else
                            {{ $item->sequence }}
                        @endcan
                    </td>
                    <td class="text-left">
                        {!! postStatusText($item->status) !!}
                    </td>
                    <td class="text-left">{{ getNameUser($item->created_by) }}</td>
                    <td class="text-center">
                        @can('edit pages')
                            <a class="btn btn-sm bg-info" href="{{ route('pages.edit', $item->id) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        @endcan
                        @can('delete pages')
                            <button type="button" class="btn btn-sm bg-danger btn-delete" data-url="{{ route('pages.destroy', $item->id) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
