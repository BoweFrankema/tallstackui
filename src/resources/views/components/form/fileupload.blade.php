@php
    if (!$livewire) throw new Exception('The [fileupload] component must be used in a Livewire component.');
    if ($deletable && !method_exists($this, $method)) throw new Exception('The [fileupload] component delete method [' . $method . '] does not exist in [' . get_class($this) . '].');
    [$property] = $bind($attributes, null, $livewire);
    $personalize = $classes();
    $value = $__livewire->{$property};
    $placeholder = __('tallstack-ui::messages.fileupload.placeholder');
@endphp

<div x-data="tallstackui_formUpload(
        @js($__livewire->getId()),
        @js($property),
        @js($multiple),
        @js($error),
        @js($placeholder),
        @js(__('tallstack-ui::messages.fileupload.uploaded')))"
     x-ref="wrapper"
     x-cloak
     x-on:livewire-upload-start="uploading = true"
     x-on:livewire-upload-finish="uploading = false"
     x-on:livewire-upload-error="uploading = false"
     x-on:livewire-upload-progress="progress = $event.detail.progress"
     @class(['relative rounded-md shadow-sm'])>
     <x-input :value="$placeholder"
              :$label
              :$hint
              x-on:click="show = !show"
              x-ref="input"
              readonly
              icon="arrow-up-tray"
              class="cursor-pointer"
              position="right"
              invalidate />
    <div x-show="preview"
        @class($personalize['preview.wrapper.first'])
        x-on:click="preview = false; show = true"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div @class($personalize['preview.backdrop'])></div>
    </div>
    <div x-show="preview"
         @class($personalize['preview.wrapper.second'])
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 sm:scale-95"
         x-transition:enter-end="opacity-100 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 sm:scale-100"
         x-transition:leave-end="opacity-0 sm:scale-95">
         <div class="relative">
            <button class="absolute -top-10 -right-5 h-10 w-10" x-on:click="preview = false; show = true">
                <x-dynamic-component :component="TallStackUi::component('icon')"
                                     icon="x-mark"
                                     class="h-5 w-5 text-white dark:text-dark-300" />
            </button>
         </div>
        <img x-bind:src="image" />
    </div>
    <div x-cloak
         x-show="show"
         x-on:click.away="show = false"
         x-transition:enter="transition duration-100 ease-out"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         x-anchor.bottom-end="$refs.wrapper"
         @class($personalize['box.wrapper'])>
        <div @class($personalize['box.base'])>
            <div @class(['flex w-full items-center justify-center', 'mb-2' => $footer->isNotEmpty()])>
                <label for="dropzone-file" @class($personalize['placeholder.wrapper'])>
                    <div class="inline-flex items-center justify-center space-x-2">
                        <x-dynamic-component :component="TallStackUi::component('icon')"
                                             icon="cloud-arrow-up"
                                             outline
                                             @class($personalize['placeholder.icon']) />
                        <p @class($personalize['placeholder.title'])>
                            {{ __('tallstack-ui::messages.fileupload.upload') }}
                        </p>
                    </div>
                    @if (is_string($tip))
                        <p @class($personalize['placeholder.tip'])>{{ $tip }}</p>
                    @else
                        {{ $tip }}
                    @endif
                    <input id="dropzone-file"
                            type="file"
                            class="hidden"
                            x-ref="files"
                            x-on:change="upload()"
                            @if ($multiple) multiple @endif />
                </label>
            </div>
            <div @class($personalize['error.wrapper']) x-show="@js($error) && error">
                <p @class($personalize['error.message']) x-text="warning"></p>
            </div>
            <div x-show="uploading" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" @class($personalize['upload.wrapper'])>
                <div @class($personalize['upload.progress']) x-bind:style="'width: ' + progress + '%'"></div>
            </div>
            @if ($value)
                <div @class($personalize['item.wrapper']) x-ref="items">
                    @php /** @var \Illuminate\Http\UploadedFile $file */ @endphp
                    <ul role="list" @class($personalize['item.ul'])>
                        @foreach(\Illuminate\Support\Arr::wrap($value) as $key => $file)
                            <li @class($personalize['item.li'])>
                                <div class="flex min-w-0 gap-x-4">
                                    @if (in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ $file->temporaryUrl() }}"
                                         x-on:click="image = @js($file->temporaryUrl()); preview = true; show = false"
                                         class="h-12 w-12 flex-none cursor-pointer rounded-full bg-gray-50">
                                    @else
                                        <x-dynamic-component :component="TallStackUi::component('icon')"
                                                             icon="document-text"
                                                             class="h-5 w-5 flex-shrink-0 text-primary-500 dark:text-dark-300" />
                                    @endif
                                    <div class="min-w-0 flex-auto">
                                        <p @class($personalize['item.title'])>{{ $file->getClientOriginalName() }}</p>
                                        <x-dynamic-component :component="TallStackUi::component('error')"
                                                             :property="$property . '.' . $key" />
                                        <p @class($personalize['item.size'])>
                                            <span>{{ __('tallstack-ui::messages.fileupload.size') }}: </span>
                                            @if (class_exists(\Illuminate\Support\Number::class))
                                                <span>{{ \Illuminate\Support\Number::fileSize($file->getSize()) }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="flex shrink-0 flex-col items-end">
                                    @if ($deletable)
                                        <button type="button" x-on:click="remove(@js($method), @js($file->getClientOriginalName()), @js($file->getFilename()))">
                                            <x-dynamic-component :component="TallStackUi::component('icon')" icon="trash" @class($personalize['item.delete']) />
                                        </button>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($footer->isNotEmpty())
                {{ $footer }}
            @endif
        </div>
    </div>
</div>
