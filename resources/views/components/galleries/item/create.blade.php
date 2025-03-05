 <form method="POST" action="{{ route('galleries.img.store', $gallery->id) }}" class='flex gap-4 mb-4'>
     @csrf
     @method('POST')

     <fieldset>
         <label for="title" class='text-lg'>Item Title:</label>
         <x-text-input id="title" name="title" type="text" required autofocus autocomplete="name" />
     </fieldset>
     <fieldset>
         <label for="image" class='text-lg'>Item URL:</label>
         <x-text-input id="image" name="image" type="text" required />
     </fieldset>

     <x-primary-button class='create-btn '>{{ __('Create Gallery Item') }}</x-primary-button>
 </form>
