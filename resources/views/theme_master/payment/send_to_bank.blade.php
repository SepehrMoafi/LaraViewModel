<form  id="sendToBank" action="https://bpm.shaparak.ir/pgwchannel/startpay.mellat" method="POST">
    <p>در حال انتقال به بانک</p>
    <input type="hidden" id="RefId" name="RefId" value="{{ $ref_id }}">
    <input type="hidden" id="MobileNo" name="MobileNo" value="{{ $mobile }}">
</form>
<script type="text/javascript">document.getElementById("sendToBank").submit();</script>
