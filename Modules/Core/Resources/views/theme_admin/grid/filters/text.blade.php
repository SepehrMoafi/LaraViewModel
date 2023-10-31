
<div>
    <label for="text-filter-{{ $options['name'] }}" class="form-label relative">{{ $options['title'] }} </label>
    <input id="text-filter-{{ $options['name'] }}" type="text" name="{{ $options['name'] }}" class="form-control" placeholder="" value="{{ request($options['name']) }}">
</div>
