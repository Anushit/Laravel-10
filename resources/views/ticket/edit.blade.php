<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex justify-center">
        <h3>Update Ticket Form</h3>
    </div>

    <form method="POST" action="{{ route('ticket.update', $ticket->id)}}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- title here -->
        <div>
            <x-input-label for="title" :value="__('title')" />
            <x-text-input id="title" class="block mt-1 w-full"  type="title" name="title"  autofocus autocomplete="username" value="{{$ticket->title}}"/>
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <!-- description here -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('description')" />
            <x-textarea id="description" name="description" value="{{$ticket->description}}"/>

            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

         <!-- title here -->
         <div>
         <?php if($ticket->attachment) : ?>
            <td><a href="{{ '/storage/'.$ticket->attachment }}" target="_blank">Attachment</a></td>
        <?php endif ?>
            <x-input-label for="attachment" :value="__('attachment (if any)')" />
            <x-file-input id="attachment"  name="attachment" />
            <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">
          
            <x-primary-button class="ml-3">
                Update Ticket
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>