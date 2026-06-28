@props([
    'title' => null,
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'card shadow-sm']) }}>

    @if($title || isset($tools))

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>

                @if($title)

                    <h3 class="card-title mb-0">

                        {{ $title }}

                    </h3>

                @endif

                @if($subtitle)

                    <small class="text-muted">

                        {{ $subtitle }}

                    </small>

                @endif

            </div>

            @isset($tools)

                <div>

                    {{ $tools }}

                </div>

            @endisset

        </div>

    @endif

    <div class="card-body">

        {{ $slot }}

    </div>

    @isset($footer)

        <div class="card-footer">

            {{ $footer }}

        </div>

    @endisset

</div>