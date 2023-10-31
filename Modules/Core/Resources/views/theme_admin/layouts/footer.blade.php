</div>
</div>
<!-- BEGIN: Dark Mode Switcher-->
<!--        <div data-url="index-dark.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 left-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 ml-10">-->
<!--            <div class="ml-4 text-gray-700 dark:text-gray-300">حالت تیره</div>-->
<!--            <div class="dark-mode-switcher__toggle border"></div>-->
<!--        </div>-->
<!-- END: Dark Mode Switcher-->
<!-- BEGIN: JS Assets-->
{{--<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>--}}
{{--<script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>--}}
<script src="{{asset('assets/theme_admin/dist/js/jquery-3.6.4.min.js')}}"></script>

<script src="{{asset('assets/theme_admin/dist/js/select2.min.js')}}"></script>

<script src="{{asset('assets/theme_admin/dist/js/app.js')}}"></script>

<!-- begin::dropzone -->
<script src="{{asset('assets/theme_admin/dist/js/dropzone.min.js')}}"></script>
<script>
     Dropzone.autoDiscover = false;
</script>

<script src="{{ asset('assets/theme_admin/dist/jdate/persian-date.min.js') }}"></script>
<script src="{{ asset('assets/theme_admin/dist/jdate/persian-datepicker.min.js') }}"></script>

<script>
    $(document).ready(function() {


        $(".example1").pDatepicker(
            {
                initialValueType: 'gregorian',
                format: 'YYYY-MM-DD',
                calendar:{
                    persian: {
                        locale: 'en'
                    }
                }

            }
        );

        $('.js-select-tag').select2({
            'tags': true,
        });

        $('.js-select-2').select2();
    });
</script>

@yield('scripts')
<!-- END: JS Assets-->
</body>
</html>
