@extends('adminlte::page')

@section('title', 'Site Settings')

@section('content_header')
    <h1>
        <i class="fas fa-cogs"></i> Site Settings
    </h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-cog"></i>
                            Configure Site Settings
                        </h3>
                    </div>

                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @foreach($settingEnum as $enum)
                                @php
                                    $fieldType = $enum->fieldType();
                                    $value = $settings[$enum->name()] ?? $enum->defaultValue();
                                @endphp

                                <div class="form-group">
                                    @if($fieldType === 'checkbox')
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   id="{{ $enum->name() }}"
                                                   name="{{ $enum->name() }}"
                                                   value="1"
                                                    {{ $value ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="{{ $enum->name() }}">
                                                {{ $enum->label() }}
                                            </label>
                                        </div>
                                    @elseif($fieldType === 'select')
                                        <label for="{{ $enum->name() }}">{{ $enum->label() }}</label>
                                        <select class="form-control @error($enum->name()) is-invalid @enderror"
                                                id="{{ $enum->name() }}"
                                                name="{{ $enum->name() }}">
                                            @foreach($enum->options() as $optionValue => $optionLabel)
                                                <option value="{{ $optionValue }}"
                                                        {{ $value == $optionValue ? 'selected' : '' }}>
                                                    {{ $optionLabel }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error($enum->name())
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    @else
                                        <label for="{{ $enum->name() }}">{{ $enum->label() }}</label>
                                        <input type="{{ $fieldType }}"
                                               class="form-control @error($enum->name()) is-invalid @enderror"
                                               id="{{ $enum->name() }}"
                                               name="{{ $enum->name() }}"
                                               value="{{ old($enum->name(), $value) }}"
                                               @if($fieldType === 'number') step="1" min="1" @endif>
                                        @error($enum->name())
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        console.log('Settings page loaded');
    </script>
@stop
