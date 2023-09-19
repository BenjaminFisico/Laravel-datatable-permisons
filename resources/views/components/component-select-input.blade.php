<div>
    <label for="{{$inputName}}" class="block text-sm font-medium text-gray-700">{{$label}}</label>
    <select wire:model="{{$inputName}}"
            wire:change="{{$functionOnChange}}"
            class="focus:ring-indigo-500 focus:border-indigo-500 block pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
        @if($firstOption)
            <option value="">{{$firstOption}}</option>
        @endif
        @foreach($options as $key => $option)
            <option value="{{$key}}">{{$option}}</option>
        @endforeach
    </select>
    @if($errors->has($inputName))
        <smaill class="text-red-600">{{$errors->first($inputName)}}</smaill>
    @endif
</div>