<!--**********************************
        Footer start
    ***********************************-->
<div class="footer">
    <div class="copyright">
        <p>کپی رایت © ارائه توسط <a href="https://zafre.com">ZafreMedia</a> 1401</p>
    </div>
</div>
<!--**********************************
    Footer end
***********************************-->

<!--**********************************
   Support ticket button start
***********************************-->

<!--**********************************
   Support ticket button end
***********************************-->


</div>
<!--**********************************
    Main wrapper end
***********************************-->

<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{asset('assets/theme_admin/vendor/global/global.min.js')}}"></script>
<script src="{{asset('assets/theme_admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('assets/theme_admin/vendor/chart.js/Chart.bundle.min.js')}}"></script>
<script src="{{asset('assets/theme_admin/js/custom.min.js')}}"></script>
<script src="{{asset('assets/theme_admin/js/deznav-init.js')}}"></script>
<!-- Datatable -->
<script src="{{asset('assets/theme_admin/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script>
    (function ($) {
        var table = $('#example5').DataTable({
            searching: false,
            paging: true,
            select: false,
            //info: false,
            lengthChange: false

        });
        $('#example tbody').on('click', 'tr', function () {
            var data = table.row(this).data();

        });
    })(jQuery);
</script>


</body>

</html>
