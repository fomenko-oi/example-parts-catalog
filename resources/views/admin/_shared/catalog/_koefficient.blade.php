<form action="{{ $url }}" method="POST" class="{{ $class ?? 'col-md-1 offset-md-11' }}">
    @csrf

    <label for="koefficient_value">Koefficient</label>
    <div class="input-group mb-3">
        <input id="koefficient_value" class="form-control" type="text" value="{{ $koefficient ?? '' }}" name="value"/>
        <div class="input-group-append"><span class="input-group-text" id="basic-addon2">%</span></div>
    </div>
</form>
