<link rel="stylesheet" href="{{ asset('assets/theme_admin/dist/jdate/persian-datepicker.min.css') }}"/>
<div class="">
    <label for="post-form-2" class="form-label">{{ $options['title'] }}</label>
    <input name="{{ $options['name'] }}" class="form-control example1"
           @php
               $value = '';
               if ( request($options['name']) ){
                 $value =  \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y-m-d', request($options['name']) )->format('Y-m-d');
               }
           @endphp
           value="{{ $value }}"
           id="post-form-2" data-single-mode="true">
    @error('post_date')
    <div class="alert-danger-soft">{{ $message }}</div>
    @enderror
</div>

