<div>
    <div class="col-10 mb-3">
        <select class="custom-select form-control" name="categories" id="categories" wire:model="categoryId"
                wire:change="changeCategory">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="row justify-content-center mb-3">
        @foreach($sub_categories as $sub_category)
            <button type="button"
                    class="btn  mr-3 {{ $sub_category->id == $subCategoryId ? 'btn-primary' : 'btn-success' }}"
                    wire:click="clickSubCategory({{ $sub_category->id }})">{{ $sub_category->name }}</button>
        @endforeach
    </div>
    @if($fields != null )
        <form wire:submit.prevent="submitForm" method="post" enctype="multipart/form-data">
            @csrf
            @foreach($fields as $field)
                <?php
                $name = str_replace('_', ' ', $field->name);
                $field_value = $field->pivot->value;
                ?>
                <input type="hidden" value="20" wire:model="test">
                @if($field->type == 'int')
                    <div class="form-group row">
                        <label for="{{ $field->name }}" class="col-2 col-form-label">{{ $name }}</label>
                        <div class="col-10">
                            <input class="form-control @error('myForm.' . $field->name) is-invalid @enderror"
                                   type="number"
                                   name="{{ $field->name }}" wire:model="myForm.{{ $field->name}}"
                                   value="{{ $field_value }}"
                                   id="{{ $field->name }}">
                            @error('myForm.' . $field->name) <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @elseif($field->type == 'text')
                    <div class="form-group row">
                        <label for="{{ $field->name }}" class="col-2 col-form-label">{{ $name }}</label>
                        <div class="col-10">
                             <textarea class="form-control @error('myForm.' . $field->name) is-invalid @enderror"
                                       name="{{ $field->name }}" rows="3"
                                       id="{{ $field->name }}" wire:model="myForm.{{ $field->name}}"
                             >{{ $field_value }}</textarea>
                            @error('myForm.' . $field->name) <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @elseif($field->type == 'image')
                    <div class="form-group row">
                        <label for="{{ $field->name }}" class="col-2 col-form-label">{{ $name }}</label>
                        <div class="col-10">
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                                       name="{{ $field->name }}[]"
                                       id="{{ $field->name }}" wire:model="images" multiple>
                                <label class="custom-file-label" for="{{ $field->name }}">Choose file</label>
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
                        <label for="{{ $field->name }}" class="col-2 col-form-label">{{ $name }}</label>
                        <div class="col-10">
                            <select
                                class="custom-select form-control @error('myForm.' . $field->name) is-invalid @enderror"
                                name="{{ $field->name }}"
                                id="{{ $field->name }}" wire:model="myForm.{{ $field->name}}">
                                <option selected="selected">Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            @error('myForm.' . $field->name) <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label for="{{ $field->name }}" class="col-2 col-form-label">{{ $name }}</label>
                        <div class="col-10">
                            <input class="form-control @error('myForm.' . $field->name) is-invalid @enderror"
                                   type="text"
                                   name="{{ $field->name }}" value="{{ $field_value }}"
                                   id="{{ $field->name }}" wire:model="myForm.{{ $field->name}}">
                            @error('myForm.' . $field->name) <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="form-group text-center">
                <button type="submit" class="btn btn-success mr-2">Submit</button>
            </div>

            <div wire:loading wire:target="submitForm">
                Processing Payment...
            </div>
        </form>
    @endif
</div>
