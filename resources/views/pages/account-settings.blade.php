{{--
    Account Settings - Página de Configurações da Conta
    
    Esta view permite ao usuário gerenciar suas configurações pessoais:
    - Upload e gerenciamento de foto de perfil
    - Edição de informações pessoais (nome, email, organização)
    - Configurações de localização (endereço, estado, país)
    - Preferências de idioma, timezone e moeda
    - Alteração de senha com validação de requisitos
    - Opção de desativação/exclusão de conta
    
    Todos os formulários incluem proteção CSRF via @csrf.
--}}
@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="row">
    <div class="col-md-12">
        {{-- Account Details Card - Informações principais da conta --}}
        <div class="card mb-4">
            <h5 class="card-header">Account Details</h5>
            <div class="card-body">
                {{-- Avatar Upload Section - Upload de foto de perfil --}}
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    {{-- Avatar atual gerado dinamicamente via UI Avatars --}}
                    <img src="https://ui-avatars.com/api/?name=John+Doe&size=100&background=696cff&color=fff" alt="user-avatar" class="d-block rounded" height="100" width="100" />
                    <div class="button-wrapper">
                        {{-- Botão de upload com input file oculto --}}
                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
                        </label>
                        <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
                            <i class="ti ti-refresh d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                        </button>
                        <p class="mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                    </div>
                </div>
            </div>
            <hr class="my-0">
            <div class="card-body">
                {{-- Account Settings Form - Formulário de configurações da conta --}}
                <form id="formAccountSettings" method="POST">
                    @csrf
                    <div class="row">
                        {{-- Campos de informações pessoais organizados em grid responsivo --}}
                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input class="form-control" type="text" id="firstName" name="firstName" value="John" autofocus />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" value="Doe" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control" type="email" id="email" name="email" value="john.doe@example.com" placeholder="john.doe@example.com" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Organization</label>
                            <input type="text" class="form-control" id="organization" name="organization" value="Vuexy Inc." />
                        </div>
                        {{-- Phone Number com código de país --}}
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber">Phone Number</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">US (+1)</span>
                                <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="202 555 0111" />
                            </div>
                        </div>
                        {{-- Campos de endereço --}}
                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">State</label>
                            <input class="form-control" type="text" id="state" name="state" placeholder="California" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="zipCode" class="form-label">Zip Code</label>
                            <input type="text" class="form-control" id="zipCode" name="zipCode" placeholder="231465" maxlength="6" />
                        </div>
                        {{-- Dropdowns de preferências --}}
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="country">Country</label>
                            <select id="country" class="form-select">
                                <option value="">Select Country</option>
                                <option value="USA">United States</option>
                                <option value="UK">United Kingdom</option>
                                <option value="Canada">Canada</option>
                                <option value="Australia">Australia</option>
                                <option value="Germany">Germany</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="language" class="form-label">Language</label>
                            <select id="language" class="form-select">
                                <option value="">Select Language</option>
                                <option value="en" selected>English</option>
                                <option value="fr">French</option>
                                <option value="de">German</option>
                                <option value="pt">Portuguese</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="timezone" class="form-label">Timezone</label>
                            <select id="timezone" class="form-select">
                                <option value="">Select Timezone</option>
                                <option value="UTC-12">(GMT-12:00) International Date Line West</option>
                                <option value="UTC-11">(GMT-11:00) Midway Island, Samoa</option>
                                <option value="UTC-10">(GMT-10:00) Hawaii</option>
                                <option value="UTC-9">(GMT-09:00) Alaska</option>
                                <option value="UTC-8" selected>(GMT-08:00) Pacific Time (US & Canada)</option>
                                <option value="UTC-7">(GMT-07:00) Mountain Time (US & Canada)</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="currency" class="form-label">Currency</label>
                            <select id="currency" class="form-select">
                                <option value="">Select Currency</option>
                                <option value="usd" selected>USD</option>
                                <option value="euro">Euro</option>
                                <option value="pound">Pound</option>
                                <option value="bitcoin">Bitcoin</option>
                            </select>
                        </div>
                    </div>
                    {{-- Botões de ação do formulário --}}
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Change Password Card - Alteração de senha --}}
        <div class="card mb-4">
            <h5 class="card-header">Change Password</h5>
            <div class="card-body">
                <form id="formChangePassword" method="POST">
                    @csrf
                    {{-- Alerta com requisitos de senha --}}
                    <div class="alert alert-warning" role="alert">
                        <h6 class="alert-heading mb-1">Ensure that these requirements are met</h6>
                        <span>Minimum 8 characters long, uppercase & symbol</span>
                    </div>
                    <div class="row">
                        {{-- Campo de senha atual com toggle de visibilidade --}}
                        <div class="mb-3 col-md-6 form-password-toggle">
                            <label class="form-label" for="currentPassword">Current Password</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="password" name="currentPassword" id="currentPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- Campos de nova senha e confirmação --}}
                        <div class="mb-3 col-md-6 form-password-toggle">
                            <label class="form-label" for="newPassword">New Password</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="password" id="newPassword" name="newPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6 form-password-toggle">
                            <label class="form-label" for="confirmPassword">Confirm New Password</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        {{-- Lista de requisitos de senha --}}
                        <div class="col-12 mb-4">
                            <h6>Password Requirements:</h6>
                            <ul class="ps-3 mb-0">
                                <li class="mb-1">Minimum 8 characters long - the more, the better</li>
                                <li class="mb-1">At least one lowercase character</li>
                                <li>At least one number, symbol, or whitespace character</li>
                            </ul>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary me-2">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Delete Account Card - Desativação/exclusão de conta --}}
        <div class="card">
            <h5 class="card-header">Delete Account</h5>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    {{-- Alerta de aviso sobre exclusão permanente --}}
                    <div class="alert alert-warning">
                        <h6 class="alert-heading mb-1">Are you sure you want to delete your account?</h6>
                        <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                    </div>
                </div>
                <form id="formAccountDeactivation">
                    {{-- Checkbox de confirmação obrigatório --}}
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" />
                        <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
                    </div>
                    <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
