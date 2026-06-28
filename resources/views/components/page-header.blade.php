<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="mb-0">

            {{ $title }}

        </h2>

        @isset($subtitle)

            <small class="text-muted">

                {{ $subtitle }}

            </small>

        @endisset

    </div>

    @isset($actions)

        <div>

            {{ $actions }}

        </div>

    @endisset

</div>