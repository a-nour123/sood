<div class="sidebar-content todo-sidebar">
    <div class="todo-app-menu">
        <div class="add-task">
            @if (auth()->user()->hasPermission('category.create'))
            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#new-frame-modal">
                {{ __('governance.AddNewCategory') }}
            </button>
            @endif
        </div>
<button wire:click="getDocCategories('1')">sdsd</button>
        <div class="sidebar-menu-list">
            <div class="list-group list-group-filters">
                <div class="tab" id="tabs">
                    @foreach ($category2 as $item)
                    <button wire:click="getDocCategories('{{$item->id}}')" class="list-group-item list-group-item-action tablinks"
                        id="category-btn-{{ $item->id }}">
                        <span class=" fa {{ $item->icon }}" style=" padding: 0 6px;  font-size: 20px;  color: #44225c; "></span>
                        {{ $item->name }}
                    </button>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
