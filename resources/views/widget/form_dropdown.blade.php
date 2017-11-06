<select name="{{$name}}" {{ $type }} class="{!! $select2 !!} {!! $class !!} " {!! $extra !!} style="width:100%">

    @if(is_array($option))
        @if ($type != 'multiple')
        <option></option>
        @endif
        @foreach($option as $id => $key)
            @if(is_array($key))
                <optgroup label="{{ $id }}">
                    @foreach($key as $optid => $opt)
                        <option value="{{ $optid }}" {!! (!empty($value) && in_array($optid, $value)) ? 'selected' : '' !!}>{{ $opt }}</option>
                    @endforeach
                </optgroup>
            @else
                <option value="{{ $id }}" {!! (!empty($value) && in_array($id, $value)) ? 'selected' : '' !!}>{{ $key }}</option>
            @endif
        @endforeach
    @else
        @if ($type != 'multiple')
        <option></option>
        @endif
        @foreach($option as $option)
            <option value="{{ $option->id }}" {!! (!empty($value) && in_array($option->id, $value)) ? 'selected' : '' !!}>{{ $option->name }}</option>
        @endforeach
    @endif
</select>
