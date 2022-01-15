<div class="card mb-100">
    <div class="card-body">

        <h3>
            @isset($company)
                {{ __('Edit Company') }}
            @else
                {{ __('New Company') }}
            @endisset
        </h3>

        <hr >

        <form 
            method="POST" 
            action="@isset($company) {{ route('admin.company.update', ['company' => $company]) }}@else {{  route('admin.company.store') }} @endisset" 
            class="company-form">
            
            @isset($company)
                @method('PUT')
            @endisset

            @csrf()
            @include('admin.parts.alerts')

                <div class='row form-group'>
                    
                    <div class='col-md-12 col-sm-12'>
                        <input type='text' 
                            name='name' 
                            value='@isset($company){{ $company->name }}@else{{ old('name') }}@endisset'
                            placeholder="{{ __('Company name') }}" 
                            class='form-control' 
                            required
                            />
                    </div>
                </div>
                <div class='row form-group'>

                    <div class='col-md-4 col-sm-12'>
                        <input type='email' 
                            name='email' 
                            value='@isset($company){{ $company->email }}@else{{ old('email')}}@endisset'
                            placeholder="{{ __('Company email') }}" 
                            class='form-control mask-email' 
                            required
                            />
                    </div>
                    
                    <div class='col col-md-4 col-sm-12'>
                        <input type='tel' 
                            name='phone' 
                            value='@isset($company){{ $company->phone }}@else{{ old('phone')}}@endisset'
                            placeholder="{{ __('Company phone') }}" 
                            class='form-control mask-tel' 
                            />
                    </div>
                    
                    <div class='col col-md-4 col-sm-12'>
                        <input type='text' 
                            name='vat_id' 
                            value='@isset($company){{ $company->vat_id }}@else{{ old('vat_id')}}@endisset'
                            placeholder="{{ __('VAT ID number') }}" 
                            class='form-control' 
                            required
                            />
                    </div>

                </div>

                <div class='row form-group'>

                    <div class='col-md-8 col-sm-12'>   
                        <input type='text' 
                                name='address' 
                                value='@isset($company){{ $company->address }}@else{{ old('address')}}@endisset'
                                placeholder="{{ __('Company adress') }}" 
                                class='form-control' 
                                />
                    </div>

                    <div class='col-md-4 col-sm-12'>
                        <input type='text' 
                            name='zip_code' 
                            value='@isset($company){{ $company->zip_code }}@else{{ old('zip_code')}}@endisset'
                            placeholder="{{ __('Company zip code') }}" 
                            class='form-control' 
                            />
                    </div>

                </div>

                <div class='row form-group'>
                    <div class='col-md-8 col-sm-12'>
                        <input type='text' 
                            name='city' 
                            value='@isset($company){{ $company->city }}@else{{ old('city')}}@endisset'
                            placeholder="{{ __('Company city') }}" 
                            class='form-control' 
                            />
                    </div>

                    <div class='col-md-4 col-sm-12'>       
                        <select name='country' 
                                class='form-control'
                                required 
                                >
                                <option value='123'>Portugal</option>
                        </select>
                    </div>

                </div>
            

            <div class='row form-group'>
                <div class='col-md-12'>
                    <button class='btn btn-success'>
                        @isset($company)
                        {{ __('Save') }}
                    @else
                        {{ __ ('Submit') }}
                        @endisset

                    </button>
                </div>
            </div>


        </form>
    </div>
</div>