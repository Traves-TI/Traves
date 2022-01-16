<div class="card mb-20">
    <div class="card-body">
       
        <h3>
            @if(isset($companyTypeRequest) and !(empty($companyTypeRequest)))
                {{ __('Edit Company Type') }}
            @else
                {{ __('New Company Type') }}
            @endif
        </h3>
        <hr >
        
            <form 
            method="POST" 
            action="@if(isset($companyTypeRequest) and !(empty($companyTypeRequest))) {{ route('admin.company-type.update', ['company_type' => $companyTypeRequest]) }}@else {{  route('admin.company-type.store') }} @endif" 
            class="company-form">
                @if(isset($companyTypeRequest) and !(empty($companyTypeRequest)))
                    @method('PUT')
                @endif
            @csrf

            @include('admin.parts.alerts')

            <div class='row form-group'>
                
                <div class='col-md-6 col-sm-12'>
                    <input type='text' 
                        name='type' 
                        value='@if(isset($companyTypeRequest) and !(empty($companyTypeRequest))){{ $companyTypeRequest->type }}@else{{ old('type') }}@endif'
                        placeholder="{{ __('Name') }}" 
                        class='form-control' 
                        required
                    />
                </div>
            </div>
            <div class='row form-group'>
                <div class='col-md-12 text-right'>
                    <button class='btn btn-success'>
                        @if(isset($companyTypeRequest) and !(empty($companyTypeRequest)))
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
