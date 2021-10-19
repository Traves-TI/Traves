
<form 
    method="POST" 
    action="@isset($client) {{ route('admin.clients.update', ['client' => $client]) }} @else {{ route('admin.clients.store') }} @endisset" 
    class="client-form">
    
    @isset($client)
        @method('PUT')
    @endisset

    @csrf()

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class='row form-group'>

        <div class='col-md-6 col-sm-12'>
            <input type='text' 
                name='name' 
                placeholder="{{ __('Your name') }}" 
                class='form-control' 
                _required
                />
        </div>

        <div class='col-md-3 col-sm-12'>
            <input type='email' 
                name='email' 
                placeholder="{{ __('Your email') }}" 
                class='form-control mask-email' 
                required
                />
        </div>
        
        <div class='col col-md-3 col-sm-12'>
            <input type='tel' 
                name='phone' 
                placeholder="{{ __('Your phone') }}" 
                class='form-control mask-tel' 
                />
        </div>

    </div>

    <div class='row form-group'>

        <div class='col-md-3 col-sm-12'>   
            <input type='text' 
                    name='address' 
                    placeholder="{{ __('Your adress') }}" 
                    class='form-control' 
                    />
        </div>

        <div class='col-md-3 col-sm-12'>
            <input type='text' 
                name='zip_code' 
                placeholder="{{ __('Your zip code') }}" 
                class='form-control' 
                />
        </div>

        <div class='col-md-3 col-sm-12'>
            <input type='text' 
                name='city' 
                placeholder="{{ __('Your city') }}" 
                class='form-control' 
                />
        </div>

        <div class='col-md-3 col-sm-12'>       
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
                    {{ __('Submit') }}
                @endisset

            </button>
        </div>
    </div>

    </div>

</form>
