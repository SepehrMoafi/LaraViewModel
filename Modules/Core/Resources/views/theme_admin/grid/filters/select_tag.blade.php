<div>
    <label class="form-label relative">{{ $options['title'] }} </label>
    <select class="form-control  js-select-2 " multiple name="{{ $options['name'] }}[]">
        <option value="0">انتخاب کنید ..</option>

        @foreach($options['options'] as $key => $item )
            <option @if( is_array( request($options['name']) ) && in_array($key , request($options['name'])) ) selected @endif value="{{ $key }}">{{ $item }}</option>
        @endforeach
    </select>
</div>

<script>
    $(document).ready(function() {
        $('.js-select-2').select2();
    });
</script>
