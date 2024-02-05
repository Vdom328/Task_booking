<option value=""></option>
@foreach ($data as $item)
    <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
@endforeach

