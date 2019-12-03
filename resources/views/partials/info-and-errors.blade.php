@if (session()->has('info'))
<div class="alert alert-success" role="alert">
  {{ session()->get('info') }}
</div>
@elseif (session()->has('error'))
<div class="alert alert-danger" role="alert">
  {{ session()->get('error') }}
</div>
@endif