<div class="w3-bar w3-border w3-light-grey">
  <a href="http://localhost/spotify/public/" class="w3-bar-item w3-button w3-sand">Home</a>
</div>
@if(session()->has('error'))
    <div class="w3-sand">
        {{ session()->get('error') }}
    </div>
@endif