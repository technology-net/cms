<div class="card">
    <div class="card-header">
        @can('create categories')
            <a href="{{ route('categories.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i>
                {{ trans('packages/core::common.create') }}
            </a>
        @endcan
        @can('delete categories')
            <button class="btn btn-sm bg-danger delete-all d-none ml-2" title="Delete" role="button" data-url="{{ route('categories.deleteAll') }}">
                <i class="fas fa-trash"></i>
                {{ trans('packages/core::common.delete') }}
            </button>
        @endcan
    </div>

    <div class="card-body">
        <table class="mt-3 table table-bordered table-hover table-striped" id="dataTable">
            <thead>
            <tr>
                @can('delete categories')
                    <th width="3%" class="text-center">
                        <label class="user-checkbox-label">
                            <input class="input-check-all" type="checkbox">
                        </label>
                    </th>
                @endcan
                <th width="25%">{{ trans('plugin/cms::common.name') }}</th>
                <th width="25%">{{ trans('plugin/cms::common.slug') }}</th>
                <th width="7%">{{ trans('plugin/cms::common.sequence') }}</th>
                <th width="20%">{{ trans('plugin/cms::cms.category.parent') }}</th>
                <th width="10%">{{ trans('plugin/cms::common.created_by') }}</th>
                <th width="10%" class="text-center">{{ trans('plugin/cms::common.operations') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $item)
                <tr>
                    @can('delete categories')
                        <td class="text-center">
                            <label class="user-checkbox-label">
                                <input class="checkboxes" type="checkbox" value="{{ $item->id }}">
                            </label>
                        </td>
                    @endcan
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->slug }}</td>
                    <td class="text-right">
                        @can('edit categories')
                            <input class="form-control text-right editable" type="number" min="1" value="{{ $item->sequence }}"
                                   name="sequence" data-url="{{ route('categories.editable', $item->id) }}"
                                   data-id="{{ $item->id }}"
                                   validate="true" validate-pattern="required"
                            >
                            <div id="error_sequence-{{ $item->id }}" ></div>
                        @else
                            {{ $item->sequence }}
                        @endcan
                    </td>
                    <td>
                        {{ !empty($item->parent) ? $item->parent->name : '-' }}
                    </td>
                    <td class="text-left">{{ getNameUser($item->created_by) }}</td>
                    <td class="text-center">
                        @can('edit categories')
                            <a class="btn btn-sm bg-info" href="{{ route('categories.edit', $item->id) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        @endcan
                        @can('delete categories')
                            <button type="button" class="btn btn-sm bg-danger btn-delete" data-url="{{ route('categories.destroy', $item->id) }}">
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
