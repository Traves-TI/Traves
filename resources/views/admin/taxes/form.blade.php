<div class="card mb-20">
    <div class="card-body">
       
        <h3>
            @if(isset($tax) and !(empty($tax)))
                {{ __('Edit Tax') }}
            @else
                {{ __('New Tax') }}
            @endif
        </h3>
        <hr >

            <form 
            method="POST" 
            action="@if(isset($tax) and !(empty($tax))) {{ route('admin.tax.update', ['tax' => $tax]) }}@else {{  route('admin.tax.store') }} @endif" 
            class="company-form">
            @if(isset($tax) and !(empty($tax)))
                @method('PUT')
            @endif
            @csrf

            @include('admin.parts.alerts')

            <div class='row form-group'>
                
                <div class='col-md-6 col-sm-12'>
                    <input type='text' 
                        name='name' 
                        value='@if(isset($tax) and !(empty($tax))){{ $tax->name }}@else{{ old('name') }}@endif'
                        placeholder="{{ __('Name') }}" 
                        class='form-control' 
                        required
                    />
                </div>
                <div class='col-md-6 col-sm-12'>
                    <input type='number' 
                        name='value' 
                        value='@if(isset($tax) and !(empty($tax))){{ $tax->value }}@else{{ old('value') }}@endif'
                        placeholder="{{ __('Value') }}" 
                        class='form-control' 
                        required
                    />
                </div>
            </div>
            <div class='row form-group'>
                <div class='col-md-12 text-right'>
                    <button class='btn btn-success'>
                        @if(isset($tax) and !(empty($tax)))
                        {{ __('Save') }}
                    @else
                        {{ __ ('Submit') }}
                        @endif
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
