<div class="card mb-100">
    <div class="card-body">

        <h3>
            @isset($client)
                {{ __('Edit Client') }}
            @else
                {{ __('New Client') }}
            @endisset
        </h3>

        <hr >

        <form 
            method="POST" 
            action="@isset($client) {{ route('admin.clients.update', ['client' => $client]) }}@else {{  route('admin.clients.store') }} @endisset" 
            class="client-form">
            
            @isset($client)
                @method('PUT')
            @endisset

            @csrf()
            @include('admin.parts.alerts')

                <div class='row form-group'>
                    
                    <div class='col-md-12 col-sm-12'>
                        <input type='text' 
                            name='name' 
                            value='@isset($client){{ $client->name }}@else{{ old('name') }}@endisset'
                            placeholder="{{ __('Your name') }}" 
                            class='form-control' 
                            _required
                            />
                    </div>
                </div>
                <div class='row form-group'>

                    <div class='col-md-4 col-sm-12'>
                        <input type='email' 
                            name='email' 
                            value='@isset($client){{ $client->email }}@else{{ old('email')}}@endisset'
                            placeholder="{{ __('Your email') }}" 
                            class='form-control mask-email' 
                            required
                            />
                    </div>
                    
                    <div class='col col-md-4 col-sm-12'>
                        <input type='tel' 
                            name='phone' 
                            value='@isset($client){{ $client->phone }}@else{{ old('phone')}}@endisset'
                            placeholder="{{ __('Your phone') }}" 
                            class='form-control mask-tel' 
                            />
                    </div>
                    
                    <div class='col col-md-4 col-sm-12'>
                        <input type='text' 
                            name='vat' 
                            value='@isset($client){{ $client->vat }}@else{{ old('vat')}}@endisset'
                            placeholder="{{ __('Your vat number') }}" 
                            class='form-control' 
                            />
                    </div>

                </div>

                <div class='row form-group'>

                    <div class='col-md-8 col-sm-12'>   
                        <input type='text' 
                                name='address' 
                                value='@isset($client){{ $client->address }}@else{{ old('address')}}@endisset'
                                placeholder="{{ __('Your adress') }}" 
                                class='form-control' 
                                />
                    </div>

                    <div class='col-md-4 col-sm-12'>
                        <input type='text' 
                            name='zip_code' 
                            value='@isset($client){{ $client->zip_code }}@else{{ old('zip_code')}}@endisset'
                            placeholder="{{ __('Your zip code') }}" 
                            class='form-control' 
                            />
                    </div>

                </div>

                <div class='row form-group'>
                    <div class='col-md-8 col-sm-12'>
                        <input type='text' 
                            name='city' 
                            value='@isset($client){{ $client->city }}@else{{ old('city')}}@endisset'
                            placeholder="{{ __('Your city') }}" 
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
                        @isset($user)
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