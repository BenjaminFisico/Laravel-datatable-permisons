<div class="mt-4">
    <label for="{{$inputName}}" class="block text-sm font-medium text-gray-700">{{$label}}</label>
    <div class="mt-1 relative rounded-md shadow-sm flex">
        <input type="{{$type}}" name="{{$inputName}}" placeholder="{{$placeholder}}"
        wire:model="{{$inputName}}"
        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
    </div>
    @if($errors->has($inputName))
        <smaill class="text-red-600">{{$errors->first($inputName)}}</smaill>
    @endif
</div>