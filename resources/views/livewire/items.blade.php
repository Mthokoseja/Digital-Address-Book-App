<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <!-- Display a message if a session message exists -->
    @if(session()->has('message'))
    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 relative" role="alert" x-data="{show: true}" x-show="show">
       <p>{{ session('message') }}</p>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="show = false">
            <!-- Close button using SVG icon -->
            <svg class="fill-current h-6 w-6 text-white" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>
    @endif
    <div class="mt-8 text-2xl flex justify-between">
        <div>Contacts</div> 
        <div class="mr-2">
              <!-- Button to trigger adding a new contact -->
            <x-jet-button wire:click="confirmItemAdd" class="bg-black-500 hover:bg-blue-700">
                Add New Contact
            </x-jet-button>
        </div>
    </div>

    <div class="mt-6">
        <div class="flex justify-between">
          
        </div>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <!-- Table header with column headers for sorting -->
                            <button wire:click="sortBy('id')">ID</button>
                            <x-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('name')">Name</button>
                            <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('email')">Email</button>
                            <x-sort-icon sortField="email" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('address')">Address</button>
                            <x-sort-icon sortField="address" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('phone')">Phone</button>
                            <x-sort-icon sortField="phone" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('birthday')">Birthday</button>
                            <x-sort-icon sortField="birthday" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th><th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('notes')">Notes</button>
                            <x-sort-icon sortField="notes" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                   
                    
                    <th class="px-4 py-2">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through the items to display each contact's data -->
                @foreach($items as $item)
                    <tr>
                         <!-- Display each contact's data in table cells -->
                        <td class="border px-4 py-2">{{ $item->id}}</td>
                        <td class="border px-4 py-2">{{ $item->name}}</td>
                        <td class="border px-4 py-2">{{ $item->email}}</td>
                        <td class="border px-4 py-2">{{ $item->address}}</td>
                        <td class="border px-4 py-2">{{ $item->phone}}</td>
                        <td class="border px-4 py-2">{{ $item->birthday}}</td>
                        <td class="border px-4 py-2">{{ $item->notes}}</td>
                       
                        <td class="border px-4 py-2">
                        <x-jet-button wire:click="confirmItemEdit( {{ $item->id}})" class="bg-orange-500 hover:bg-orange-700">
                            Edit
                        </x-jet-button>
                            <x-jet-danger-button wire:click="confirmItemDeletion( {{ $item->id}})" wire:loading.attr="disabled">
                                Delete
                            </x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>

    <x-jet-confirmation-modal wire:model="confirmingItemDeletion">
        <x-slot name="title">
            {{ __('Delete Contact') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete Contact? ') }}
        </x-slot>
<!-- Modal for confirming contact deletion -->
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingItemDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteItem({{ $confirmingItemDeletion }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
<!-- Modal for confirming contact addition/editing -->
    <x-jet-dialog-modal wire:model="confirmingItemAdd">
        <x-slot name="title">
            {{ isset( $this->item->id) ? 'Edit Contact' : 'Add Contact'}}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="item.name" />
                <x-jet-input-error for="item.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" type="text" class="mt-1 block w-full" wire:model.defer="item.email" />
                <x-jet-input-error for="item.email" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="address" value="{{ __('Address') }}" />
                <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="item.address" />
                <x-jet-input-error for="item.address" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="phone" value="{{ __('Phone') }}" />
                <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="item.phone" />
                <x-jet-input-error for="item.phone" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="birthday" value="{{ __('Birthday') }}" />
                <x-jet-input id="birthday" type="date" class="mt-1 block w-full" wire:model.defer="item.birthday" />
                <x-jet-input-error for="item.birthday" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="notes" value="{{ __('Notes') }}" />
                <x-jet-input id="notes" type="text" class="mt-1 block w-full" wire:model.defer="item.notes" />
                <x-jet-input-error for="item.notes" class="mt-2" />
            </div>

          

           
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingItemAdd', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="saveItem()" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>