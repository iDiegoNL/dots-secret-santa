<x-filament-widgets::widget>
    <x-filament::section icon="heroicon-o-question-mark-circle">
        <x-slot name="heading">
            Help your Secret Santa!
        </x-slot>

        <x-slot name="description">
            Provide some hints to help your Secret Santa choose the perfect gift for you.
        </x-slot>

        <form wire:submit="create">
            {{ $this->form }}

            <x-filament::button type="submit">
                Save hints
            </x-filament::button>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
