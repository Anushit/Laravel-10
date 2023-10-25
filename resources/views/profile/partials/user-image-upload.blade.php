<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
           Uploade Image Information
        </h2>
        <?php if(auth()->user()->image){ ?>
         <img src="{{ asset('storage/'.auth()->user()->image) }}" alt="" width="50" height="50">
        <?php }else{
            echo "No Image Found";
        } ?>
        

    </header>


    <form method="post" action="{{ route('profile.uploadeImage') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="image" value="Profile Image" />
            <x-text-input id="image" name="image" type="file" class="mt-1 block w-full" :value="old('image', $user->image)" autofocus autocomplete="image" />
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

       
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
