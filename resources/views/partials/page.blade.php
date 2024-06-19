<p>{{$message}}</p>
<script>
setInterval(function() {
        '{{$message}}'==="Successfully verified" && '{{!$user}}'?
            window.location.replace(`http://localhost:5173/`)
        :
            window.close()
    }, 1000);
</script>


