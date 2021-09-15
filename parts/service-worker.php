<script>
  if ("serviceWorker" in navigator) {
    window.addEventListener("load", function() {
      navigator.serviceWorker.register("https://ubuntu-2nd/thechat/sw.js").then(
        function(registration) {
          console.log(
            "ServiceWorker registration successful with scope: ",
            registration.scope
          );
        },
        function(err) {
          console.log("ServiceWorker registration failed: ", err);
        }
      );
    });
  }
</script>