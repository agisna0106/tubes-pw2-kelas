<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Supervisor Dashboard
        </h2>
    </x-slot>

    <div class="py-6 mx-6">

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            <x-stat-card
                title="Total Categories"
                :value="$totalCategories"
                icon="fa-solid fa-tags"
                color="blue"/>

            <x-stat-card
                title="Total Products"
                :value="$totalProducts"
                icon="fa-solid fa-box"
                color="green"/>

            <x-stat-card
                title="Current Stock"
                :value="$currentStock"
                icon="fa-solid fa-warehouse"
                color="yellow"/>

            <x-stat-card
                title="Low Stock"
                :value="$lowStockCount"
                icon="fa-solid fa-triangle-exclamation"
                color="red"/>

        </div>

    </div>

</x-app-layout>
