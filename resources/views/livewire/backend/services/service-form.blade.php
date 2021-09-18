<div>

    @php
        $lang = app()->getLocale();
        $name_var = "name_$lang";
    @endphp
    <div class="col-10 mb-3">
        <select class="custom-select form-control" name="categories" id="categories" wire:model="categoryId"
                wire:change="changeCategory">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->$name_var }}</option>
            @endforeach
        </select>
    </div>
    <div class="row justify-content-center mb-3">
        @foreach($sub_categories as $sub_category)
            <button type="button"
                    class="btn  mr-3 {{ $sub_category->id == $subCategoryId ? 'btn-primary' : 'btn-success' }}"
                    wire:click="clickSubCategory({{ $sub_category->id }})">{{ $sub_category->$name_var }}</button>
        @endforeach
    </div>
    @if($fields != null )
        <form wire:submit.prevent="submitForm" method="post" enctype="multipart/form-data">
            @csrf
            @foreach($fields as $field)
                @php
                    $name = $field->$name_var;
                    $field_value = $field->pivot->value;
                @endphp

                @if($field->type == 'int')
                    <div class="form-group row">
                        <label for="{{ $field->key }}" class="col-2 col-form-label">{{ $name }}</label>
                        <div class="col-10">
                            <input
                                class="form-control @error('myForm.' . $field->key) is-invalid @enderror"
                                type="number" name="{{ $field->key }}" wire:model="myForm.{{ $field->key}}"
                                value="{{ $field_value }}" id="{{ $field->key }}">
                            @error('myForm.' . $field->key) <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @elseif($field->type == 'text')
                    <div class="form-group row">
                        <label for="{{ $field->key }}" class="col-2 col-form-label">{{ $name }}</label>
                        <div class="col-10">
                             <textarea class="form-control @error('myForm.' . $field->key) is-invalid @enderror"
                                       name="{{ $field->key }}" rows="3"
                                       id="{{ $field->key }}" wire:model="myForm.{{ $field->key}}"
                             >{{ $field_value }}</textarea>
                            @error('myForm.' . $field->key) <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @elseif($field->type == 'image')
                    <div class="form-group row">
                        <label for="{{ $field->key }}" class="col-2 col-form-label">{{ $name }}</label>
                        <div class="col-10">
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                                       name="{{ $field->key }}[]"
                                       id="{{ $field->key }}" wire:model="images" multiple>
                                <label class="custom-file-label" for="{{ $field->key }}">Choose file</label>
                                @error('images')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @error('images.*') <span
                                    class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @elseif($field->type == 'select')
                    <div class="form-group row">
                        <label for="{{ $field->key }}" class="col-2 col-form-label">{{ $name }}</label>
                        <div class="col-10">
                            <select
                                class="custom-select form-control @error('myForm.' . $field->key) is-invalid @enderror"
                                name="{{ $field->key }}"
                                id="{{ $field->key }}" wire:model="myForm.{{ $field->key}}">
                                <option selected="selected">Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            @error('myForm.' . $field->key) <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label for="{{ $field->key }}" class="col-2 col-form-label">{{ $name }}</label>
                        <div class="col-10">
                            <input class="form-control @error('myForm.' . $field->key) is-invalid @enderror"
                                   type="text"
                                   name="{{ $field->key }}" value="{{ $field_value }}"
                                   id="{{ $field->key }}" wire:model="myForm.{{ $field->key}}">
                            @error('myForm.' . $field->key) <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="form-group text-center">
                <button type="submit" class="btn btn-success d-flex align-items-center justify-content-center m-auto">
                    @if(app()->getLocale() == 'ar')
                        <div wire:loading wire:target="submitForm" class="mr-2">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <span class="ml-2">{{ trans('backend.save_data') }}</span>
                    @else
                        <span>{{ trans('backend.save_data') }}</span>
                        <div wire:loading wire:target="submitForm" class="ml-2">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    @endif
                </button>
            </div>

        </form>
    @endif

</div>


