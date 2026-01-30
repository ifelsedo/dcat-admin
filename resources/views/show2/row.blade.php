@foreach($fields as $field)
    @php
    $reflectionClass = new ReflectionClass($field['element']);
    $property = $reflectionClass->getProperty('view');
    $property->setAccessible(true);
    $property->setValue($field['element'], 'admin.show.field');
    @endphp
    {!! $field['element']->wrap(false)->render() !!}
@endforeach
