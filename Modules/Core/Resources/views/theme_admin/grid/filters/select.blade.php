<div>
    <label class="form-label relative">{{ $options['title'] }} </label>
    <select class="form-control" name="{{ $options['name'] }}">
        <option value="0">انتخاب کنید ..</option>
        @foreach($options['options'] as $key => $item )
            <option @if($key == request($options['name']) ) selected @endif value="{{ $key }}">{{ $item }}</option>
        @endforeach
    </select>
</div>
