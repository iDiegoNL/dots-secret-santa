<x-filament-widgets::widget>
    <x-filament::section icon="heroicon-o-gift">
        <x-slot name="heading">
            You're giving to... {{ $givingTo->decoded_name }}
        </x-slot>

        <x-slot name="description">
            Here are some hints to help you choose the perfect gift.
        </x-slot>

        {{ $this->givingToInfolist }}
    </x-filament::section>
</x-filament-widgets::widget>
